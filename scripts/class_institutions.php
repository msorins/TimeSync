<?php
include 'class_core.php';


class institutions extends core
{	
	public function __construct()
	{
		$type=NULL;
		if(isset($_GET["type"]))
			$type=$this->secure($_GET["type"]);
		if($type=="put_data")
			$this->put_data($_POST["institutions_name"]);
		if($type=="delete_data")
			$this->delete_data($_GET["id"]);
		if($type=="send_json")
			echo $this->send_json();
	}
	
	private function put_data($name)
	{
		$name=$this->secure($name);
		mysql_query("INSERT INTO  `institutions` (`institutions_id` ,`institutions_name`)VALUES (NULL ,  '$name')");
		header('Location: /institutions.php');
	}
	
	private function delete_data($id)
	{
		$id=$this->secure($id);
		mysql_query("DELETE FROM `institutions` WHERE `institutions`.`institutions_id` = '$id'");
		header('Location: /institutions.php');
	}
	
	
	public function list_data()
	{
		$val=array();
		$query=mysql_query("SELECT * FROM  `institutions` ORDER BY  `institutions`.`institutions_id` DESC ");
		
		while($k=mysql_fetch_array($query))
		{
			if($this->has_access($this->get_from_sesion("users_id"),$k["institutions_id"]))
				array_push($val,$k);
		}
		return $val;
	}
	
	public function list_data_public()
	{
		$val=array();
		$query=mysql_query("SELECT * FROM  `institutions` ORDER BY  `institutions`.`institutions_id` DESC ");
		
		while($k=mysql_fetch_array($query))
		{
				array_push($val,$k);
		}
		return $val;
	}
	
	public function get_name_form_id($id)
	{
		$query=mysql_query("SELECT * FROM  `institutions` WHERE  `institutions_id` = '$id' ") or die(mysql_error());
		$k=mysql_fetch_array($query);
		return $k["institutions_name"];
	}
	
	private function send_json()
	{
		$str=array();
		$query=mysql_query("SELECT * FROM  `institutions` ORDER BY  `institutions`.`institutions_id` DESC ");
		$c=0;
		while($k=mysql_fetch_array($query))
		{
			$str[$c]=$k["institutions_name"];
			$c++;
		}
		
		$output = json_encode(array('institutions' => $str));
		return $output;
	}
}
$obj_institutions=new institutions();
?>