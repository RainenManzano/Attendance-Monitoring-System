<!---MODAL----->
		<div class="modal" id="classInfoModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!---HEADER----->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="modalTitle"></h4>
					</div>
					
					<center><img id="loader" src="<?php echo base_url('assets/loading/loader 3.gif');?>" style="display:none; width:20%;"></center>
					<!---BODY----->
					<div class="modal-body">
						<div id="modalBody" style="display:none;">
							
						</div>
						<?php
							if(!isAdmin($this->currentuser["level"]))
								echo '<br><div class="dropdown">
								  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Attendance Thru: <span class="caret"></span></button>
								  <ul class="dropdown-menu" role="menu">
								    <li id="thruBarcode"><a href="#">Barcode</a></li>
								    <li id="thruInput"><a href="#">Student Number</a></li>
								  </ul>
								</div><br>';
						?>
						<form method="POST" action="classes/Class_Attendance">
							<button type="submit" formtarget="_blank" class="btn btn-primary" id="Class_Attendance_id" name="class_id">View more info</button>
						</form>
					</div>
					<!---FOOTER----->
					<div class="modal-footer">
						<form method="post" action="classes/<?php if(!isAdmin($this->currentuser['level'])) echo 'Deactivate_Class'; else echo 'Remove_Class'?>" id="deleteForm">
							<button type="submit" id="deleteButton" class="btn btn-warning pull-left" name="delete_id">Delete Class</button>
						</form>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>