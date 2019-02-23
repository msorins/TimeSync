<?php
include 'class_core.php';

class timetable_struct
{
	public $day;
	public $hours_time = array();
	public $hours_number;
	public $hours_list = array();
}

class metadata
{
	public $version;
}
class timetables extends core
{	
	public function __construct()
	{
		$type=NULL;
		if(isset($_GET["type"]))
			$type=$this->secure($_GET["type"]);
		if($type=="put_data")
			$this->put_data($_POST["timetables_institution_id"],$_POST["timetables_name"]);
		if($type =="edit_data")
			$this->edit_data($_GET["id"]);
		if($type=="delete_data")
			$this->delete_data($_GET["id"]);
		if($type=="get_timetable")
			return $this->get_timetable($_GET["id"]);
		if($type=="get_timetables_from_institution")
			echo $this->get_timetables_from_institution($_GET["id"]);
		if($type=="send_json_from_institution")
			echo $this->send_json_from_institution($_GET["name"]);
		if($type=="redirect_to_timetable")
			$this->redirect_to_timetable($_POST["classes_options"]);
		if($type=="send_json")
			echo $this->send_json($_GET["institution"],$_GET["class"]);
		if($type=="redirect")
			$this->redirect($_POST["timetables_institution_id"]);
	}
	
	private function put_data($id,$name)
	{
		$id=$this->secure($id);
		$name=$this->secure($name);
		mysql_query("INSERT INTO  `timetables` (`timetables_id` ,`timetables_institution_id` ,`timetables_name` ,`timetables_day_1_classes` ,`timetables_day_1_time` ,`timetables_day_1_hours` ,`timetables_day_2_classes` ,`timetables_day_2_time` ,`timetables_day_2_hours` ,`timetables_day_3_classes` ,`timetables_day_3_time` ,`timetables_day_3_hours` ,`timetables_day_4_classes` ,`timetables_day_4_time` ,`timetables_day_4_hours` ,`timetables_day_5_classes` ,`timetables_day_5_time` ,`timetables_day_5_hours`)VALUES (NULL ,  '$id',  '$name',  '',  '', NULL ,  '',  '', NULL ,  '',  '', NULL ,  '',  '', NULL ,  '',  '', NULL);") or die(mysql_error());

		header('Location: /timetables.php');
	}
	private function edit_data($id)
	{
		$timetables_name=$this->secure($_POST["timetables_name2"]);
		$timetables_institution_id=$this->secure($_POST["timetables_institution_id2"]);

		$data=array();
		for($i=1; $i<=5; $i++)
		{
			$data[$i]=array();
			$data[$i]["classes"]=NULL;
			$data[$i]["time"]=NULL;
			$data[$i]["hours"]=NULL;
			$data[$i]["exists"]=NULL;
			for($j=1; $j<=7; $j++)
			{
				$checkbox =  $this->secure($_POST["timetables_day_".$i."_checkbox_".$j]);
				$class =  $this->secure($_POST["timetables_day_".$i."_classes_".$j]);
				if($checkbox==NULL)
					$checkbox="no";
				$sh=$this->secure($_POST["timetables_day_".$i."_hours_sh_".$j]);
				$sm=$this->secure($_POST["timetables_day_".$i."_hours_sm_".$j]);
				$fh=$this->secure($_POST["timetables_day_".$i."_hours_fh_".$j]);
				$fm=$this->secure($_POST["timetables_day_".$i."_hours_fm_".$j]);
				
				if($checkbox=="yes")
				{
					$data[$i]["classes"].=$class."#";
					$data[$i]["time"].=$sh.":".$sm." - ".$fh.":".$fm."#";
					$data[$i]["hours"]++;
					$data[$i]["exists"].="1#";
				}
				else
				{
					$data[$i]["classes"].="#";
					$data[$i]["time"].="#";
					$data[$i]["exists"].="0#";
				}
				
			}

		}
		mysql_query("UPDATE  `timetables` SET  `timetables_institution_id` =  '$timetables_institution_id',
		`timetables_name` =  '$timetables_name',
		`timetables_edit_date` =  now(),
		`timetables_day_1_classes` =  '".$data[1][classes]."',
		`timetables_day_1_time` =  '".$data[1][time]."',
		`timetables_day_1_hours` =  '".$data[1][hours]."',
		`timetables_day_1_exists` =  '".$data[1][exists]."',
		`timetables_day_2_classes` =  '".$data[2][classes]."',
		`timetables_day_2_time` =  '".$data[2][time]."',
		`timetables_day_2_hours` =  '".$data[2][hours]."',
		`timetables_day_2_exists` =  '".$data[2][exists]."',
		`timetables_day_3_classes` =  '".$data[3][classes]."',
		`timetables_day_3_time` =  '".$data[3][time]."',
		`timetables_day_3_hours` =  '".$data[3][hours]."',
		`timetables_day_3_exists` =  '".$data[3][exists]."',
		`timetables_day_4_classes` =  '".$data[4][classes]."',
		`timetables_day_4_time` =  '".$data[4][time]."',
		`timetables_day_4_hours` =  '".$data[4][hours]."',
		`timetables_day_4_exists` =  '".$data[4][exists]."',
		`timetables_day_5_classes` =  '".$data[5][classes]."',
		`timetables_day_5_time` =  '".$data[5][time]."',
		`timetables_day_5_hours` =  '".$data[5][hours]."',
		`timetables_day_5_exists` =  '".$data[5][exists]."'		WHERE  `timetables`.`timetables_id` ='$id';") or die(mysql_error());
		
		//header('Location: /'.PROJ_NAME.'/timetables.php');
		header('Location: /timetables.php?type=edit&id='.$id);
		
	}

	private function delete_data($id)
	{
		
		$id=$this->secure($id);
		mysql_query("DELETE FROM `timetables` WHERE `timetables`.`timetables_id` = '$id'");
		header('Location: /timetables.php');
		
	}
	
	
	public function list_data()
	{
		
		$val=array();
		$query=mysql_query("SELECT * FROM  `timetables` ORDER BY  `timetables`.`timetables_id` DESC ");
		
		while($k=mysql_fetch_array($query))
		{
			if($this->has_access($this->get_from_sesion("users_id"),$k["timetables_institution_id"]))
				array_push($val,$k);
		}
		return $val;
	
	}
	
	public function get_timetable($id)
	{
		$id=$this->secure($id);
		$query=mysql_query("SELECT * FROM  `timetables` WHERE  `timetables_id` ='$id' ");
		$k=mysql_fetch_array($query);
		if($this->has_access($this->get_from_sesion("users_id"),$k["timetables_institution_id"])!=1)
			header('Location: /error.php');
		return $k;

	}
	
	public function get_timetable_from_name($name)
	{
		$name=$this->secure($name);
		$query=mysql_query("SELECT * FROM  `timetables` WHERE  `timetables_name` ='$name' ");
		$k=mysql_fetch_array($query);
		return $k;

	}
	
	private function get_timetables_from_institution($id)
	{
		$id=$this->secure($id);
		$query=mysql_query("SELECT * FROM  `timetables` WHERE  `timetables_institution_id` ='$id' ");
		$response=NULL;
		while($k=mysql_fetch_array($query))
			$response.=$k["timetables_name"]."#";
		
		return $response;
	}
	
	private function send_json_from_institution($name)
	{
		$name=$this->secure($name);
        
		$query=mysql_query("SELECT * FROM  `institutions` WHERE  `institutions_name` LIKE  '$name'");
		$k=mysql_fetch_array($query);
		$id=$k["institutions_id"];
		
		$query=mysql_query("SELECT * FROM  `timetables` WHERE  `timetables_institution_id` ='$id' ");
		$str=array(); $c=0;
		while($k=mysql_fetch_array($query))
		{
			$str[$c]=$k["timetables_name"];
			$c++;
		}
		
		$output = json_encode(array('timetables_list' => $str));
		return $output;

	}
	private function redirect_to_timetable($name)
	{
		$name=str_replace(" ", "+",$name);
		header('Location: /webview.php?name='.$name);
	}
	
	private function send_json($institution, $class)
	{
		$institution=$this->secure($institution);
		$class=$this->secure($class);

		$query=mysql_query("SELECT * FROM  `institutions` WHERE  `institutions_name` LIKE  '$institution'");
		$k=mysql_fetch_array($query);
		$id=$k["institutions_id"];
		
		
		$str= array();
		$days=array("","Luni","Marti","Miercuri","Joi","Vineri");
		
		$query=mysql_query("SELECT * FROM  `timetables` WHERE  `timetables_institution_id` = '$id' AND  `timetables_name` LIKE  '$class' ");
		$k=mysql_fetch_array($query);
		for($i=1; $i<=5; $i++)
		{
			$classes=explode("#",$k["timetables_day_".$i."_classes"]);
			$time=explode("#",$k["timetables_day_".$i."_time"]);
			$exists=explode("#",$k["timetables_day_".$i."_exists"]);
			
			$str[$i-1] = new timetable_struct();
			$str[$i-1]->day=$days[$i];
			$str[$i-1]->hours_number=$k["timetables_day_".$i."_hours"];
			
			for($j=1; $j<=7; $j++)
			{
				if($exists[$j-1]==0)
						  continue;
				$str[$i-1]->hours_time[$j-1]=$time[$j-1];
				$str[$i-1]->hours_list[$j-1]=$classes[$j-1];
			}
		}
		$str2 = array();
		$str2[0]= new metadata();
		$str2[0] -> version= "1";
		
		$output= array();

		$output['timetable'] = $str;
		$output['metadata'] = $str2;
		return json_encode($output);
	}
	
	private function redirect($id)
	{
		header('Location: /announces.php?institution_id='.$id);
	}
}
$obj_timetables=new timetables();
?>