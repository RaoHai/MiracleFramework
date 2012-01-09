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
			echo "调用image_index动作成功:参数";
			$data = array(1,2,3,4,5,6);
			$this->model->New($data);
		
		}	
		public function _show()
		{
			echo "调用show动作成功:参数";
			
			
		}
	}
?>