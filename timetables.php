<?php
include 'scripts/class_institutions.php'; 
include 'scripts/class_timetables.php'; 
if(isset($_GET["type"]))
	$type=$_GET["type"];
else
	$type=NULL;
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
  <body style="min-width:750px">
      <?php include 'views/header.php'; ?>
	  <div style="min-height:800px;">
	  <?php
	  if($type==NULL) {  ?>
		  <div style="width:70%" class="tile center-block">
		  <h4> Adaugă un orar</h4>
		  <br>
				<div class="center-block" style="width:50%">
					<p class="help-block" style="float:left; margin-bottom:5px;">Instituția din care face parte orarul :</p>
					<form action="scripts/class_timetables.php?type=put_data" method="post" enctype="multipart/form-data" role="form" class="center-block">
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
					 <p class="help-block" style="float:left; margin-bottom:5px;">Clasa : </p>
					 <input name="timetables_name" type="text" class="form-control" placeholder="Exemplu: IX-a B ">
					 <br>
					 <button class="btn btn-primary btn-large btn-block" type="submit">Adaugă</button>
					</form>
				</div>
		   </div>
		  <div style="width:70%; margin-top:40px;" class="tile center-block">
		  <h4> Lista orarelor </h4>
		  <br>
		   <?php
			 $k=$obj_timetables->list_data();
			 for($i=0; $i<count($k); $i++)
			 {
				 ?>
				 <div style="width:70; background-color:white; border:1px solid #bdc3c7; margin-top:10px;" class="center-block">
					<div class="row">
					<div class="col-md-2">
						<p class="help-block" style="margin-top:20px; margin-bottom=-15px; flat:left; ">Instituția de învățământ: <?php echo $obj_institutions->get_name_form_id($k[$i]["timetables_institution_id"]); ?></p>
					</div>
					<div class="col-md-8">
						<h4><?php echo $k[$i]["timetables_name"]; ?></h4>
					</div>
					<div class="col-md-2">
						<h4><a href="scripts/class_timetables.php?type=delete_data&id=<?php echo $k[$i]["timetables_id"];?>"><span style="float:right; margin-left:5px;" class="fui-trash"></span></a>
						<a href="timetables.php?type=edit&id=<?php echo $k[$i]["timetables_id"];?>"><span style="float:right; margin-right:15px;"  class="fui-gear"></span></a> </h4>
					</div>
					</div>
				 </div>
				 <?php
			 }
		   ?>
		   </div>
	  <?php } 
	  if($type=="edit")
	  {
		  if(isset($_GET["id"]))
			  $id=$_GET["id"];
		  else
			  $id=NULL;
		  
		  $crt_timetable=$obj_timetables->get_timetable($id);
		  ?>
		  <div style="width:76%; margin-top:-20px; background-color:white;" class="tile center-block">
			<h4 class="center-block">Editare orar</h4>
			<hr>
		  </div>
		  <form action="scripts/class_timetables.php?type=edit_data&id=<?php echo $id;?>" method="post" enctype="multipart/form-data" role="form" class="center-block">
		  <div style="width:76%; margin-top:20px;" class="tile center-block">
			<h4 class="center-block">Informații generale</h4>
				<div class="center-block" style="width:50%">
					 <p class="help-block" style="float:left; margin-bottom:5px;">Instituția din care face parte orarul :</p>
						<select name="timetables_institution_id2" class="form-control">
						  <?php
						   $k=$obj_institutions->list_data();
						   for($i=0; $i<count($k); $i++)
							 {
								?><option <?php if($crt_timetable["timetables_institution_id"]==$k[$i]["institutions_id"]) echo "selected"; ?> value="<?php echo $k[$i]["institutions_id"];?>"><?php echo $k[$i]["institutions_name"];?></option><?php
							 }
						  ?>
						  </select>
						  
						 <p class="help-block" style="float:left; margin-bottom:5px;">Numele clasei : </p>
						 <input name="timetables_name2" type="text" class="form-control" value="<?php echo $crt_timetable["timetables_name"];?>">
						 <br>
				</div>
		  </div>	
		  <?php
		  $days=array("","Luni","Marti","Miercuri","Joi","Vineri");
		  for($i=1; $i<=5; $i++)
		  {
			  $classes=explode("#",$crt_timetable["timetables_day_".$i."_classes"]);
			  $exists=explode("#",$crt_timetable["timetables_day_".$i."_exists"]);
			  $time=explode("#",$crt_timetable["timetables_day_".$i."_time"]);
			  ?>
			  <div style="width:76%; margin-top:20px;" class="tile center-block">

				 	<button onclick="fill(<?php echo $i;?>)" style="width:100px; position:absolute; float:left;" class="btn btn-block btn-lg btn-primary" type="button">Autofill </button>
					<h4 style="margin-bottom:20px;" class="center-block"><?php echo $days[$i]; ?></h4>
	
				<?php
				for($j=1; $j<=7; $j++) 
				{
				$crt_s_d=explode(" - ",$time[$j-1]); // xy:zw  -  ab:cd   => xy:zw si ab:cd
				$crt_h_m1=explode(":",$crt_s_d[0]);  // xy:zw  => xy si zw
				$crt_h_m2=explode(":",$crt_s_d[1]);  // ab:cd  => ab si cd
				?>
					<div class="row" style="margin-top:5px;">
						<div class="col-md-2 xol-xs-12 col-sm-12">
						<p style="margin-bottom:10px;" class="help-block">
						<?php 
						if($j==1)
							echo "Prima oră";
						else
							echo "A ".$j."-a oră";
						?>
						</p>
						</div>
						<div class="col-md-5 col-xs-6 col-sm-6">
						<input value="<?php echo $crt_h_m1[0];?>" type="number" id="timetables_day_<?php echo$i; ?>_hours_sh_<?php echo $j; ?>"  name="timetables_day_<?php echo$i; ?>_hours_sh_<?php echo $j; ?>" min="1" max="24">:<input value="<?php echo $crt_h_m1[1];?>"  type="number" id="timetables_day_<?php echo$i; ?>_hours_sm_<?php echo $j; ?>" name="timetables_day_<?php echo$i; ?>_hours_sm_<?php echo $j; ?>" min="0" max="59"> -> <input value="<?php echo $crt_h_m2[0];?>"  type="number" id="timetables_day_<?php echo$i; ?>_hours_fh_<?php echo $j; ?>" name="timetables_day_<?php echo$i; ?>_hours_fh_<?php echo $j; ?>" min="1" max="24">:<input value="<?php echo $crt_h_m2[1];?>"  type="number" id="timetables_day_<?php echo$i; ?>_hours_fm_<?php echo $j; ?>" name="timetables_day_<?php echo$i; ?>_hours_fm_<?php echo $j; ?>" min="0" max="59">
						</div>
						
						<div class="col-md-3 col-xs-4 col-sm-4">
						<input name="timetables_day_<?php echo$i; ?>_classes_<?php echo $j; ?>" type="text" class="form-control" value="<?php echo $classes[$j-1];?>">
						</div>
						
						<div class="col-md-2 col-xs-2 col-sm-2">
						 <input value="yes" id="timetables_day_<?php echo$i; ?>_checkbox_<?php echo $j; ?>" name="timetables_day_<?php echo$i; ?>_checkbox_<?php echo $j; ?>" type="checkbox" <?php if($exists[$j-1]=="1") echo "checked"; ?> data-toggle="switch" id="custom-switch-03" data-on-text="<span class='fui-check'></span>" data-off-text="<span class='fui-cross'></span>" />
						</div>
				   </div>
				<?php } ?>
			  </div>
			  <?php
		  }
		  ?>
		  <div style="width:76%; margin-top:20px; margin-bottom:20px;" class="center-block">
			<button class="btn btn-primary btn-large btn-block" type="submit">Salvează</button>
		  </div>
		  </form>
		 <?php
		  
	  }
	  ?>
	  </div>
	<script>
	function fill(day)
	{
		var hr = prompt("Introduceți ora de începere a cursurilor", "8");
	    hr=Number(hr);
		for(var i=1; i<=7; i++)
		{
			document.getElementById("timetables_day_"+day+"_hours_sm_"+i).value="0";
			document.getElementById("timetables_day_"+day+"_hours_fm_"+i).value="50";
			document.getElementById("timetables_day_"+day+"_hours_sh_"+i).value=hr;  
			document.getElementById("timetables_day_"+day+"_hours_fh_"+i).value=hr; 
			hr++;
		

		}
	}
	</script>
    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>

    <script>
      videojs.options.flash.swf = "dist/js/vendors/video-js.swf"
    </script>
  </body>
</html>
