<?php
		/*访问控制列表 (ACL,access control list)类
		*
		*
		*
		*/
		class Acl
		{
			protected $Rolelist = array();
			protected $parents = array();
			protected $allow = array();
			protected $serializeFile;
			public function __construct()
			{
				$this->serializeFile =  APPLICATION_PATH."/lib/aclserialize.ser";
			}
			public function serializeit()
			{
				
				$s= serialize($this);
				$f = fopen($this->serializeFile, 'w');
				fwrite($f,$s);
				fclose($f);
			}
			public function addRole($rolename,$parent)
			{
				$this->Rolelist[$rolename] = 1;
				$this->parents[$rolename] =array();
				if(is_array($parent))
				{
					foreach($parent as $pa)
						$this->parents[$rolename][]=$pa;
				}
				else $this->parents[$rolename][]=$parent;
				//var_dump($this->parents[$rolename]);
			}
			public function allow($rolename,$controller,$action=0)
			{
				
				if(!isset($this->allow[$rolename])) $this->allow[$rolename]=array();
				if(is_array($controller))
				{
					foreach($controller as $ctrl)
					{
						if(empty($action))
						{
							$this->allow[$rolename][$ctrl]=1;
						}
						else
						{
							if(is_array($action))
							{
								foreach($action as $a)
								{	
									$this->allow[$rolename][$ctrl][$a]=1;
								}
							}
							else
							{
								$this->allow[$rolename][$ctrl][$action]=1;
							}
						}
					}
				}
				else
				{
					if(empty($action))
					{
						$this->allow[$rolename][$controller]=1;
						echo "设置：".$rolename.">>".$controller;
					}
					else
					{
						if(is_array($action))
						{
							foreach($action as $a)
							{	
								$this->allow[$rolename][$controller][$a]=1;
							}
						}
						else
						{
							$this->allow[$rolename][$controller][$action]=1;
						}
					}
				}
			}
			public function isallowed($rolename,$controller,$action=0)
			{
				if(empty($rolename)) return false;
				//echo "校验：".$rolename.">>".$controller;
				if(isset($this->allow[$rolename][$controller]))
				{
					//echo "校验：".$rolename.">>".$controller;
					if($this->allow[$rolename][$controller]==1) return true;
					if(isset($this->allow[$rolename][$controller][$action])) return true;
				}
				else 
				{
					//var_dump($this->parents[$rolename]);
					//$check=0;
					foreach($this->parents[$rolename] as $parentrole)
					{
						if($this->isallowed($parentrole,$controller,$action))return true;
					}
					return false;
				}
				return false;
			}
			
		}
	

?>