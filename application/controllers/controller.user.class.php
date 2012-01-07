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
			echo "调用index动作成功:参数";
			$data = array("newuser","myname","11@11.com",4,5);
			$this->model->New($data);
		
		}	
		public function _show()
		{
			echo "调用show动作成功:参数";
			
			
		}
	}
?>