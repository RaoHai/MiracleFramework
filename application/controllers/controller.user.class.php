<?php

	require_once("controller.base.class.php");
	class user extends ControllerBase
	{
		public function  __construct()
		{
			parent::__construct();
		}
		
		public function _index()
		{
			//$data = array("newuser","myname","11@11.com",4,5);
			//$this->model->New($data);
				//var_dump($arr[4]);
				/*foreach ($arr[4] as $value)
				{
					echo "|".$value["UserName"]."|";
				}*/
				$this->values = array("title"=>"hello");
				$this->RenderTemplate("index");
		}	
		public function _show()
		{
			echo "调用show动作成功:参数";
			
			
		}
		
	}
?>