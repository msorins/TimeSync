<?php
include 'scripts/class_announces.php'; 
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
	  <?php
	  $institution_id=NULL;
	  if(isset($_GET["institution_id"]))
		  $institution_id = $_GET["institution_id"];
	  
	  if($institution_id==NULL) { ?>
	  <div  class="tile center-block formular-middle">
		  <h4> Alege institutia</h4>
		  <br>
					<div class="center-block formular-middle" >
						<p class="help-block" style="float:left; margin-bottom:5px;">Instituția din care face parte orarul :</p>
						<form action="scripts/class_timetables.php?type=redirect" method="post" enctype="multipart/form-data" role="form" class="center-block">
							  <select name="timetables_institution_id" class="form-control">
							  <?php
							   $k=$obj_institutions->list_data();
							   for($i=0; $i<count($k); $i++)
								 {
									?><option value="<?php echo $k[$i]["institutions_id"];?>"><?php echo $k[$i]["institutions_name"];?></option><?php
								 }
							  ?>
							  </select>
						 <br>
						 <button class="btn btn-primary btn-large btn-block" type="submit">Alege</button>
						</form>
					</div>
					
		</div>
	  <?php } else { ?>
		  <div  class="tile center-block formular-middle">
		  <h4> Scrie un anunț </h4>
		  <br>
				<form action="scripts/class_announces.php?type=put_data&institution_id=<?php echo $institution_id;?>" method="post" enctype="multipart/form-data" role="form" style="width:50%" class="center-block">
					  <input name="announces_title" id="announces_title" type="text" class="form-control" placeholder="Titlu">
					  <br>
					  <input name="announces_message" id="announces_message" type="text" class="form-control"  placeholder="Mesaj">
					  <br><br>
				 <button class="btn btn-primary btn-large btn-block" type="submit">Trimite</button>
				</form>
		   </div>
		  <div style="margin-top:40px;" class="tile center-block formular-middle">
		  <h4> Lista anunturilor </h4>
		  <p style="margin-top:-10px" class="help-block"><?php echo $obj_institutions->get_name_form_id($institution_id);?></p>
		  <br>
		   <?php
			 $k=$obj_announces->list_data($institution_id);
			 for($i=0; $i<count($k); $i++)
			 {
				 ?>
				 <div style="background-color:white; border:1px solid #bdc3c7; margin-top:10px;" class="center-block formular-middle">
				 
				 <h4><?php echo $k[$i]["announces_title"]; ?><a href="scripts/class_announces.php?type=delete_data&id=<?php echo $k[$i]["announces_id"];?>&institution_id=<?php echo $institution_id;?>"><span style="float:right" class="fui-trash"></span></a></h4>
				 <br>
				 <p><?php echo $k[$i]["announces_message"];?></p>
				 </div>
				 <?php
			 }
		   ?>
		   </div>
	  <?php } ?>
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
