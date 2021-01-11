		<div class="center">
			<form action="<?php echo base_url('section/updateSection');?>" method="post">
				<div class="jumbotron">
					<div class="container">

						<div class="col-md-6">
							<input type="text" class="form-control" name="sectionname" value="<?php echo $sectionname;?>">
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" name="sectiondesc" value="<?php echo $sectiondesc;?>">
							<input type="hidden" name="sectionid" value="<?php echo $sectionid;?>">
						</div>
						<br><br>

						<div class="row" style="margin:20px;">
							<table class="table table-striped" id="studentsTable">
								<thead>
									<tr>
										<th width="10">Student Number</th>
										<th width="90">Name</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$tbody = "";
										foreach($students->result() as $student) {
											$tbody .= "<tr>";
											$tbody .= "<td>";
											$tbody .= $student->Section_Id==$sectionid ? "<input type='checkbox' name='newStudentId[]' value='".$student->Id."' checked>   ": "<input type='checkbox' name='newStudentId[]' value='".$student->Id."'>   ";
											$tbody .= $student->Student_No ."</td>";
											$tbody .= "<td>". $student->Lastname .", ".$student->Firstname." ".substr($student->Middlename, 0, 1).".</td>";
											$tbody .= "</tr>";
											
										}
										echo $tbody;
									?>
								</tbody>
							</table>
							<?php 
								foreach($students->result() as $student) 
									echo "<input type='hidden' name='oldStudentsId[]' value='".$student->Id."'>";
							?>
						</div>

					</div>
				</div>
				<input type="submit">
			</form>
			




		</div>
	</div>

</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		////////////////////////// STARTUP APPLICATION /////////////////////////

		document.getElementById("sideSection").classList.add("cl");

	    $('#studentsTable').DataTable();


	});

</script>
</html>