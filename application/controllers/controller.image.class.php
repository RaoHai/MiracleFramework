<?php

	require_once("controller.base.class.php");
	class image extends ControllerBase
	{
		public function  __construct()
		{
			parent::__construct();
		}
		
		public function _index()
		{
		
			//$this->model->Del_By_ImageId(4);
		
		}	
		public function _show()
		{
			echo "调用show动作成功:参数";
			
			
		}
	}
?>