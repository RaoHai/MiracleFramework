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
			echo "正则匹配：";
			$regex =array('/^\/?(home)(\/?\d*\/?)?$/',
									'/^\/?(home)(\/\w+)(\/?\d*\/?)?$/');
			//^user/\d+
			$replace = array("/user/index$2",
										"/user$2$3");
			$string = "/home/123/";
			echo preg_replace($regex,$replace,$string);
			if(preg_match($regex,$string,$matches))
			{
				echo "通过";
				echo preg_replace($regex,$replace,$string);
				echo "<pre>";
				var_dump($matches);
				echo "</pre>";
			}
			else echo "未通过";
			
		
		
		}	
		public function _show()
		{
			echo "调用show动作成功:参数";
			
			
		}
		public function _getdesc()
		{
			$url = urlencode(trim(basename(stripslashes($_GET['url'])), ".\x00..\x20"));
			$this->model->Get_Description_By_imgurl($url);
			$re = $this->model->getresult();
			foreach($re[$url] as $r)
			{
				echo $r['Description'];
			}
		}
		public function _edit()
		{
			$desc = $_GET['desc'];
			$url = urlencode(trim(basename(stripslashes($_GET['url'])), ".\x00..\x20"));
			$this->model->Set_Description_By_imgurl($url,$desc);
		}
	}
?>