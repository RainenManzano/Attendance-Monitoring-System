<div class="center">
			<form action="<?php echo base_url('student/updateProfile');?>" method="post" id="formEdit" enctype="multipart/form-data">
				<input type="hidden" name="studentid" value="<?php echo $id;?>">
				<div class="jumbotron">
					<div class="container">
							<div class="col-md-4">
								<label>Image</label>	
								<img src='<?php echo base_url("assets/student_pictures/".$image_path."?".time()."")?>' name="image" style='width:100%;height:200px;' id='picture'>
								<br><br>
								<input type="file"  name="image" id="file">
								<br>
								<label>Section: </label>								
								<select class="form-control" name="section">
									<option value="">None</option>
									<?php
										foreach($sectionList->result() as $section) {
											if($section_id==$section->Section_Id) 
												echo "<option value='".$section->Section_Id."' selected>";
											else 
												echo "<option value='".$section->Section_Id."'>";
											echo $section->Section_Name;
											echo "</option>";
										}
									?>
								</select>
								<br>
								<button type="submit" class="btn btn-primary"> Save Information</button>																
							</div>

							<div class="col-md-4">
								<label>Student Number: </label>
								<input type="text" class="form-control" name="studentnumber" value="<?php echo $student_num;?>">	
								<br>
								<label>First Name: </label>								
								<input type="text" class="form-control" name="firstname" value="<?php echo $firstname;?>">
								<br>
								<label>Middle Name: </label>								
								<input type="text" class="form-control" name="middlename" value="<?php echo $middlename;?>">
								<br>
								<label>Last Name: </label>
								<input type="text" class="form-control" name="lastname" value="<?php echo $lastname;?>">
								<br>
							</div>					
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		////////////////////////// STARTUP APPLICATION /////////////////////////

		document.getElementById("sideStudent").classList.add("cl");

		document.getElementById("formEdit").onsubmit = function() {
			var studentNumber = document.getElementsByName("studentnumber")[0].value;
			var firstname = document.getElementsByName("firstname")[0].value;
			var middlename = document.getElementsByName("middlename")[0].value;
			var lastname = document.getElementsByName("lastname")[0].value;
			var section = document.getElementsByName("section")[0].value;
			var err = "";
			if(studentNumber=="")
				err += "Student Number \n";
			if(firstname=="") 
				err += "Firstname \n";
			if(lastname=="")
				err += "Lastname \n";
			if(err!="") {
				alert("Following fields are required: \n" + err);
				return false;
			}
		}

		document.getElementById("file").onchange = function() {
			var input = document.getElementById("file");
			if(input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					console.log(e)
					document.getElementById("picture").src = e.target.result;
				}
				reader.readAsDataURL(input.files[0]);
			}
		}


	});

</script>
</html>