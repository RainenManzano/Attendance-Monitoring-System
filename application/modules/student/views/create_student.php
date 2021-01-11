<div id="createStudentModal" class="modal" role="dialog" data-keyboard="false" data-backdrop="static">
	<form action="<?php echo base_url()?>student/createStudent" method="post" onSubmit="return createStudent();" enctype="multipart/form-data">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closeButton">&times;</button>
        <h4 class="modal-title"><center>Create Student</center></h4>
      </div>
      <div class="modal-body">

        <ul class="nav nav-tabs">
                <li class="tab active" id="Input"><a href="#">Input Student</a></li>
                <li class="tab" id="import"><a href="#">Import CSV</a></li>
        </ul><br>

        <div id="studentFormFill">
          <div class="row">
            <div class="col-md-3">
              <input type="text" class="form-control inputText" placeholder="Student Number" name="StudentNo" id="inputStudentNum">
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control inputText" placeholder="Firstname" name="firstname" id="inputFirstname">
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control inputText" placeholder="Middlename" name="middlename" id="inputMiddlename">
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control inputText" placeholder="Lastname" name="lastname" id="inputLastname">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
              <input type="file" class="form-control" name="image" id="inputImagePath">
            </div>
            <div class="col-md-6">
              <select class="form-control" id="inputSection" name="section">
                <option value="">None</option>
                <?php
                  foreach($sectionList->result() as $section) {
                    echo "<option value='".$section->Section_Id."'>".$section->Section_Name."</option>";
                  }
                ?>
              </select>
            </div>
          </div>
        </div>

        <div id="studentUpload" style="display:none;">
          <div class="row">
            <div class="col-md-4">
              <input type="file" class="form-control" name="studentCsv">
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-4">
                <b>Note: The format of the excel/csv file should be as follow: student number, lastname, firstname, and middlename</b>
              </div>
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