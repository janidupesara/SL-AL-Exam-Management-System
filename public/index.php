<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';
$routes = [
 'auth/login'=>['AuthController','login'],
 'auth/register'=>['AuthController','register'],
 'auth/logout'=>['AuthController','logout'],
 'dashboard/index'=>['DashboardController','index'],
 'study/mark'=>['StudyController','mark'],
 'archive/index'=>['ArchiveController','index'],
 'profile/index'=>['ProfileController','index']
];
$url=trim($_GET['url'] ?? (empty($_SESSION['user_id'])?'auth/login':'dashboard/index'),'/');
if (!isset($routes[$url])) { http_response_code(404); exit('Page not found.'); }
[$class,$method]=$routes[$url];
require_once __DIR__ . '/../app/controllers/' . $class . '.php';
$controller=new $class();
$controller->$method();

