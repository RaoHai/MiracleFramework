<?php

	require_once("controller.base.class.php");
	class index extends ControllerBase
	{
		public function  __construct()
		{
			parent::__construct();
		}
		
		public function _index()
		{
			$this->values = array("title"=>"hello");
			$this->RenderTemplate("index");
			
		}
	}
?>