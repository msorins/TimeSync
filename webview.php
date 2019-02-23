<?php
include 'scripts/class_institutions.php'; 
include 'scripts/class_timetables.php'; 
$get_name=NULL;
if(isset($_GET["name"]))
	$get_name=$_GET["name"];
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
	  if($get_name==NULL){ ?>
		  <div style="margin-top:10%;" class="tile center-block formular-middle ">
		  <h4>Alege orarul</h4>
		  <br>
				<div style="width:73%; margin-top:0px;" class="tile center-block">
					<div class="center-block formular-middle">
						 <p class="help-block" style="float:left; margin-bottom:5px;">Instituția din care face parte orarul :</p>
							<select onchange="option_selected()" id="institutions_options" class="form-control">
							  <?php
							   $k=$obj_institutions->list_data_public();
							   for($i=0; $i<count($k); $i++)
								 {
									?><option value="<?php echo $k[$i]["institutions_id"];?>"><?php echo $k[$i]["institutions_name"];?></option><?php
								 }
							  ?>
							  </select>
							 <br>
							 <form action="scripts/class_timetables.php?type=redirect_to_timetable" method="post" enctype="multipart/form-data" role="form" class="center-block">
								 <p class="help-block" style="float:left; margin-bottom:5px;">Clasa : </p>
								 <select id="classes_options" name="classes_options" class="form-control" >
								 
								 </select>
								 <br>
								 <button class="btn btn-primary btn-large btn-block" type="submit">Click</button>
								 <br>
							</form>
					</div>
			  </div>
		 </div>
		 <?php } else { 
		$k=$obj_timetables->get_timetable_from_name($get_name);
		 ?>
		  <div style="width:70%; margin-top:20px;" class="tile center-block">
		  <h4><?php echo $k["timetables_name"];?></h4>
		  <p style="margin-top:-10px" class="help-block"><?php echo $obj_institutions->get_name_form_id($k["timetables_institution_id"]);?></p>
		  </div>
		<?php
		$days=array("","Luni","Marti","Miercuri","Joi","Vineri");
		for($i=1; $i<=5; $i++)
		{
			$classes=explode("#",$k["timetables_day_".$i."_classes"]);
			$time=explode("#",$k["timetables_day_".$i."_time"]);
			$exists=explode("#",$k["timetables_day_".$i."_time"]);
			?>
			<div style="width:70%; margin-top:20px;" class="tile center-block">
			<h4><?php echo $days[$i];?></h4>
			<br>
			<table class="table table-striped table-hover">
			  <thead>
				<tr>
				  <th width="20%">Nr.</th>
				  <th width="40%">Interval Orar</th>
				  <th width="30%">Materie</th>
				</tr>
			  </thead>
			  <tbody>
				  <?php
				  for($j=1; $j<=7; $j++)
				  {
					  if($exists[$j-1]==0)
						  continue;
					  ?>
					  <tr>
						  <td align="left"><?php echo $j; ?></td>
						  <td align="left"><?php echo $time[$j-1];?></td>
						  <td align="left"><?php echo $classes[$j-1];?></td>
						</tr>
					  <?php 
				  }
				  ?>
			  </tbody>
			</table>
	
			</div>
			<?php
		}?>
		  
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
  <script>
  option_selected();
  function option_selected()
  {
	  var id = document.getElementById("institutions_options").value;
	  var select = document.getElementById("classes_options"); 
	  var xmlhttp;
	  if (window.XMLHttpRequest)
		  xmlhttp=new XMLHttpRequest();
	  else
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		 
	  xmlhttp.onreadystatechange=function()
	  {
		 if (xmlhttp.readyState==4 && xmlhttp.status==200)
		 {
			var x=xmlhttp.responseText;
			x=x.split("#");
			select.innerHTML="";
			for(var i=0; i<x.length-1; i++)
			{
				var opt = x[i];
				var el = document.createElement("option");
				el.textContent = opt;
				el.value = opt;
				select.appendChild(el);
			}
		 }
	  }
	  xmlhttp.open("GET","scripts/class_timetables.php?type=get_timetables_from_institution&id="+id,true);
	  xmlhttp.send();
  }
  </script>
</html>
