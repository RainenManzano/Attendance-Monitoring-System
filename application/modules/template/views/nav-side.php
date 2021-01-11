<!DOCTYPE html>
<html>
<head>
	<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables/Bootstrap-3.3.7/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables/datatables.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/DataTables_2/Buttons-1.5.4/buttons.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fontawesome-free-5.6.3-web/css/all.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>custom_css/justine-css.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/jquery.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/datatables.js" ></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/Bootstrap-3.3.7/js/bootstrap.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables_2/Buttons-1.5.4/js/dataTables.buttons.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables_2/Buttons-1.5.4/js/buttons.print.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/DataTables/Bootstrap-3.3.7/js/bootstrap.js"></script> 
</head>
    
    
<style>
    .navbar-default {
        background-color: #00887A;
        border-bottom: 6px solid #00564D;
        
    }

    .navbar-default .navbar-nav > li > a:hover {
        background-color: #00564D;
        color: white;
    }    
    
    .navbar-default .navbar-nav > li > a{
    -webkit-transition: 0.5s;
        transition: 0.5s;
    }
    
    .navbar-default .navbar-brand:hover {
        color: white;
    }
    .navbar-header .navbar-brand {color: white;}

    .navbar-default .navbar-nav > li > a {color: white;}
    
    
    .sidebar {
      height: 100%;
      width: 240px; 
      position: fixed; 
      z-index: 1; 
      top: 0; 
      left: 0;
      background-color: #282828; 
      overflow-x: hidden; 
      padding-top: 80px; 
        
    }
    
    
    .list_items > li {
        padding: 8px;
        margin: 8px;
        list-style-type: none;
         -webkit-transition: 0.3s;
        transition-duration: 0.3s;        
    }
    
    
    .list_items > li:hover {
        color: white;
        background-color: #363636;
        padding: 16px;
    }       
    
    .list_items > li > a {
        color: white;
        display: block;    
        text-decoration: none;
        cursor: pointer;
    }
    

    
    label {
        letter-spacing: 1px;
        font-weight: medium;
    }
    
    .fa .fa-user-circle {
        width: 150px;
        height: 150px;
    }
    
    .admin {
        text-align: center;
    }
    
    .admin > a > span {color: white;}
    
    .name {color: white;
           padding: 5px;}
    
</style>    
    
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">Attendance Monitoring System</a>
	    </div>
	    	<ul class="nav navbar-nav navbar-right">
	    		<li><a href="<?php echo base_url('auth/LoggingOut'); ?>">Log Out <span class="fa fa-sign-out-alt"></span></a></li>
	    	</ul>
	  </div>
	</nav>

    <div class="sidebar">

        <div class="list_items">
            <div class="admin">
            <a href=""><span class="fa fa-user-circle fa-5x"></span></a>
                <p class="name"><?php if($level==0) echo "Teacher"; else echo "Administrator"; ?></p>
            </div>
            <br>
            <li id="sideClass">
                <a href="<?php echo base_url('classes');?>"><i class="fa fa-users" style="font-size: 25px;"></i>&nbsp;&nbsp;<label>Class List</label></a>
            </li>
            
            <li id="sideSection">
                <a href="<?php echo base_url('section');?>"><span class="fa fa-clipboard-list" style="font-size: 25px;"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Section List</label></a>
            </li>
            
            <li id="sideStudent">
                <a href="<?php echo base_url('student');?>"><i class="fa fa-id-badge" style="font-size: 25px;"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Student List</label></a>
                    </li>
            <li id="sideSchedule">
                <a href="<?php echo base_url('schedule');?>"><span class="fa fa-calendar-check" style="font-size: 25px;"></span>&nbsp;&nbsp;&nbsp;&nbsp;<label>Schedule List</label></a>
                    </li>
            <?php
                if($level==1) {
                    echo "<li id='sideUser'>
                          <a href=".base_url('users')."><span class='glyphicon glyphicon-user' style='font-size: 25px;'></span>&nbsp;&nbsp;&nbsp;<label>User List</label></a>
                          </li>";
                }
            ?>
        </div>
    </div>
    
    
    
    
    
    
    
    
	<!--<div>
        <ul class="list-unstyled components">
			 <li class="active">
			     <a href="<?php echo base_url('classes');?>"><i class="fa fa-list-alt" style="font-size: 25px;"></i> Class List</a>
			  </li>
              <li>
			     <a href="<?php echo base_url('section');?>"><span class="glyphicon glyphicon-list" style="font-size: 25px;"></span> Section List</a>
			 </li>
			 <li>
			     <a href="<?php echo base_url('student');?>"><i class="fas fa-users" style="font-size: 25px;"></i> Student List</a>
			 </li>
			 <li>
			     <a href=""><span class="glyphicon glyphicon-calendar" style="font-size: 25px;"></span> Schedule List</a>
			     <a href="<?php echo base_url('users');?>"><span class="glyphicon glyphicon-user" style="font-size: 25px;"></span> User List</a>
			 </li>
        </ul>
    </div>-->