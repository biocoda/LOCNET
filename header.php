<!DOCTYPE html>
<html lang="en">
  	<head>
	  	<link rel="icon" href="assets/icons/locnet-icon.png">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user scalable=0; shrink-to-fit=no;">
		<meta name="description" content="LOTO Register v1.0">
		<meta name="author" content="STU51272">
		<link rel="icon" href="assets/icons/locnet-icon.png">
		<title>LOCNET</title>
        <script src="https://kit.fontawesome.com/9d1949a1b9.js" crossorigin="anonymous"></script>
		<script src="js/qrCodePacked.js"></script>
		<link href="css/oneStyle.css" rel="stylesheet">
		<!-- <link href="css/style.css" rel="stylesheet">
		<link href="css/locnetCSS.css" rel="stylesheet"> -->
  </head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
            </button>
        <a class="navbar-brand" href="#">
            <img class="navbar-brand-full" src="assets/logos/ruk-logo-black.jpg" width=90 height="33" alt="RUK Logo">
            <img class="navbar-brand-minimized" src="assets/icons/locnet-icon-menu.png" width="36" height="36" alt="RUK Logo">       
            </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
            </button>
    </header>
<div class="app-body">
<div id="mySidebar" class="sidebar">
	<nav class="sidebar-nav">
		<ul class="nav nav-ul">
            <li class="nav-item"><a class="nav-link" href="index.php"><i class="nav-icon fas fa-lock"></i>LOCNET</a></li>
			<li class="nav-item"><a class="nav-link" href="addIsolation.php"><i class="nav-icon fas fa-plus"></i>Add New Isolation</a></li>
            <li class="nav-item"><a class="nav-link" href="removeIsolation.php"><i class="nav-icon fas fa-edit"></i>Edit/Remove Isolation</a></li>
			<li class="divider"></li>
			<li class="nav-title">ISOLATIONS</li>
            <li class="nav-item"><a class="nav-link" href="isolations.php"><i id="isolationsIcon" class="nav-icon fas fa-globe"></i>All Isolations</a></li>          
			<li class="nav-item"><a class="nav-link" href="f1isolations.php"><i id="f1isolationsIcon" class="nav-icon fas fa-industry"></i>Factory 1</a></li>
			<li class="nav-item"><a class="nav-link" href="f2isolations.php"><i class="nav-icon fas fa-industry"></i>Factory 2</a></li>
			<li class="nav-item"><a class="nav-link" href="f3isolations.php"><i class="nav-icon fas fa-industry"></i>Factory 3</a></li>
			<li class="nav-item"><a class="nav-link" href="f4isolations.php"><i class="nav-icon fas fa-industry"></i>Factory 4</a></li>
		</ul>	
	</nav>
	<button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
<main class="main" id="mainWindow">