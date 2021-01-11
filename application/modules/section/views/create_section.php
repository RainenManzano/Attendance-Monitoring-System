<div id="createSectionModal" class="modal" role="dialog" data-keyboard="false" data-backdrop="static">
	<form action="section/createSection" method="post" id="createForm">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closeButton">&times;</button>
        <h4 class="modal-title"><center>Create Section</center></h4>
      </div>
      <div class="modal-body">

      	<div class="row">
	      	<div class="col-md-6">
	        	<input type="text" class="form-control inputText" placeholder="Section Name" name="name" id="sectionName">
	        </div>
	        <div class="col-md-6">
	        	<input type="text" class="form-control inputText" placeholder="Section Description" name="description" id="sectionDesc">
	        </div>
    	  </div>

        <div class="row">
          
          <br>
          <div class="col-md-12">
            <div class="panel-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" href="#studentsPanel">Add Students to the section</a>
                  </h4>
                </div>

                <div id="studentsPanel" class="panel-collapse collapse">
                  <div class="panel-body">
                    
                    <table id="studentsTable" class="table table-striped">
                      <thead>
                        <tr>
                          <th width="10">Student Number</th>
                          <th width="90">Name</th>
                        </tr>
                      </thead>
                      <tbody id="studentsBody">

                      </tbody>
                    </table>

                  </div>
                </div>

              </div>
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