<?php

	require_once("model.base.class.php");
	class image_model extends ModelBase
	{
		public function  __construct($instance)
		{
			$this->IsDbObj = true;
			$this->DataStruct = array("ImageName","Description","author","Date","img_url","GroupID");
			parent::__construct($instance);
		}
		
		
	}
?>