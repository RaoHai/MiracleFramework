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
			echo "调用index动作成功:参数";
			$this->model->New(5);
			
		}
	}
?>