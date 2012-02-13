<?php

	require_once("controller.base.class.php");
	class index extends ControllerBase
	{
		public function  __construct()
		{
			require_once(APPLICATION_PATH."/controllers/controller.image.class.php");
			parent::__construct();
		}
		
		public function _index()
		{
			$img = new image();
			
			$this->values = array("user"=>$_SESSION["USER"],
												"title"=>"主页-ACGPIC",
												"nickname"=>$_SESSION['NICK'],
												"tests"=>"1");
												
			$this->RenderTemplate("index");
			//赋值耗时0.0022368431091309
			//序列化耗时0.00037193298339844
			//$start = getmicrotime();
			/*$acl = new Acl();
			$acl->addRole("admin");
			$acl->addRole("user","admin");
			$acl->allow("admin","index","abc");
			$acl->allow("user",array("1","2","3"));
			//if($acl->isallowed("admin","index","abc")) echo "权限确认";
			//if($acl->isallowed("user","index")) echo "权限确认";
			//$acl->serializeit();*/
			//$acl= loadser();
			//$end = getmicrotime();
			//echo $end-$start;
			//if($acl->isallowed("admin","index","abc")) echo "权限确认";
			//if($acl->isallowed("user","index")) echo "权限确认";
			//$s= serialize($acl);
			//$acl2 = unserialize($s);
		}
	}
?>