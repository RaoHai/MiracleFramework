<?php

	require_once("controller.base.class.php");
	class /*name*/ extends ControllerBase
	{
		public function  __construct()
		{
			parent::__construct();
		}
		
		public function _index()//自定义你的action方法
		{
			$this->values = array("title"=>"hello",
												"tests"=>"1");
			$this->RenderTemplate("index");
			
		}
	}
?>