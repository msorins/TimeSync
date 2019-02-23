<?php
include 'scripts/class_institutions.php'; 
include 'scripts/class_users.php'; 
$type=NULL;
if(isset($_GET["type"]))
	$type=$_GET["type"];
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
		  if($type=="login"){ ?>
			  <div style="margin-top:10%;" class="tile center-block formular-middle">
			  <h4>Loghează-te</h4>
			  <br>
					<div style="margin-top:0px;" class="tile center-block formular-middle">
						<div class="center-block formular-middle" >
								 <form action="scripts/class_users.php?type=login_user" method="post" enctype="multipart/form-data" role="form" class="center-block">
									 <p class="help-block" style="float:left; margin-bottom:5px;">Nume utilizator : </p>
									 <input name="users_name" id="users_name" type="text" class="form-control">
									 <br>
									 <p class="help-block" style="float:left; margin-bottom:5px;">Parolă : </p>
									 <input name="users_password" id="users_password" type="password" class="form-control">
									 <br>
									 <button class="btn btn-primary btn-large btn-block" type="submit">Click</button>
								</form>
						</div>
				  </div>
			 </div>
			 <?php } 
			 if($type==NULL)
			 {
				 if($obj_core->get_from_sesion("users_rang")!=1)
					header('Location: /'.PROJ_NAME.'/');
			 ?>
			<div style=" margin-top:40px;" class="tile center-block formular-middle">
			  <h4> Adaugă un responsabil </h4>
			  <br>
				 <div style="margin-top:10px;" class="center-block formular-middle">
					<form action="scripts/class_users.php?type=put_data" method="post" enctype="multipart/form-data" role="form" style="width:100%" class="center-block">
					    <div class="row">
						    <div class="col-md-6">
								<input name="users_name" id="announces_title" type="text" class="form-control" placeholder="Nume">
								<br>
								
								<p class="help-block" style="float:left; margin-bottom:5px;">Grad acces</p>
								<select name="users_rang" class="form-control">
									  <option value="1">Rang 1 ( administrator )</option>
									  <option value="2">Rang 2 ( moderator )</option>
								</select>
								<br>
							</div>
							
							<div class="col-md-6">
								<input name="users_password" id="announces_title" type="text" class="form-control" placeholder="Parolă">
								<br>
								
								<p class="help-block" style="float:left; margin-bottom:5px;">Instituții accesibile</p>
								<select name="users_institutions_id[]" class="form-control" multiple>
								<?php
									$k=$obj_institutions->list_data();
									for($i=0; $i<count($k); $i++)
									{
										?><option value="<?php echo $k[$i]["institutions_id"];?>"><?php echo $k[$i]["institutions_name"];?></option><?php
									}
								?>
								</select>
								<br>
							</div>
						</div>
						<button class="btn btn-primary btn-large btn-block" type="submit">Adaugă</button>
				    </form>
				</div>
			</div>
			<div style="margin-top:40px;" class="tile center-block formular-middle">
			  <h4> Lista responsabili </h4>
			  <br>
			  <?php 
			  $k=$obj_users->list_data();
			  for($i=0; $i<count($k); $i++)
			  {
				  ?>
				  <div style="width:70; background-color:white; border:1px solid #bdc3c7; margin-top:10px;" class="center-block">
				  <h4><?php echo $k[$i]["users_name"]." ( grad : ".$k[$i]["users_rang"]." )";?><a href="scripts/class_users.php?type=delete_data&users_id=<?php echo $k[$i]["users_id"];?>"><span style="float:right; margin-right:5px; margin-left:5px;" class="fui-trash"></span></a><a href="users.php?type=edit&id=<?php echo $k[$i]["users_id"];?>"><span style="float:right; margin-right:5px;" class="fui-new"></a></h4>
				  </div>
				  <?php
			  }
			  ?>
			</div>
	  </div>
		 <?php
		 }
		 
		 if($type=="edit")
		 {
			 $users_id=NULL;
			 if(isset($_GET["id"]))
				 $users_id=$_GET["id"];
			  $k=$obj_users->get_user($users_id);
			 ?>
			 
			 <div style=" margin-top:40px;" class="tile center-block formular-middle">
			  <h4> Editează un responsabil </h4>
			  <br>
				 <div style="margin-top:10px;" class="center-block formular-middle">
					<form action="scripts/class_users.php?type=edit_data&users_id=<?php echo $users_id;?>" method="post" enctype="multipart/form-data" role="form" style="width:100%" class="center-block">
					    <div class="row">
						    <div class="col-md-6">
								<input name="users_name" id="announces_title" type="text" class="form-control"  value="<?php echo $k["users_name"];?>">
								<br>
								
								<p class="help-block" style="float:left; margin-bottom:5px;">Grad acces</p>
								<select name="users_rang" class="form-control">
									  <option <?php if($k["users_rang"]=="1") echo "selected"; ?>  value="1">Rang 1 ( administrator )</option>
									  <option <?php if($k["users_rang"]=="2") echo "selected"; ?>  value="2">Rang 2</option>
								</select>
								<br>
							</div>
							
							<div class="col-md-6">
								<input name="users_password" id="announces_title" type="text" class="form-control" value="<?php echo $obj_users->decrypt($k["users_password"]);?>">
								<br>
								
								<p class="help-block" style="float:left; margin-bottom:5px;">Instituții accesibile</p>
								<select name="users_institutions_id[]" class="form-control" multiple>
								<?php
									$k=$obj_institutions->list_data();
									for($i=0; $i<count($k); $i++)
									{
										?><option <?php if($obj_users->has_access($users_id,$k[$i]["institutions_id"])==1) echo "selected"; ?> value="<?php echo $k[$i]["institutions_id"];?>"><?php echo $k[$i]["institutions_name"];?></option><?php
									}
								?>
								</select>
								<br>
							</div>
						</div>
						<button class="btn btn-primary btn-large btn-block" type="submit">Editează</button>
				    </form>
				</div>
			</div>
			 
			 <?php
		 }
		 ?>
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
