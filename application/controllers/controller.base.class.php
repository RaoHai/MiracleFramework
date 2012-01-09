<?php


	/*
	controllerµÄ»ùÀà
	*/
	class ControllerBase
	{
		protected $model;
		protected $view;
		protected $TemplateFolder;
		protected $TemplateFile;
		public function  __construct()
		{
			//$this->model = new ModelBase();
			$instance = get_class($this);
			$modelname = $instance."_model";
			require_once( APPLICATION_PATH."/models/model.{$instance}.class.php");
			$this->TemplateFolder= APPLICATION_PATH."/view/{$instance}/";
			$this->model	 = new $modelname($instance);
			//echo $TemplateFolder;
		}
		protected function RenderTemplate($action)
		{
			
		}
		
	
	}


?>