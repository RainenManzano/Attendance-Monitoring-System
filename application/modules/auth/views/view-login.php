<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>custom_css/index.css">
		<script type="text/script" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.js"></script>
        <script type="text/script" src="<?php echo base_url(); ?>assets/bootstrap/js/jquery-3.3.1.js"></script>
</head>
<body style="background-image: url(assets/1.jpg); background-size: 100%;background-repeat: no-repeat; background-color: black;">            
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12"></div>    
                <div class="col-md-4 col-sm-4 col-xs-12">
						<div class="form-group has-feedback">
							<form method="post" action="<?php echo base_url('auth'); ?>">
								<h2 style="color: white;" class="text-center">Welcome</h2>
								<h6 style="color: white;" class="text-center"> Sign in to start your session</h6><br>

								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" name="username" class="form-control" placeholder="Username">
								</div>

								<br>

								<div class="input-group">
                                      <div class="input-group-addon">
                                         <span class="glyphicon glyphicon-lock"></span>
                                      </div>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                            <span toggle=#password-field class="input-group-btn">
                                                 <button type="button" class="btn btn-default" onclick="ShowPass()" data-toggle="tooltip" title="Show Password">
                                                          <i id="eye"class="glyphicon glyphicon-eye-open toggle-password"></i>
                                                 </button>
                                         </span>
								</div>
                                
								<br>
                            	<?php 
                            		if(validation_errors()) {
                            			echo '<div class="alert alert-danger fade in">'.validation_errors().'</div>';
                            		}
                            		if(isset($error_msg)) {
                            			echo '<div class="alert alert-danger fade in">'.$error_msg.'</div>';
                            		}
                            	?>
                                <button type="submit" class="btn_style">Login  <span class="glyphicon glyphicon-log-in"></span></button>
                                <br>
                                <br>
                                <p class="text-center" style="color:white;">New here? Register a <a href="<?php echo base_url("register"); ?>">new account <span class="glyphicon glyphicon-new-window"></span></a></p>
							</form>
						</div>	
                </div>    
                <div class="col-md-4 col-sm-4 col-xs-12"></div>    
            </div>
        </div>        
</body>
   <script>
    			function ShowPass() {
				var x = document.getElementById("password");
				if (x.type === "password"){
					x.type = "text";
				} else {
					x.type = "password";
				}
			}    
    </script>
</html>