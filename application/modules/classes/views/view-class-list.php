<div class="center">
	<div id="action">
		<button id="add" type="button" class="btn btn-success" data-toggle="modal" data-target="#createClassModal"><span class="glyphicon glyphicon-plus"></span> Create Class</button>
	</div><br>

    <table class="table" id="classTable">   
        <thead>
            <tr>
            	<?php
            		if(!isAdmin($this->currentuser["level"]))
            			echo "<th>Class ID</th>
            				<th>Subject Code</th>
            				<th>Subject</th>
            				<th>Units</th>
            				<th>Action</th>";
            		else
            			echo "<th>Class ID</th>
            				<th>Subject Code</th>
            				<th>Subject</th>
            				<th>Units</th>
            				<th>Instructor</th>
							<th>Action</th>";
            		
            	?>
            </tr>
        </thead>
        <tbody>
				            
            <?php 
                foreach($class->result() as $class) {
				    echo "<tr>";
				    echo "<td>".$class->Id."</td>";
				    echo "<td>".$class->Subject_Code."</td>";
				    echo "<td>".$class->Subject."</td>";
				    echo "<td>".$class->Units."</td>";

				    if(isAdmin($this->currentuser["level"]))
				    	echo "<td>".$class->Lastname.", ".$class->Firstname." ".substr($class->Middlename, 0, 1).".</td>";

				    echo "<td><button class='btn btn-default viewButton' data-toggle='modal' data-target='#classInfoModal' value='".$class->Id."'>View info</button></td>";
                    echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>

		
		
	</div>
	<?php 
		$this->load->view("create-modal-class");
		$this->load->view("view-modal-class");
	?>
</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		document.getElementById("sideClass").classList.add("cl");

	    $('#classTable').DataTable( {
	        dom: 'Bfrtip',
	        buttons: [
	            'print'
	        ]
	    } );

	    //CONFIRMATION WHEN CLOSING
		$(".closeButton").click(function() {
	    	if(confirm("Are you sure you want to close?")) {
	    		$(".inputText").val("");
	    		$("#createClassModal").modal("hide");
	    	}
	    });	

		//HANDLE AJAX AND PASSING OF CLASS ID THRU THE SYSTEM
	    $(".viewButton").click(function() {
	    	var classId = $(this).val();
	    	document.getElementById("deleteButton").value = classId;
	    	document.getElementById("Class_Attendance_id").value = classId;
	    	ajaxGetClassInfo(classId);
	    });

	    //HANDLES DELETE FORM SUBMISSION
	    document.getElementById("deleteForm").onsubmit = function() {
			if(!confirm("Are you sure you want to delete the selected section? It will be permanently removed if you proceeded.")) {
				return false;
			}	
		}

		//HANDLES CREATE FORM SUBMISSION AND VALIDATIONS
	    document.getElementById("createForm").onsubmit = function() {
		   	var err = ""
		   	var schedCount = document.getElementsByClassName("day").length;
		   	var tempDay = "";
		   	var tempTimeBegin = "";
		   	var tempTimeEnd = "";
		  	if($("[name='subject_code']").val()=="")
		   		err += "Subject Code\n";
		   	if($("[name='subject_name']").val()=="")
		   		err += "Subject Name\n";
		   	if($("[name='subject_desc']").val()=="")
		   		err += "Subject Description\n";
		   	if($("[name='units']").val()=="")
		  		err += "Units\n";
		  	if($("[name='section_id']").val()=="")
		   		err += "Section\n";
		   	if($("[name='teacher']")!==undefined && $("[name='teacher']").val()=="")
		   		err += "Teacher\n";
	   		for(var ctr=0;ctr<schedCount;ctr++) {
		   		if(document.getElementsByClassName("day")[ctr].value==""){
		   			tempDay = "Day\n";
		   		}
		   		if(document.getElementsByClassName("time_begin")[ctr].value==""){
		   			tempTimeBegin = "Time Begin\n";
		   		}
		   		if(document.getElementsByClassName("time_end")[ctr].value==""){
		   			tempTimeEnd = "Time End\n";
		   		}
		   	}
		   	err += tempDay;
		   	err += tempTimeBegin;
		   	err += tempTimeEnd;
		   	if(err!="") {
		   		alert("The following field/s are required: \n" + err);
		   		return false;
		   	}
		}	

		//ADDING OF INPUT FIELDS (SCHEDULE)
		document.getElementById("addSched").onclick = function() {
			var dayElement = $(document.createElement("div")).attr("class", "col-md-6");
			var timeBeginElement = $(document.createElement("div")).attr("class", "col-md-3");
			var timeEndElement = $(document.createElement("div")).attr("class", "col-md-3")
			dayElement.after().html(`<select class="form-control day" name="day[]">
				<option value ="" selected hidden>DAY</option>
				<option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
              	<option value="saturday">Saturday</option>
            	</select>`);
			timeBeginElement.after().html('<input type="time" class="form-control time_begin" name="time_begin[]">');
			timeEndElement.after().html('<input type="time" class="form-control time_end" name="time_end[]">');
			dayElement.appendTo("#schedule");
			timeBeginElement.appendTo("#schedule");
			timeEndElement.appendTo("#schedule");
		}

		try {
			document.getElementById("thruBarcode").onclick = function() {
			    var classId = document.getElementById("Class_Attendance_id").value;
			    window.open(base_url+"attendance/Barcode_Scanner#"+classId, "Barcode-Scanner", "menubar=1,resizable=1,width=1200,height=550");
			}
		} catch(ex) {}

		
	    ///////////////////////////// AJAX CALLS /////////////////////////////

	    function ajaxGetClassInfo(id) {
	    	$.ajax({
	    		url: base_url + 'classes/ajaxGetClassInfo',
	    		dataType: 'JSON',
	    		method: 'POST',
	    		data: {
	    			'classid': id
	    		},
	    		beforeSend: function() {
	    			document.getElementById("modalTitle").style.display = "none";
	    			document.getElementById("modalBody").style.display = "none";
	    			document.getElementById("loader").style.display = "block";
	    		},
	    		success: function(classInfo) {
	    			console.log(classInfo)
	    			var html = "Subject: " + classInfo.subjectName + "<br>" +
	    						"Subject Code: " + classInfo.subjectCode + "<br>" +
	    						"Subject Description: " + classInfo.subjectDesc + "<br>" +
	    						"Units: " + classInfo.units + "<br><br>" +
	    						"Section Name: " + classInfo.sectionName + "<br>" +
	    						"Section Description: " + classInfo.sectionDesc + "<br><br>";
	    			if(classInfo.instructor!=undefined) {
	    				html += "Instructor Name: " + classInfo.instructor + "<br><br>";
	    			}
	    			for(var ctr=0;ctr<classInfo.schedule.day.length;ctr++) {
	    				html += "Schedule " + (parseInt(ctr)+1) + ": " + classInfo.schedule.day[ctr] + " / " + classInfo.schedule.beginTime[ctr] + " - " + classInfo.schedule.endTime[ctr] + "<br>";
	    			}
	    			$('#modalTitle').html(classInfo.subjectName);
	    			$('#modalBody').html(html)
	    			document.getElementById("loader").style.display = "none";
	    			document.getElementById("modalTitle").style.display = "block";
	    			document.getElementById("modalBody").style.display = "block";
	    		},
	    		error: function(request) {
	    			console.log(request.responseText)
	    			setTimeout(function() {
	    				ajaxGetClassInfo(id)
	    			}, 3000);
	    		}
	    	})
	    }



	});

</script>
</html>