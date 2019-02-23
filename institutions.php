<?php
include 'scripts/class_institutions.php'; 
if($obj_core->get_from_sesion("is_logged")!=1)
	header('Location: /'.PROJ_NAME.'/error.php');
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
  <body>
      <?php include 'views/header.php'; ?>
	  <div style="min-height:800px;">
	  <div  class="tile center-block formular-middle">
	  <h4> Adaugă o instituție</h4>
	  <br>
            <form action="scripts/class_institutions.php?type=put_data" method="post" enctype="multipart/form-data" role="form" class="center-block formular-middle">
				  <input name="institutions_name" id="announces_title" type="text" class="form-control" placeholder="Numele instituției">
				  <br>
			 <button class="btn btn-primary btn-large btn-block" type="submit">Adaugă</button>
			</form>
       </div>
	  <div style="margin-top:40px;" class="tile center-block formular-middle">
	  <h4> Lista instituților </h4>
	  <br>
       <?php
		 $k=$obj_institutions->list_data();
		 for($i=0; $i<count($k); $i++)
		 {
			 ?>
			 <div style="background-color:white; border:1px solid #bdc3c7; margin-top:10px;" class="center-block formular-middle">
			 
			 <h4><?php echo $k[$i]["institutions_name"]; ?><a href="scripts/class_institutions.php?type=delete_data&id=<?php echo $k[$i]["institutions_id"];?>"><span style="float:right" class="fui-trash"></span></a></h4>
			 </div>
			 <?php
		 }
	   ?>
       </div>
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
