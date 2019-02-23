<?php
include 'class_core.php';

class announces_struct
{
	public $id;
	public $title;
	public $message;
	public $date;
}

class announces extends core
{	
	public function __construct()
	{
		$type=NULL;
		if(isset($_GET["type"]))
			$type=$this->secure($_GET["type"]);
		if($type=="put_data")
			$this->put_data($_POST["announces_title"],$_POST["announces_message"],$_GET["institution_id"]);
		if($type=="delete_data")
			$this->delete_data($_GET["id"],$_GET["institution_id"]);
		if($type=="send_json")
			echo $this->send_json($_GET["institution_name"]);
	}
	
	private function put_data($title, $message, $institution_id)
	{
		$title=$this->secure($title);
		$message=$this->secure($message);
		$institution_id=$this->secure($institution_id);
		echo $institution_id."da";
		mysql_query("INSERT INTO `announces` (`announces_id`, `announces_title`, `announces_message`, `announces_date`,`announces_institution_id`) VALUES (NULL, '$title', '$message', CURRENT_TIMESTAMP, $institution_id);") or die(mysql_error());
		header('Location: /announces.php?institution_id='.$institution_id);
	}
	
	private function delete_data($id,$institution_id)
	{
		$id=$this->secure($id);
		$institution_id=$this->secure($institution_id);
		mysql_query("DELETE FROM `announces` WHERE `announces`.`announces_id` = '$id'");
		header('Location: /announces.php?institution_id='.$institution_id);
	}
	
	private function send_json($institution_name)
	{	
	
		$query=mysql_query("SELECT * FROM  `institutions` WHERE  `institutions_name` LIKE  '$institution_name'");
		$k=mysql_fetch_array($query);
		$id=$k["institutions_id"];
		
		$str= array();

		$query=mysql_query("SELECT * FROM  `announces`  WHERE  `announces_institution_id` ='$id' ORDER BY  `announces`.`announces_id` DESC ");
		$c=0;
		while($k=mysql_fetch_array($query))
		{
			$str[$c] = new announces_struct();
			$str[$c]->id=$c;
			$str[$c]->title=$k["announces_title"];
			$str[$c]->message=$k["announces_message"];
			$str[$c]->date=$k["announces_date"];
			$c++;
		}

		$output = json_encode(array('announces' => $str));
		return $output;
	}
	
	public function list_data($institution_id)
	{
		$institution_id=$this->secure($institution_id);
		if($this->has_access($this->get_from_sesion("users_id"),$institution_id)!=1)
			header('Location: /error.php');
			
		$val=array();
		$query=mysql_query("SELECT * FROM  `announces` WHERE  `announces_institution_id` ='$institution_id' ORDER BY  `announces`.`announces_id` DESC ");
		
		while($k=mysql_fetch_array($query))
		{
			array_push($val,$k);
		}
		return $val;
	}
}
$obj_announces=new announces();
?>