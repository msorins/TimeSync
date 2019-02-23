<?php
include 'scripts/class_core.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Mesota's Timetable - Android app</title>
<meta name="description" content=""/>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Loading Bootstrap -->
<link href="dist/css/vendor/bootstrap.min.css" rel="stylesheet">

<!-- Loading Flat UI -->
<link href="dist/css/flat-ui.css" rel="stylesheet">
<link href="docs/assets/css/demo.css" rel="stylesheet">
<link rel="shortcut icon" href="img/favicon.ico">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
      <script src="dist/js/vendor/html5shiv.js"></script>
      <script src="dist/js/vendor/respond.min.js"></script>
    <![endif]-->
</head>
<body style="width:100%;">
<?php include 'views/header.php'; ?>
<div style="min-height:800px;"> <img src="img/timetable.png" class="img-responsive center-block" alt="Imagine Orar"> <br>
  <h5 style="text-align:center">"TimeSync" este o aplicatie care iti afiseaza orarul intr-un mod mult mai eficient.</h5>
  <a href="https://play.google.com/store/apps/details?id=com.apps.MirceaSorinSebastian.TimeSync" class="btn btn-block btn-lg btn-primary">Descarcă</a> 
  
  <h6 style="text-align:center; margin-top:70px;">Demo aplicatie Android : </h6>
  
  <h5 style="text-align:center;">
    <video width="" height="500" controls>
	  <source src="demo_android.mp4" type="video/mp4">
	</video>
  </h5>
  
  </div>
<script src="dist/js/vendor/jquery.min.js"></script> 
<script src="dist/js/vendor/video.js"></script> 
<script src="dist/js/flat-ui.min.js"></script> 
<script src="docs/assets/js/application.js"></script> 
<script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
</body>
</html>