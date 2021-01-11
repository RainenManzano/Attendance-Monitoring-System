<!---MODAL----->
		<div class="modal" id="sectionInfoModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!---HEADER----->
					<div class="modal-header">	
						<button class='close' data-dismiss='modal'>&times;</button> 
						<h4 class="modal-title">Section Info</h4>
					</div>
					<!---BODY----->	
					<center><img id="loader" src="<?php echo base_url('assets/loading/loader 3.gif');?>" style="display:none; width:20%;"></center>
					<div class="modal-body" id="modalBody">
						<p>Section: <span id="sectionNameText"></span></p>
						<p>Description: <span id="sectionDescText"></span></p>
						<!-- <a href="#" id="print">Print all Barcodes</a> -->
						<br><h4>List of students enrolled</h4>
						<table class="table table-striped" id="infoStudentsTable">
							<thead>
								<tr>
									<th width="10">Student Number</th>
									<th width="80">Name</th>
									<th width="10">Action</th>
								</tr>
							</thead>
							<tbody id="infoStudentsTableBody">
							</tbody>
						</table>
					</div>
					<!---FOOTER----->
					<?php
						if(isAdmin($this->currentUser["level"])) {
							echo '<div class="modal-footer">
									<div class="pull-left">
										<form action="'.base_url('section/editSectionPage').'" method="post" style="display:inline;">
											<button type="submit" class="btn btn-default " name="editSectionId" id="editSectionId">Edit Section</button>
										</form>
										<form method="post" action="'.base_url('section/deleteSection').'" onSubmit="return deleteSection();" style="display:inline;">
											<button type="submit" id="deleteButton" class="btn btn-danger" name="sectionid"><span class="fa fa-trash"></span></button>
										</form>
									</div>
									</div>';
						} 
					?>
				</div>
			</div>
		</div>