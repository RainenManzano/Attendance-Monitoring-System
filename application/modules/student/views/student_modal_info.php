<!---MODAL----->
		<div class="modal" id="studentInfoModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!---HEADER----->
					<div class="modal-header">
						<button class="close" data-dismiss="modal" style="color:white;">&times;</button>
						<h3 class="modal-title" id="modalTitle">Student Profile</h3>
					</div>
					<!---BODY----->
					<center><img id="loader" src="<?php echo base_url('assets/loading/loader 3.gif');?>" style="display:none; width:20%;"></center>
					<div class="modal-body" id="modalBody">
						<div class="image">
						<img src="" width="200" height="200" id="studentImage"></div>

						<div class="info">
							<label>Student Number: <span class="stn" id="modStudIdInfo">2018-15957-MN-1</span> </label>
							<div class="pull-right">
								<img id="modBarcode"><br>
								<center><a href="#" id="print">Print Barcode</a></center>
							</div>
							<br>
							<label>Section: <span class="sec" id="modSectionInfo">BSIT Ladderized</span></label><br>
							<label>First Name: <span class="fn" id="modFirstInfo">John Cedric</span> </label><br>
							<label>Middle Name: <span class="mn" id="modMiddleInfo"> </span></label><br>
							<label>Last Name: <span class="ln" id="modLastInfo">Zamora </span></label><br>
							<br>
						</div>										
						
					</div>
					<!---FOOTER----->
					<?php 
						if(isAdmin($this->currentuser["level"])) {
							echo '<div class="modal-footer">
									<div class="pull-left">
										<form action="'.base_url('student/editStudentProfile').'" method="POST" style="display:inline;">
											<button type="submit" class="btn btn-info" id="editProfile" name="editid">Edit Profile</button>
										</form>
										<form method="post" action="student/deleteStudent" onSubmit="return deleteStudent();" style="display:inline;">
											<button type="submit" id="deleteButton" class="btn btn-danger pull-right" name="studentid" style="margin-left:10px;"><span class="fa fa-trash"></span></button>
										</form>
									</div>
									</div>';
						}
					?>
				</div>
			</div>
		</div>
		<style type="text/css">
			.info {
				width: 650px;
				float: right;
				margin-left: 50px;
				margin-top: -200px;
			}
			.modal-header {
				background-color: #00897b;
				color: white;
			}

			.stn {margin-left: 40px;}
			.sec {margin-left: 106px;}
			.fn {margin-left: 81px;}
			.mn {margin-left: 66px;}
			.ln {margin-left: 84px;}

		</style>

