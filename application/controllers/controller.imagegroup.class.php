<?php

	require_once("controller.base.class.php");
	class imagegroup extends ControllerBase
	{
		public function  __construct()
		{
			require_once(APPLICATION_PATH."/controllers/controller.image.class.php");
			require_once(APPLICATION_PATH."/controllers/controller.user.class.php");
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
			foreach($re[$_SESSION["USERID"]] as $r)
			{
				if($r["GroupID"]==$id) $selected = "selected"; else $selected="";
				$groupselect .="<option value='".$r["GroupID"]."' ".$selected.">".$r["GroupName"]."</option>";
			}
			echo $groupselect;
		}
		public function _show()
		{
				header('Pragma: no-cache');
				header('Cache-Control: private, no-cache');
				header('Content-Disposition: inline; filename="files.json"');
				header('X-Content-Type-Options: nosniff');
				header('Access-Control-Allow-Origin: *');
				header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
				header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
				header('Content-type: application/json');
				$id = $_GET['id'];
				$this->model->Get_By_GroupId($id);
				$re =$this ->model->getresult();
				$group = new stdClass();
				foreach($re[$id] as $r )
				{
					$group->id=$r['GroupID'];
					$group->name=$r['GroupName'];
					$group->desc=$r['Description'];
					$group->cata=$r['GroupCatalog'];
				}
				echo json_encode($group);
		}
		public function _edit()
		{
				$id = $_POST['groupid'];
				$this->model->Set_GroupName_By_GroupId($id,$_POST['groupname']);
				$this->model->Set_Description_By_GroupId($id,$_POST['groupdescription']);
				$this->model->Set_GroupCatalog_By_GroupId($id,$_POST['groupcatalog']);
				$this->model->Get_By_author($_SESSION["USERID"]);
				$re =$this ->model->getresult();
				foreach($re[$_SESSION["USERID"]] as $r)
				{
					if($r["GroupID"]==$id) $selected = "selected"; else $selected="";
					$groupselect .="<option value='".$r["GroupID"]."' ".$selected.">".$r["GroupName"]."</option>";
				}
				echo $groupselect;
		}
		public function _view($param)
		{
				//echo $param;
				if($param)
				{
					$this->model->Get_GroupName_Description_author_By_GroupID($param);
					$re =$this ->model->getresult();
					//var_dump($re)
					foreach($re[$param] as $r)
					{
						$groupname = $r["GroupName"];
						$groupdesc = $r["Description"];
						$groupauthor = $r["author"];
					}
					$author = new user();
					$author->model->Get_NickName_By_UserID($groupauthor);
					$ren = $author->model->getresult();
					
					foreach($ren[$groupauthor] as $rn)
						$authorname= $rn['NickName'];
					$img = new image();
					$id = $param;
					$img->model->Get_imgurl_Description_By_GroupID($id);
					$re2 =$img ->model->getresult();
					foreach($re2[$id] as $r2)
					{
						//echo $r2['imgurl'];
						$url = rawurlencode($r2['imgurl']);
						$desc = $r2['Description'];
						$images.="<a href='/files/".$url."' target='_blank' ><img src='/medium/".$url."' title='".$desc."'></img></a>\n";
					}
				
					
					$this->values = array("user"=>$_SESSION["USER"],
													"title"=>"画集-".$groupname,
													"nickname"=>$_SESSION['NICK'],
													"images"=>$images,
													"groupname"=>$groupname,
													"groupdesc"=>$groupdesc,
													"authorname"=>$authorname,
													"authorid"=>$groupauthor,
													);
				$this->RenderTemplate("view");
			}
			else
			{
				Header("Location:/404.html");
			}
		}
		public function _all($userid)
		{
			if(empty($userid)) $userid=$_SESSION["USERID"];
			$this->model->Get_GroupID_GroupName_Description_author_By_author( $userid);
			$re1 = $this->model->getresult();
			$img = new image();
			$author = new user();
			$author->model->Get_NickName_By_UserID($userid);
			$ren = $author->model->getresult();

			foreach($ren[$userid] as $rn)
			$authorname= $rn['NickName'];
			foreach($re1[$userid] as $r)
			{
				$id = $r["GroupID"];
				$img->model->Get_imgurl_By_GroupID($id);
				$re2 =$img->model->getresult();
				$src = rawurlencode($re2[$id][0]['imgurl']);
				if($src)
					$images.="<div style='width:360px;float:left;height:100px;overflow:hidden;margin-left:10px;'>"
					."<h3 style='display: inline;float:left;position: absolute;color:#09f;margin-top:11px;margin-left:1px;'>".$r["GroupName"]."</h3>"
					."<h3 style='display: inline;float:left;position: absolute;color:white;margin-top:10px;'>".$r["GroupName"]."</h3>"
					."<a href ='/imagegroup/".$id."' title='".$r['Description']."'>"
					."<img style='display: inline; width: 360px; left: 0px; top: 0px;margin-top:10px; ' src='/medium/".$src."' /></a></div>";
			
			}
				
				
			$this->values = array("user"=>$_SESSION["USER"],
													"title"=>"画集-".$authorname,
													"nickname"=>$_SESSION['NICK'],
													"images"=>$images,
													"groupname"=>$authorname."的画集",
													"authorname"=>$authorname,
													"authorid"=>$userid,
													);
			$this->RenderTemplate("all");
		}
	}
?>