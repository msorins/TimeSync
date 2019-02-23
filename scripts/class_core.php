<?php

if(defined("ROOT")==0)
	define("ROOT", "/home/admin/web/projects.ironcoders.com/public_html/Timetable");
if(defined("PROJ_NAME")==0)
	define("PROJ_NAME", "Timetable");

if (class_exists("core")==0)
{
	class core
	{
		public function __construct ()
		{
			$this->connect_mysql();
			if(session_id() == '')
				session_start();
		}
		
		//Se conecteaza la mysql
		private function connect_mysql()
		{
			// informatii de conectare
			$host = "#"; 
			$users = "#"; 
			$pass = "#"; 
			$db = "#";
			
			// deschide conexiunea
			$connection = mysql_connect($host, $users, $pass) or die ("Unable to connect!". mysql_error());
			// selecteaza baza de date
			mysql_select_db($db) or die ("Unable to select database!". mysql_error());
			mysql_set_charset('utf8',$connection); //THIS IS THE IMPORTANT PART
		}
		
		//Sanitizeaza input-ul
		public function secure($string)
		{
			if(isset($string))
			{
				$string=mysql_real_escape_string($string);
				$string=htmlspecialchars($string, ENT_QUOTES);
                
                $aux = explode(" HTTP", $string);
                $string=$aux[0];
                
				return $string;
			}
			return $string;
		}
		
		//Cripteaza un string
		public function crypt($text)
		{
			$salt="A3cr3tfo@rt3m45e#@d";
			return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
		}
		
		//Decripteaza un string
		public function decrypt($text)
		{
			$salt="A3cr3tfo@rt3m45e#@d";
			return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		}
	
		//Pune o valaore in sesiune
		public function put_in_session($key,$str)
		{
			$_SESSION[$key]=$this->crypt($str);
		}
		
		//Ia o valaore din sesiune
		public function get_from_sesion($key)
		{
			if(isset($_SESSION[$key]))
				return $this->decrypt($_SESSION[$key]);
			return NULL;
		}
		
		//Returneaza 1 daca utilizatorul are acces la institutie
		public function has_access($user_id, $institution_id)
		{
			$query=mysql_query("SELECT * FROM  `users` WHERE  `users_id` = '$user_id'");
			$k=mysql_fetch_array($query);
			
			
			if($k["users_rang"]=="1")
				return 1;
			
			$users_institutions_id=$k["users_institutions_id"];
			$users_institutions_id=explode("#",$users_institutions_id);
			for($i=0; $i<count($users_institutions_id); $i++)
				if( $users_institutions_id[$i] == $institution_id )
					return 1;
			return 0;
					
		}
	}
}
$obj_core=new core();
?>