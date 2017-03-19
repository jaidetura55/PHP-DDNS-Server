<?php

function loader($className){
	$ex = explode("\\", $className);
	
	require_once __DIR__."/src/".end($ex).".php";
}

spl_autoload_register("loader");