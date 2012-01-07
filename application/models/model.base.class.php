<?php
	/**
	 * model 的基类
	 *
	 * Copyright(c) 2011 by surgesoft. All rights reserved
	 *
	 * To contact the author write to {@link mailto:surgesoft@gmail.com}
	 *
	 * @author surgesoft
	 * @version $Id: model.base.class.php 2012-01-06 16:06
	 * @package model.base.class.php
	 */
	require_once( APPLICATION_PATH."/db.conn.php");
	

	class ModelBase
	{
		protected $dao;
		protected $IsDbObj;
		protected $DataStruct;
		private $instance;
		public $obj;
		
		//NFA
		private $Status;									//状态标记
		private $QueryType;							//查询类型
		private $QueryColum; 						//查询名称
		private $QueryTable;  						//查询表名
		private $QueryConstraint; 					//查询约束
		private $QueryConstraintOperators;  //约束运算符
		private $QueryConstraintValue;			//约束值
		private $StatusArr = array("Get"=>"select","Set"=>"update","New"=>"insert");
		public function  __construct($instance)
		{
			$this->dao=& new database();
			$this->instance = $instance;
			//	var_dump($this->DataStruct);
		}
		public function getresult()
		{
			return $this->obj;
		}
		
		/**
		*
		*
		*
		**/
		public function __call($FuncName,$arg)
		{
				if($this->IsDbObj)
				{
					
					$instruct =  explode('_',$FuncName);
					echo $FuncName;
					//这部分应该是在模拟一个确定性有穷自动机进行SQL的自动生成
					//但是不知道实现是否标准。。。
					//反正就是这个意思。。
				$this->Status=0;
				$this->QueryType="";
				foreach ($instruct as $value)
				{
					echo $value;
					if(!$this->state_next($value) )
					{
						echo "语法错误";
						break;
					}
						else echo "成功接收|";

				}
					//var_dump($instruct);
				if($this->Status==99)//接收成功
				{
					echo "全部接收成功>>>";
					switch($this->QueryType){
						case "select":
							$sql = $this->QueryType." ".$this->QueryColum." from `" .$this->instance ."` where `".$this->QueryConstraint."` =".$arg[0];
							break;
						case "update":
							$sql = $this->QueryType." `".$this->instance."` set ".$this->QueryColum." = '".$arg[1]."' where `".$this->QueryConstraint."` =".$arg[0];
							break;
						case "insert":
							$list = implode(",",$this->DataStruct);
							$argvalue="'".implode("','",$arg[0])."'";
							$sql = "insert into `".$this->instance."`(".$list.") VALUES(".$argvalue.")";
							break;
						}
					$this->dao->fetch($sql);
					while($list = $this->dao->getRow () )
					{
						echo $list["UserName"];
					}
					
				}
				}
				else
				{
					echo __CLASS__.":访问错误的函数";
				}
				
		}
		
		/**
		*
		*
		*
		**/
		private function state_next($letter)
		{
			if(empty($this->QueryType) ) //初始状态
			{
				if(isset($this->StatusArr[$letter]))
				{
					$this->QueryType= $this->StatusArr[$letter];
					$this->Status = 1;
					if($this->QueryType == "insert") 	$this->Status = 99;
					return true;
				}
				else return false;
			}
			else
			{
				switch($this->QueryType)
				{
					case "select":
					case "update":
						switch($this->Status)
						{
							case 1:
								if($letter=="ALL") $this->QueryColum ="*";
								else $this->QueryColum ="`".$letter."`";
								$this->Status=2;
								if($letter=="By") 
								{
									$this->QueryColum ="*";
									$this->Status=3;
								}
								return true;
								break;
							case 2:
								if($letter=="By") $this->Status=3;
								else return false;
								return true;
								break;
							case 3:
								$this->QueryConstraint = $letter;
								$this->Status=99;
								return true;
								break;
								
						}
						break;
						
						
				}
			}
		}
		
	}

?>