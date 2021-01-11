		<div class="center">
			<table class="table" id="scheduleTable">
				<thead>
					<tr>
						<th>Day</th>
						<th>Time</th>
						<th>Class</th>
						<th>Section</th>
						<?php 
							if(isAdmin($this->currentUser["level"])) 
								echo "<th>Instructor</th>";
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach($schedules->result() as $sched) {
							echo "<tr>";
							echo "<td>".$sched->Day."</td>";
				      		echo "<td>".$sched->Beginning_Time." - ".$sched->End_Time."</td>";
				      		echo "<td>".$sched->Subject."</td>";
				      		echo "<td>".$sched->Section_Name."</td>";
				      		if(isAdmin($this->currentUser["level"])) 
								echo "<td>".$sched->Lastname.", ".$sched->Firstname." ".substr($sched->Middlename, 0, 1).".</td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>


	</div>

</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		////////////////////////// STARTUP APPLICATION /////////////////////////

		document.getElementById("sideSchedule").classList.add("cl");

	    $('#scheduleTable').DataTable( {
	        dom: 'Bfrtip',
	        buttons: [
	            'print'
	        ]
	    } );


	    ////////////////////////// DOM FUNCTIONS ////////////////////////////////
	    
	 



	    ////////////////////////// AJAX CALLS ///////////////////////////////////


	    function getSectionInfo(sectionId) {
	    	$.ajax({
	    		url: base_url+"section/getSectionInfo",
	    		dataType: "JSON",
	    		method: "POST", 
	    		data: {
	    			"sectionid": sectionId
	    		},
	    		beforeSend: function() {
	    			document.getElementById("loader").style.display = "block";
	    			document.getElementById("modalBody").style.display = "none";
	    			$("#infoStudentsTable").DataTable().destroy();
	    		},
	    		success: function(data) {
	    			console.log(data);
	    			var tableHtml="";
	    			document.getElementById("sectionNameText").innerHTML = data[0].sectionName;
	    			document.getElementById("sectionDescText").innerHTML = data[0].sectionDesc
	    			if(data[0].studentNo!==null) {
	    				for(var ctr=0;ctr<data.length;ctr++) {
		    				tableHtml+= "<tr>";
		    				tableHtml+= "<td>"+data[ctr].studentNo+"</td>";
		    				tableHtml+= "<td>"+data[ctr].name+"</td>";
		    				tableHtml+= "<td><a href='"+base_url+"student#"+data[ctr].studentId+"'>View profile</a></td>";
		    				tableHtml+= "</tr>";
		    			}
	    			}
	    			document.getElementById("infoStudentsTableBody").innerHTML = tableHtml;
	    			$("#infoStudentsTable").DataTable();
	    			document.getElementById("loader").style.display = "none";
	    			document.getElementById("modalBody").style.display = "block";
	    		},
	    		error: function(request) {
	    			console.log(request.responseText);
	    			setTimeout(function() {
	    				getSectionInfo(sectionId);
	    			}, 3000)
	    		}
	    	})
	    }


	});

</script>
</html>