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
<br>
<h4 style="text-align:center">Nu ai acces la această pagină.</h4>

<br>

<a href="/<?php echo PROJ_NAME;?>/" class="btn btn-block btn-lg btn-primary center-block">Întoarce-te înapoi</a>

<script src="dist/js/vendor/jquery.min.js"></script> 
<script src="dist/js/vendor/video.js"></script> 
<script src="dist/js/flat-ui.min.js"></script> 
<script src="docs/assets/js/application.js"></script> 
<script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
</body>
</html>