<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>custom_css/register.css">    
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/DataTables/Bootstrap-3.3.7/css/bootstrap.css">

</head>

<style>

.container {
        margin-top: 20px;
    }
    
body {
    background-color: black;
	background-image: url(../assets/1.jpg);     
    }    
    
.input-group-addon {
    color: white;
    background-color: #00897B;
}    
    
.input-group {
        margin: 12px;
    }
    
div.container{
        color: #00897B;
    }
    
.btn-default {
        color: black;
        background-color: #00564D;
        border: 0px;
        width: 100%;
        -webkit-transition-duration: 0.2s;
        transition-duration: 0.2s;
    }
    
.btn-default:hover {
        color: white;
        background-color: #00897B;
    }     

.panel-default > .panel-heading {
        background-color: #00897B;
        color: white;
        border: 0px;
    }
    
 .panel-footer {
        background-color: transparent;
    }    
    
.panel-default {
        border: 0px;
    }
    
.panel-d.panel-body {
        background-color: transparent;
    }
</style>
    

<body>            
        <div class="container">
            <div class="col-md-3"></div>  
                <div class="col-md-6">
                    <div class="panel-group">
                       <form class="form-group" method="post" action="<?php echo base_url('register');?>" id="registerForm">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="text-center">Create Account </h3></div>
                                    <div class="panel-body">
                                        <?php
                                             if(validation_errors()) {
                                        ?>
                                            <div class="alert alert-danger" style="margin-top:20px;">
                                                <strong><?php echo validation_errors(); ?></strong>
                                            </div>
                                        <?php 
                                            }
                                        ?>   
                                        <div class="alert alert-danger" id="validationDiv" style="display:none;">The account you are trying to register are already taken. Please fill out correctly the firstname, lastname and your birthday. </div>
                                        <h4>Name</h4>
                                        <div class="input-group">
                                            <span class="input-group-addon"><b>First&nbsp;&nbsp;&nbsp;&nbsp;</b></span>
                                                <input type="text" class="form-control" name="firstname" placeholder="Enter your first name" value="<?php echo set_value('firstname');?>" />
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon"><b>Middle</b></span>    
                                                <input type="text" class="form-control" name="middlename" placeholder="Enter your middle name" value="<?php echo set_value('middlename');?>"/>
                                        </div>

                                        <div class="input-group">                        
                                            <span class="input-group-addon"><b>Last&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span>
                                                <input type="text" class="form-control" name="lastname" placeholder="Enter your last name" value="<?php echo set_value('lastname');?>"/>                    
                                        </div>

                                        <h4>Birthday</h4>
                                            <div class="input-group">
                                                <span class="input-group-addon"><b>Select Birthdate</b></span>
                                                <input type="date" id="datepicker" class="form-control" name="birthdate" value="<?php echo set_value('birthdate');?>"/>     
                                            </div>
                           
                                         <h4>Sex</h4>
                                            <div class="input-group">
                                                <span class="input-group-addon"><b>I am</b></span>
                                                    <select class="form-control"> 
                                                        <option class="selected hidden">(Please select)</option>
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                    </select>
                                            </div>

                                        <h4>Account</h4>
                                            <div class="input-group">
                                                <span class="input-group-addon"><b>Username</b></span>
                                                    <input type="text" class="form-control" name="username" placeholder="Create your username" value="<?php echo set_value('username');?>" /> 
                                            </div>       


                                        <div class="input-group">
                                             <span class="input-group-addon"><b>Password</b></span>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Create your password" value="<?php echo set_value('password');?>"/>
                                                        <span toggle=#password-field class="input-group-btn">
                                                             <button type="button" class="btn btn-success" onclick="ShowPass()" data-toggle="tooltip" title="Show Password">
                                                                      <i id="eye"class="glyphicon glyphicon-eye-open toggle-password"></i>
                                                             </button>
                                                     </span>
                                        </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-default btn-lg">Sign Up</button>
                                  
                           </div> 
                        </div> 
                    </form>      
                            
                 </div>                      
             </div>  
                                 
        </div>  
    <div class="col-md-3"> </div>  
</div>     
         
</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/DataTables/Bootstrap-3.3.7/js/bootstrap.js"></script>
   <script>
            $(document).ready(function() {

                function ShowPass() {
                    var x = document.getElementById("password");
                    if (x.type === "password"){
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }    

                document.getElementById("registerForm").onsubmit = function() {
                    var first = $("input[name='firstname']").val();
                    var last = $("input[name='lastname']").val();
                    var birthdate = $("input[name='birthdate']").val();
                    console.log(birthdate);
                    $.ajax({
                        method: "POST" , 
                        url: base_url+"register/checkDuplications", 
                        dataType: "JSON",
                        async: false,
                        data: {
                            "firstname": first,
                            "lastname": last,
                            "birthdate": birthdate
                        }, 
                        success: function(data) {
                            console.log(data)
                            if(data>0) {
                                document.getElementById("validationDiv").style.display = "block";
                                return false;
                            } else if(data==0){
                                document.getElementById("registerForm").submit();
                            }
                        }, 
                        error: function(err) {
                            console.log(err.responseText);
                        }
                    });
                    return false;
                }



            });
    </script>
</html>