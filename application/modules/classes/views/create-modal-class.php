<div id="createClassModal" class="modal" role="dialog" data-keyboard="false" data-backdrop="static">
	<form action="<?php echo base_url('classes/Create_Class');?>" method="post" id="createForm">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closeButton">&times;</button>
        <h4 class="modal-title"><center>Create Class</center></h4>
      </div>
      <div class="modal-body">

      	<div class="row">
	      	<div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Subject Code" name="subject_code">
	        </div>
          <div class="col-md-4">
            <input type="text" class="form-control inputText" placeholder="Subject Name" name="subject_name">
          </div>
	        <div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Subject Description" name="subject_desc">
	        </div>
    	  </div>
        <br>

        <div class="row">
          <div class="col-md-6">
            <select class="form-control inputText" name="units">
              <option value="" hidden>Units</option>
              <option value="3" >3</option>
              <option value="5" >5</option>
            </select>
          </div>
          <div class="col-md-6">
            <select class="form-control inputText" name="section_id">
              <option value="" hidden>SELECT SECTION</option>
              <?php
                foreach($sections->result() as $section) {
                  echo "<option value='".$section->Section_Id."'>".$section->Section_Name."</option>";
                }
              ?>
            </select>
          </div>
        </div><br>

        <?php 
          if(isset($teachers)) {
            echo '<div class="row">
                      <div class="col-md-6">
                        <select class="form-control" name="teacher">
                          <option value="" hidden selected>Teacher</option>';
            foreach($teachers->result() as $teacher) {
              echo '<option value="'.$teacher->User_ID.'">'.$teacher->Lastname.', '.$teacher->Firstname.' '.substr($teacher->Middlename, 0,1).'</option>';
            }
            echo ' </select>
                      </div>
                    </div><br>';                       
          }
        ?>
        
        <div class="row">
          <div class="col-md-2">
             <h4>Schedule</h4>   
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-success" id="addSched"><span class="fa fa-plus"></span></button>   
          </div>
        </div>
        
        <div class="row" id="schedule">
          <div class="col-md-6">
            <select class="form-control day" name="day[]">
              <option value ="" selected hidden>DAY</option>
              <option value="monday">Monday</option>
              <option value="tuesday">Tuesday</option>
              <option value="wednesday">Wednesday</option>
              <option value="thursday">Thursday</option>
              <option value="friday">Friday</option>
              <option value="saturday">Saturday</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="time" class="form-control time_begin" name="time_begin[]">
          </div>
          <div class="col-md-3">
            <input type="time" class="form-control time_end" name="time_end[]">
          </div>
        </div>

      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-danger closeButton">Cancel</button>
      </div>
    </div>
  </div>
	</form>
</div>