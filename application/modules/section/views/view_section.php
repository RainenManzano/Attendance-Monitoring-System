		<div class="center">
			<?php 
				if(isAdmin($this->currentUser["level"])) {
					echo '<div id="action">
						        <button id="add" type="button" class="btn btn-success" data-toggle="modal" data-target="#createSectionModal"><span class="glyphicon glyphicon-plus"></span> Add Section</button>
						    </div><br>';
				}
		    ?>
			<table class="table" id="sectionTable">
				<thead>
					<tr>
						<th>Section ID</th>
						<th>Section Name</th>
				        <th>Section Description</th>
				        <?php
				        	if(!isAdmin($this->currentUser["level"]))
				       			echo "<th>Class</th>";
				        ?>
				        <th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach($sections->result() as $section) {
							echo "<tr>";
				      		echo "<td>".$section->Section_Id."</td>";
				      		echo "<td>".$section->Section_Name."</td>";
				      		echo "<td>".$section->Section_Desc."</td>";
				      		if(!isAdmin($this->currentUser["level"])) {
				      			echo "<td>".$section->Subject."</td>";	
				      		}
							echo "<td><button class='btn btn-primary viewButton' data-toggle='modal' data-target='#sectionInfoModal' value='".$section->Section_Id."'>View info</button>
								    </td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>


	</div>

<?php 
	$this->load->view('section/view_info_section');
	if(isAdmin($this->currentUser["level"]))
		$this->load->view('section/create_section'); 
?>
</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script src="<?php echo base_url('assets/libraries/JsBarcode.all.min.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		////////////////////////// STARTUP APPLICATION /////////////////////////

		document.getElementById("sideSection").classList.add("cl");

	    $('#sectionTable').DataTable( {
	        dom: 'Bfrtip',
	        buttons: [
	            'print'
	        ]
	    } );


	    ////////////////////////// DOM FUNCTIONS ////////////////////////////////
	    
	    $(".closeButton").click(function() {
			var conf = confirm("Are you sure you want to leave the modal?");
			if(conf) {
				$(".modal").modal("hide");
				$(".inputText").val("");
			}
		});

		$("#createForm").submit(function() {
			var err = "";
			var sectionName = document.getElementById("sectionName").value;
			var sectionDesc = document.getElementById("sectionDesc").value;
			if(sectionName=="")
				err += "Section Name \n";
			if(sectionDesc=="")
				err += "Section Description";
			if(err!="") {
				alert("The following field/s are required: \n" + err);
				return false;
			} else 
				return true;
		});

		deleteSection = function() {
			var conf = confirm("Are you sure you want to delete the selected section? It will be permanently removed if you proceeded.");
			if(!conf)
				return false;
			else 
				return true;
		}

		$(".viewButton").click(function() {
			var deleteButton = document.getElementById("deleteButton");
			var editSectionId = document.getElementById("editSectionId");
			if(deleteButton!==null&&editSectionId!==null) {
				deleteButton.value = $(this).val();
				editSectionId.value = $(this).val();
			}
	    	getSectionInfo($(this).val());
	    });

	    $("#add").click(function() {
	    	getStudents();
	    })

	    document.getElementById("print").onclick = function() {
	    	var canvas = "";
	    	
	    	popup = window.open();
	    	popup.document.write(canvas);
	    	popup.focus();
	    	popup.print();
	    	popup.close();
	    }



	    ////////////////////////// AJAX CALLS ///////////////////////////////////

	    function getStudents() {
	    	$("#studentsTable").DataTable().destroy();
	    	$.ajax({
	    		url: base_url + "section/getStudents",
	    		dataType: "JSON",
	    		method: "POST",
	    		success: function(data) {
	    			// console.log(data);
	    			var tableHtml = "";
	    			for(var ctr=0; ctr<data.length;ctr++) {
	    				tableHtml += "<tr>";
	    				tableHtml += "<td><input type='checkbox' name='student[]' value='"+data[ctr].Id+"'>  " + data[ctr].Student_No + "</td>";
	    				tableHtml += "<td>" + data[ctr].Lastname + ", " +data[ctr].Firstname+ " " +data[ctr].Middlename.charAt(0)+ ".</td>";
	    				tableHtml += "</tr>";
	    			}
	    			document.getElementById("studentsBody").innerHTML = tableHtml;
	    			$("#studentsTable").DataTable();
	    		},
	    		error: function(err) {
	    			console.log(err.responseText);
	    			setTimeout(function() {
	    				getStudents();
	    			}, 3000);
	    		}
	    	})
	    }

	    function getSectionInfo(sectionId) {
	    	$.ajax({
	    		url: base_url+"section/getSectionInfo",
	    		dataType: "JSON",
	    		method: "POST", 
	    		data: {
	    			"sectionid": sectionId
	    		},
	    		beforeSend: function() {
	    			document.getElementById("loader").style.display = "block";
	    			document.getElementById("modalBody").style.display = "none";
	    			$("#infoStudentsTable").DataTable().destroy();
	    		},
	    		success: function(data) {
	    			console.log(data);
	    			var tableHtml="";
	    			document.getElementById("sectionNameText").innerHTML = data[0].sectionName;
	    			document.getElementById("sectionDescText").innerHTML = data[0].sectionDesc
	    			if(data[0].studentNo!==null) {
	    				for(var ctr=0;ctr<data.length;ctr++) {
		    				tableHtml+= "<tr>";
		    				tableHtml+= "<td>"+data[ctr].studentNo+"</td>";
		    				tableHtml+= "<td>"+data[ctr].name+"</td>";
		    				tableHtml+= "<td><a href='"+base_url+"student#"+data[ctr].studentId+"'>View profile</a></td>";
		    				tableHtml+= "</tr>";
		    			}
	    			}
	    			document.getElementById("infoStudentsTableBody").innerHTML = tableHtml;
	    			$("#infoStudentsTable").DataTable();
	    			document.getElementById("loader").style.display = "none";
	    			document.getElementById("modalBody").style.display = "block";
	    		},
	    		error: function(request) {
	    			console.log(request.responseText);
	    			setTimeout(function() {
	    				getSectionInfo(sectionId);
	    			}, 3000)
	    		}
	    	})
	    }


	});

</script>
</html>