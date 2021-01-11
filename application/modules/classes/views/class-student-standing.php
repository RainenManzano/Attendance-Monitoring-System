    <div class="container-fluid" id="container">
    	<div class="row">
    		<div class="alert alert-success">
    				<strong>SCHEDULE</strong>
    				<div style="margin-left:10px;">
    					<?php 
    						foreach($schedule->result() as $sched) {
    							echo "<div>";
    							echo $sched->Day.": ".$sched->Beginning_Time. " - ". $sched->End_Time;
    							echo "</div>";
    						}
    					?>
    				</div>
    		</div>
    	</div>
    	<div class="row">
    		<div class="form-inline">
    			<div class="col-md-3">
	    			<div class="form-group">
	    				<label for="from" style="font-size: 16px;">From: </label>
	    				<input type="date" class="form-control" id="from">
	    			</div>
		    	</div>
		    	<div class="col-md-3">
		    		<div class="form-group">
		    			<label for="to" style="font-size: 16px;">To: </label>
	    				<input type="date" class="form-control" id="to">
		    		</div>	
		    	</div>
		    	<div class="col-md-3">
		    		<button class="btn btn-primary form-control" id="submitButton" value="<?php echo $class_id;?>">Submit</button>
		    	</div>
    		</div>
    	</div><br>

    	<div class="row">
    		<div class="table-responsive" id="fullTable">
    			<table class="table table-striped" id="classStanding">
		    		<thead id="thead">
		    			<th>No</th>
		    			<th>Student Number</th>
		    			<th>Name</th>
		    		</thead>
		    		<tbody id="tbody">
		    		</tbody>
		    	</table>
    		</div>
    		
    	</div>

    </div>
</body>
<script src="<?php echo base_url('assets/DataTables/datatables.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

	    var dataTable = $('#classStanding');
	    dataTable.DataTable();

	    document.getElementById("submitButton").onclick = function(event) {
	    	var classId = event.toElement.value;
	    	var from = document.getElementById("from").value;
	    	var to = document.getElementById("to").value;
	    	dataTable.DataTable().destroy();
	    	document.getElementById("fullTable").style.display = "none";

	    	$.ajax({
	    		url: "classes/Get_Students_Attendance",
	    		method: "POST",
	    		data: {
	    			"class_id": classId,
	    			"from":from,
	    			"to":to
 	    		},
	    		dataType: "JSON",
	    		success: function(data) {
	    			// console.log(data);
	    			var studentIds = new Array();
	    			var thead = "<th>Student Number</th><th>Name</th>";
	    			var tbody = "";
	    			var temp = "";
	    			var absences = 0;
	    			var presents = 0;
	    			var lates = 0;
	    			if(data.dates !== undefined) {
	    				for(var ctr=0;ctr<data.dates.length;ctr++) {
	    					var dateString = new Date(data.dates[ctr]);
	    					thead += "<th>"+monthToWords(dateString.getMonth())+", "+dateString.getDate()+" "+dateString.getFullYear()+"("+dayToWords(dateString.getDay())+")</th>";
	    				}
	    				thead += "<th>No. of Presents</th><th>No. of Absences</th><th>No. of Lates</th>";
	    			}
	    			/////////// TBODY ////////////////
	    			if(data.student!= undefined) {
	    				for(studentid in data.student)
	    					studentIds.push(studentid);
	    			}
	    			for(var studentCtr=0;studentCtr<studentIds.length;studentCtr++) {
	    				tbody += "<td>"+data.student[studentIds[studentCtr]].studentNum+"</td>";
	    				tbody += "<td>"+data.student[studentIds[studentCtr]].name+"</td>";
	    				if(data.dates === undefined) {
	    					tbody = "";
	    					break;
	    				}
	    				else if(data.attendance === undefined && data.dates !== undefined) {
	    					for(var dates=0;dates<data.dates.length;dates++) {
	    						tbody += "<td style='background-color: red;color:white;'>" + "ABSENT" + "</td>";
	    						absences +=1;
	    					}
	    				} else if(data.attendance[studentIds[studentCtr]] === undefined) {
	    					for(var dates=0;dates<data.dates.length;dates++) {
	    						tbody += "<td style='background-color: red;color:white;'>" + "ABSENT" + "</td>";
	    						absences +=1;
	    					}
	    				} else {
	    					for(var dates=0;dates<data.dates.length;dates++) {
	    						var isPresent = 0;
	    						for(var counter=0;counter<data.attendance[studentIds[studentCtr]].datein.length;counter++) {
	    							if(data.dates[dates] == data.attendance[studentIds[studentCtr]].datein[counter]){
	    								var presentStatus = scheduleAttendance(data.attendance[studentIds[studentCtr]].timein[counter], data.dates[dates] ,data.schedule);
	    								// console.log(presentStatus);
	    								if(presentStatus==0) {
	    									temp = "<td style='background-color:green;color:white;'>" + data.attendance[studentIds[studentCtr]].timein[counter] + "</td>";
	    									isPresent = 1;
	    								} else if(presentStatus==1) {
	    									temp = "<td style='background-color:orange;color:white;'>" + data.attendance[studentIds[studentCtr]].timein[counter] + "</td>";
	    									isPresent = 2;
	    								} else {
	    									temp = "<td style='background-color:red;color:white;'>ABSENT</td>";
	    								
	    								}
	    								break;
	    							} else {
	    								temp = "<td style='background-color:red;color:white;'>ABSENT</td>";
	    							}
	    						}

	    						if(isPresent==1) 
	    							presents += 1;
	    						else if(isPresent==2) 
	    							lates +=1
	    						else 
	    							absences += 1;
	    						tbody += temp;
	    					}
	    				}
	    				tbody += "<td>"+presents+"</td><td>"+absences+"</td><td>"+lates+"</td>"
	    				tbody += "</tr>";
	    				presents = 0;
	    				absences = 0;
	    				lates = 0;
	    			}

	    			document.getElementById("thead").innerHTML = thead;
	    			document.getElementById("tbody").innerHTML = tbody;
	    			dataTable.DataTable();
	    			document.getElementById("fullTable").style.display = "block";
	    		},
	    		error: function(err) {
	    			console.log(err.responseText);
	    		}
	    	});
	    }

	    function monthToWords(month) {
	    	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	    	return months[month];
	    }

	    function dayToWords(day) {
	    	var days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
	    	return days[day];
	    }

	    function scheduleAttendance(timein, atDate, schedule) {
	    	var days = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];
	    	var attendanceDate = new Date(atDate);
	    	var thisDay = days[attendanceDate.getDay()]
	    	var thisSchedule = [];
	    	var ctr = 0;
	    	var stat = 2;
	    	schedule.forEach(function(samp) {
	    		if(samp.Day==thisDay) {
	    			thisSchedule[ctr] = samp;
	    		}
	    		ctr++;
	    	})
			
			thisSchedule.forEach(function(sched) {
				var hrmins = sched.Beginning_Time.split(":");
				var hour = hrmins[0];
				var minutes = parseInt(hrmins[1]) + 10;

				var schedTime = hour+":"+minutes;

				var schedTime2 = parseInt(hour) - 2;
				schedTime2 = schedTime2+":"+hrmins[1];

				if(timein<=schedTime ) {
					stat = 0;
				} else if(timein>=schedTime && timein<=sched.End_Time) {
					stat = 1;
				} 
			})
			return stat;

			// 0=present 1=late
	    }

	    ///////////////////////////// AJAX CALLS /////////////////////////////

	


	});

</script>
</html>