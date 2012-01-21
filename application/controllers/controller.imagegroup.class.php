<?php

	require_once("controller.base.class.php");
	class imagegroup extends ControllerBase
	{
		public function  __construct()
		{
			parent::__construct();
		}
		
		public function _index()//自定义你的action方法
		{
			$this->model->Get_By_author(4);
			$re =$this->model->getresult();
			foreach($re[4] as $r)
			{
				echo $r["GroupName"];
			}
		}
		public function _new()
		{
			$data = array($_POST['groupname'],$_POST['groupdescription'],$_POST['groupcatalog'],$_SESSION['USERID'],date("Y-m-d"),0,0);
			$this->model->New($data);
			$id=mysql_insert_id();
			$this->model->Get_By_author($_SESSION["USERID"]);
			$re =$this ->model->getresult();
			foreach($re[4] as $r)
			{
				if($r["GroupID"]==$id) $selected = "selected";
				$groupselect .="<option value='".$r["GroupID"]."' ".$selected.">".$r["GroupName"]."</option>";
			}
			echo $groupselect;
		}
	}
?>