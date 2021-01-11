		<div class="center">
			<?php
				if(isAdmin($this->currentuser["level"])) {
			?>
			<div id="action">
		        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createStudentModal"><span class="glyphicon glyphicon-plus"></span> Add Student</button>
		    </div>
		    <br>
		    <?php
		    	}
		    ?>

			<table class="table" id="studentsTable">
				<thead>
					<tr>
						<?php
				        	if(!isAdmin($this->currentuser["level"])) {
				        		echo "<th>Class</th>";
				        	} else {
				        		echo "<th>Student Id</th>";
				        	}
				        ?>
						<th>Student Number</th>
				        <th>Name</th>
				        <th>Section</th>
				        
				        <th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach($students->result() as $student) {
							echo "<tr>";
							if(!isAdmin($this->currentuser["level"])) 
								echo "<td>".$student->Subject."</td>";
							else 
								echo "<td>".$student->Id."</td>";
							echo "<td>".$student->Student_No."</td>
								    <td>".$student->Lastname.", ".$student->Firstname." ".substr($student->Middlename, 0, 1).".</td>
								    <td>".$student->Section_Name."</td>";
							echo "<td><button class='btn btn-primary viewButton' data-toggle='modal' data-target='#studentInfoModal' value='".$student->Id."'>View info</button></td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>


	</div>
<?php
	$this->load->view("student/create_student");
	$this->load->view("student/student_modal_info");
?>
</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script src="<?php echo base_url('assets/libraries/JsBarcode.all.min.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		var hash = location.hash.substr(1);
		if(hash!=""){
			$("#studentInfoModal").modal("show");
			document.getElementById("deleteButton").value = hash;
			document.getElementById("editProfile").value = hash;
			ajaxViewStudentInfo(hash);
		}

		document.getElementById("sideStudent").classList.add("cl");

	    $('#studentsTable').DataTable( {
	        dom: 'Bfrtip',
	        buttons: [
	            'print'
	        ]
	    } );

	    $(".viewButton").click(function() {
	    	var studentId = $(this).val();
	    	var deleteButton = document.getElementById("deleteButton");
	    	var editProfile = document.getElementById("editProfile");
	    	if(deleteButton!==null && editProfile!==null) {
	    		deleteButton.value = studentId;
	    		editProfile.value = studentId;
	    	}
	    	ajaxViewStudentInfo(studentId);
	    });

	    document.getElementById("print").onclick = function() {
	    	var canvas = "";
	    	canvas = "<img src='"+document.getElementById("modBarcode").src+"'>";
	    	popup = window.open();
	    	popup.document.write(canvas);
	    	popup.focus();
	    	popup.print();
	    	popup.close();
	    }

		$(".closeButton").click(function() {
			var conf = confirm("Are you sure you want to leave the modal?");
			if(conf) {
				$(".modal").modal("hide");
				$(".inputText").val("");
				$("option:disabled").prop("selected", true);
			}
		});

		function ajaxViewStudentInfo(studentId) {
			$.ajax({
	    		url: base_url+"student/ajaxStudentInfo",
	    		dataType: "JSON",
	    		method: "POST", 
	    		data: {
	    			"studentid": studentId
	    		},
	    		beforeSend: function() {
	    			document.getElementById("loader").style.display = "block";
	    			document.getElementById("modalBody").style.display = "none";
	    		},
	    		success: function(data) {
	    			// console.log(data);
	    			var d = new Date();
	    			var barcodeElement = document.getElementById("modBarcode");
					JsBarcode(barcodeElement, data.StudId, {
						format: "CODE128",
						height: 40,
						width: 1.5, 
						displayValue: true
					})
	    			document.getElementById("loader").style.display = "none";
	    			document.getElementById("modalBody").style.display = "block";
	    			document.getElementById("studentImage").style.display = "none";
	    			document.getElementById("studentImage").src = base_url+"assets/student_pictures/"+data.image+"?"+d.getTime();
	    			document.getElementById("studentImage").style.display = "block";
	    			document.getElementById("modStudIdInfo").innerHTML = data.StudId;
	    			document.getElementById("modFirstInfo").innerHTML = data.Firstname;
	    			document.getElementById("modMiddleInfo").innerHTML = data.Middlename;
	    			document.getElementById("modLastInfo").innerHTML = data.Lastname;
	    			document.getElementById("modSectionInfo").innerHTML = data.section
	    		},
	    		error: function(request) {
	    			console.log(request.responseText);
	    			setTimeout(function() {
	    				ajaxViewStudentInfo(studentId);
	    			}, 3000);
	    		}
	    	});
		}

		document.getElementById("Input").onclick = function() {
			document.getElementById("Input").classList.add("active");
			document.getElementById("import").classList.remove("active");
			document.getElementById("studentFormFill").style.display = "block";
			document.getElementById("studentUpload").style.display = "none";
		}

		document.getElementById("import").onclick = function() {
			document.getElementById("import").classList.add("active");
			document.getElementById("Input").classList.remove("active");
			document.getElementById("studentFormFill").style.display = "none";
			document.getElementById("studentUpload").style.display = "block";
		}

		// createStudent = function() {
		// 	var err = "";
		// 	var studno = document.getElementById("inputStudentNum").value;
		// 	var firstname = document.getElementById("inputFirstname").value;
		// 	var middlename = document.getElementById("inputMiddlename").value;
		// 	var lastname = document.getElementById("inputLastname").value;
		// 	var image = document.getElementById("inputImagePath").value;
		// 	studno==""? err+="Student Number\n" : err+="";
		// 	firstname==""? err+="Firstname\n" : err+="";
		// 	middlename==""? err+="Middlename\n" : err+="";
		// 	lastname==""? err+="Lastname\n" : err+="";
		// 	image==""? err+="Image\n" : err+="";
		// 	if(err!="") {
		// 		alert("The following field/s are required: \n" + err);
		// 		return false;
		// 	} else {
		// 		return true;
		// 	}
		// }

		deleteStudent = function() {
			var conf = confirm("Are you sure you want to delete the selected student? It will be permanently removed if you proceeded.");
			if(!conf)
				return false;
			else 
				return true;
		}

	});

</script>
</html>