<?php
session_start();
define('BASE_PATH', realpath(__DIR__ . '/../'));
require_once BASE_PATH . "/routes/web.php";

$page = $_GET['page'] ?? 'login';
route($page); 
?>