	<div class="center">
		<div id="action">
	        <button id="add" type="button" class="btn btn-success" data-toggle="modal" data-target="#createUserModal"><span class="glyphicon glyphicon-plus"></span> Add User</button>
	    </div><br><br>

		<table class="table" id="usersTable">
			<thead>
				<tr>
					<th>User ID</th>
			        <th>Name</th>
			        <th>Username</th>
			        <th>Password</th>
			        <th>Level</th>
			        <th>Status</th>
			        <th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$level;
					foreach($users->result() as $user) {
						$user->Level==0?$level="Teacher":$level="Admin";
						echo "<tr>
			      				<td>".$user->User_ID."</td>
							    <td>".$user->Lastname.", ".$user->Firstname." ".$user->Middlename."</td>
							    <td>".$user->Username."</td>	
							    <td>".$user->Pw."</td>
							    <td>".$level."</td>
							    <td>".$user->Status."</td>
							    <td><button class='btn btn-primary editButton' data-toggle='modal' data-target='#editUserModal' id='".$user->User_ID."'>Edit</button>
							    </td>	
							</tr>";
					}
				?> 
			</tbody>
		</table>
	</div>

</div>

<div id="createUserModal" class="modal" role="dialog" data-keyboard="false" data-backdrop="static">
	<form action="users/createUser" method="post" id="createForm">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close closeButton">&times;</button>
        <h4 class="modal-title"><center>Create User</center></h4>
      </div>
      <div class="modal-body">
      	<div class="row">
	      	<div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Firstname" name="firstname">
	        </div>
	        <div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Middlename" name="middlename">
	        </div>
	        <div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Lastname" name="lastname">
	        </div>
    	</div>
    	<div class="row">
    		<div class="col-md-6">
	        	<label>Date of birth</label><input type="date" class="form-control inputText" name="birthdate">
	        </div> 
	        <div class="col-md-6">
	        	<label>Level</label>
	        	<select class="form-control" name="level">
	        		<option value="" selected disabled hidden id="defaultOption">SELECT</option>
	        		<option value="0">Teacher</option>
	        		<option value="1">Admin</option>
	        	</select>
	        </div>
    	</div><br>
    	<div class="row">
    		<div class="col-md-4 col-md-offset-2">
    			<input type="text" class="form-control inputText" placeholder="Username" name="username">
    		</div>
    		<div class="col-md-4">
    			<input type="password" class="form-control inputText" placeholder="Password" name="password">
    		</div>
    	</div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-success" id="form-submit">Submit</button>
        <button type="button" class="btn btn-danger closeButton">Cancel</button>
      </div>
    </div>
  </div>
	</form>
</div>

<div id="editUserModal" class="modal" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      	<form method="POST" action="users/deleteUser" id="deleteUserForm">
	        <button type="submit" class="btn btn-danger pull-right userid" name="userid" value=""><span class="fa fa-trash"></span></button>
	    </form>
        <h4 class="modal-title"><center>Edit User</center></h4>
      </div>
      <form action="users/editUser" method="post" id="submitEditForm">
      <center><img id="loader" src="<?php echo base_url('assets/loading/loader 3.gif');?>" style="display:none; width:20%;"></center>
      <div class="modal-body" id="editBody">
      	<div class="row">
	      	<div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Firstname" id="fn" name="firstname">
	        </div>
	        <div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Middlename" id="mn" name="middlename">
	        </div>
	        <div class="col-md-4">
	        	<input type="text" class="form-control inputText" placeholder="Lastname" id="ln" name="lastname">
	        </div>
    	</div>
    	<div class="row">
    		<div class="col-md-6">
	        	<label>Date of birth</label><input type="date" class="form-control inputText" id="bDate" name="birthdate">
	        </div> 
	        <div class="col-md-6">
	        	<label>Level</label>
	        	<select class="form-control" name="level">
	        		<option value="0" id="optTeacher">Teacher</option>
	        		<option value="1" id="optAdmin">Admin</option>
	        	</select>
	        </div>
    	</div><br>
    	<div class="row">
    		<div class="col-md-4">
    			<input type="text" class="form-control inputText" placeholder="Username" id="uname" name="username">
    		</div>
    		<div class="col-md-4">
    			<input type="password" class="form-control inputText" placeholder="Password" id="pw" name="password">
    		</div>
    		<div class="col-md-4">
    			<select class="form-control" name="status">
    				<option value="Active" id="optActive">Active</option>
    				<option value="Inactive" id="optInactive">Inactive</option>
    			</select>
    		</div>
    	</div>
      </div>
      <div class="modal-footer">
      	<button type="submit" class="btn btn-success userid" value="" name="userid">Save</button>
        <button type="button" class="btn btn-danger closeButton">Cancel</button>
      </div>
  	  </form>
    </div>
  </div>
	</form>
</div>

</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		document.getElementById("sideUser").classList.add("cl");

	    $('#usersTable	').DataTable( {
	        'bSort': false
		} );

	    $("#form-submit").click(function() {
	    	var changes = confirm("Are you sure you want to submit?")
	    	if(changes) {
	    		$("#createForm").submit();
	    	}
	    });

	    $("#submitEditForm").submit(function() {
	    	if(confirm("Are you sure you want to save changes?")) {
	    		return true;
	    	} else {
	    		return false;
	    	}
	    })

	    $("#deleteUserForm").submit(function() {
	    	if(confirm("Are you sure you want to delete the user? The selected user will be permanently removed.")) {
	    		return true;
	    	} else {
	    		return false;
	    	}
	    }) 

	    $(".closeButton").click(function() {
	    	if(confirm("Are you sure you want to discard changes?")) {
	    		var ctr = document.getElementsByClassName('inputText').length;
		    	for(var i=0;i<ctr;i++) {
		    		document.getElementsByClassName('inputText')[i].value = "";
		    	}
		    	$("#defaultOption").prop("selected", true);
		    	$("#createUserModal").modal("hide");
		    	$("#editUserModal").modal("hide");
	    	} else {
	    		if($("#createUserModal").css("display")=="block") {
	    			$("#createUserModal").modal("show");
	    		} else {
	    			$("#editUserModal").modal("show");
	    		}
	    	}
	    });

	    $(".editButton").click(function() {
	    	var userId = $(this).attr("id");
	    	$(".userid").val(userId);
	    	$.ajax({
	    		url: base_url+"users/getUser",
	    		method: "POST",
	    		dataType: 'JSON',
	    		data: {
	    			"id": userId
	    		},
	    		beforeSend: function() {
	    			document.getElementById("loader").style.display = "block";
	    			document.getElementById("editBody").style.display = "none";
	    		},
	    		success: function(data) {
	    			// console.log(data);
	    			document.getElementById("fn").value = data.firstname;
	    			document.getElementById("mn").value = data.middlename;
	    			document.getElementById("ln").value = data.lastname;
	    			document.getElementById("bDate").value = data.birth;
	    			document.getElementById("uname").value = data.username;
	    			document.getElementById("pw").value = data.password;
	    			data.level=='0'? $("#optTeacher").prop("selected", true): $("#optAdmin").prop("selected", true);
	    			data.status=='Active'? $("#optActive").prop("selected", true): $("#optInactive").prop("selected", true);

	    			document.getElementById("loader").style.display = "none";
	    			document.getElementById("editBody").style.display = "block";
	    		},
	    		error: function(request) {
	    			console.log(request.responseText);
	    		}
	    	});
	    })

	} );

</script>
</html>