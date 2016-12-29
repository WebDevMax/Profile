<?php
$routes = array(
	array('pattern'=>'code/:id','controller'=>'articles','action'=>'code'),
	);

foreach($routes as $route)
{
	$router->addRoute(new Framework\Router\Route\Simple($route));
}
unset($routes);