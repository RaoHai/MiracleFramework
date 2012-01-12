<?php
	function getmicrotime(){ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
    } 
	function loadser()
	{
			$fp = fopen (APPLICATION_PATH."/lib/aclserialize.ser","r");
			$content = fread ($fp,filesize (APPLICATION_PATH."/lib/aclserialize.ser"));
			fclose($fp);
			$obj = unserialize($content);
			return $obj;
	}
?>