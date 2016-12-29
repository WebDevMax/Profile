<?php
define('DEBUG',TRUE);
define("APP_PATH",getcwd());

try
{
	spl_autoload_register(function($class){
		$path = lcfirst(str_replace("\\",DIRECTORY_SEPARATOR,$class));
		$file = APP_PATH."/application/libraries/{$path}.php";
		if(file_exists($file))
		{
			require_once($file);
			return true;
		}
	});
	
	//CORE
	require_once('/framework/core.php');
	Framework\Core::initialize();
	//PLUGINS
	$path = APP_PATH.'/application/plugins';
	$iterator = new DirectoryIterator($path);
	foreach($iterator as $item)
	{
		if(!$item->isDot() && $item->isDir())
		{
			include_once($path.'/'.$item->getFilename().'/initialize.php');
		}
	}
	//CONFIGURATION
	$configuration = new Framework\Configuration(array("type"=>"ini"));
	Framework\Registry::set("configuration",$configuration->initialize());

	$database = new Framework\Database();
	Framework\Registry::set("database",$database->initialize()); 

	$cache = new Framework\Cache();
	Framework\Registry::set("cache",$cache->initialize());

	$session = new Framework\Session();
	Framework\Registry::set("session",$session->initialize());

	$router = new Framework\Router(array("url"=>isset($_GET["url"])? $_GET["url"]:"home/index","extension"=>isset($_GET["url"])?$_GET["url"]:"html"));
	Framework\Registry::set("router",$router);
	require_once("public/routes.php");
	$router->dispatch();

	unset($configuration);
	unset($database);
	unset($cache);
	unset($session);
	unset($router);
}
catch(Exception $e)
{
	$exceptions = array("500"=>array("Framework\Cache\Exception","Framework\Cache\Exception\Argument","Framework\Cache\Exception\Implementation",'Framework\Cache\Exception\Service','Framework\Configuration\Exception','Framework\Configuration\Exception\Argument','Framework\Configuration\Exception\Implementation','Framework\Configuration\Exception\Syntax','Framework\Controller\Exception','Framework\Controller\Exception\Argument','Framework\Controller\Exception\Implementation','Framework\Core\Exception','Framework\Core\Exception\Argument','Framework\Core\Exception\Implementation','Framework\Core\Exception\Property','Framework\Core\Exception\ReadOnly','Framework\Core\Exception\WriteOnly','Framework\Database\Exception','Framework\Database\Exception\Argument','Framework\Database\Exception\Implementation','Framework\Database\Exception\Service','Framework\Database\Exception\Sql','Framework\Model\Exception','Framework\Model\Exception\Argument','Framework\Model\Exception\Connector','Framework\Model\Exception\Implementation','Framework\Model\Exception\Primary','Framework\Model\Exception\Type','Framework\Model\Exception\Validation','Framework\Request\Exception','Framework\Request\Exception\Argument','Framework\Request\Exception\Implementation','Framework\Request\Exception\Response','Framework\Router\Exception','Framework\Router\Exception\Argument','Framework\Router\Exception\Implementation','Framework\Session\Exception','Framework\Session\Exception\Argument','Framework\Session\Exception\Implementation','Framework\Template\Exception','Framework\Template\Exception\Argument','Framework\Template\Exception\Implementation','Framework\Template\Exception\Parser','Framework\View\Exception','Framework\View\Exception\Argument','Framework\View\Exception\Data','Framework\View\Exception\Implementation','Framework\View\Exception\Renderer','Framework\View\Exception\Syntax'),"404"=>array('Framework\Router\Exception\Action','Framework\Router\Exception\Controller'));
	$exception = get_class($e);
	//print_r($e);
	foreach($exceptions as $template=>$classes)
	{
		foreach($classes as $class)
		{
			if($class==$exception)
			{
				header("Content-type:text/html");
				require_once(APP_PATH."/application/views/errors/".$template.".php");
				exit();
			}
		}
	}
	header("Content-type:text/html");
	echo "Error occured, oh noooo!!!(voice fades distantly)";
	exit();
}