<?php

/* ---------------------------
路由类
-----------------------------//  */
defined("WEB_AUTH") || die("NO_AUTH");
include_once 'route.ini.php';

class Route
{
	private $_moudle;
	private $_controller;
	private $_action;
	private $_uri;
	private $_param;
	//mvc资源
	private $moudle_arr;
	//路由资源
	private $route_arr;
	 
	private $_default = array('module' => 'default',
											 'conttoller' => 'index',
												   'action' => 'index');
												   
	 public function __construct($uri = NULL)
	{
		global $moduleArr,$routeArr;
		$this->moudle_arr  = $moduleArr;
		$this->route_arr   = $routeArr;
        $uri == NULL && $uri = $_SERVER['REDIRECT_URL'];
		$this->_uri   = $uri;
		$this->init();


	}

	private function parseUri($uri = NULL)
       {
			global $routeArr;
			$uri == NULL && $uri = $this->_uri;
			 if (isset( $routeArr[$uri]))
			 {
					  $this->uriArr = array($routeArr[$uri]["module"],$routeArr[$uri]["controller"],$routeArr[$uri]["action"]);
					 
			 }
			 else
			 {
				$this->uriArr = explode('/',substr($uri,1));
				$this->uriArr && $this->uriArr = array_filter($this->uriArr);
			}
			//var_dump($this->uriArr);

      }
	  
		private function init()
       {
           $this->parseUri();   
		   $this->parseRoute();
		   $this->dispatcher();
			
		}
		private function parseRoute()
		{
			$this->_module= (isset( $this->uriArr[0]) ? $this->uriArr[0] : 'index');
			$this->_controller=(isset( $this->uriArr[0]) ? $this->uriArr[0] : 'index');
			$this->_action =(isset( $this->uriArr[1]) ? $this->uriArr[1] : 'index');
			$this-> _param= (isset( $this->uriArr[2]) ? $this->uriArr[2] : '');
			//echo $this->_module."|".$this->_controller."|".$this->_action.":".$this-> _param;
		}
		
		private function dispatcher()
		{
			global $Permissions;
		   $controllerfile = APPLICATION_PATH."/controllers/controller.{$this->_controller}.class.php";
		   $controllerName =$this->_controller;
		   $func = "_".$this->_action;
		   $param = $this->_param;
		  // echo $Permissions[$controllerName];
			if (file_exists($controllerfile) && $_SESSION["permission"]==$Permissions[ $controllerName])
			{
				require_once($controllerfile);
				$Instance = new $controllerName();
				$Instance-> $func ($param);
				
			}
			else
			{
				//echo "权限不足";
				Header("Location: /");
			}

		}
		
		public function GetModule()
		{
			if(empty($this->_module)) $this->_module="index";
			return $this->_module;
		}
		public function GetController()
		{
			if(empty($this->_controller)) $this->_controller="index";
			return $this->_controller;
		}
		public function GetAction()
		{
			if(empty($this->_action)) $this->_action="index";
			return $this->_action;
		}


}

?>