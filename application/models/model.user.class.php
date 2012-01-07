<?php

	require_once("model.base.class.php");
	class user_model extends ModelBase
	{
		public function  __construct($instance)
		{
			$this->IsDbObj = true;
			$this->DataStruct = array("UserName","NickName","email","password","salt");
			parent::__construct($instance);
		}
		
		
	}
?>