<?php

	class database
	{
		var $db;
		var $quary;
		 public function  __construct()
		{
			$this->db=mysql_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD);
			mysql_select_db(DB_NAME, $this->db);
			mysql_query("SET NAMES 'UTF8'"); 
			//echo "db_connected";
		}
		public function fetch($sql)
		{
			//echo $sql;
			$fp=fopen("log.txt","a");
			fwrite($fp,"SQL:". $sql."\r\n"); 
			fclose($fp);
			$this->query=mysql_unbuffered_query($sql,$this->db);
		}
		public function fetch2($sql)
		{
			$this->query=mysql_query($sql,$this->db);
		}
		public function getRow () 
		 {
			if ( $row=mysql_fetch_array($this->query,MYSQL_ASSOC) )
			{	
				return $row;
			}
			else
			{
				return false;
			}
		}
}
?>