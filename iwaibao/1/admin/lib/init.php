<?php
header("Content-type: text/html; charset=utf-8");
require_once('config.php');
require_once('Db.class.php');
require_once('Model.class.php');
require_once('function.php');
require_once(dirname(__FILE__)."/../mod/Game.class.php");

$m = $_GET['m'];
$a = $_GET['a'];
$tmpfile = 'main.php';
if($m == 'mod') {
  $mod = new Game;
  $mod->tmpfile = "tmp/{$m}_{$a}.php";
  if (!method_exists($mod, $a)) {
    die('请求入口不存在');
  }

  $mod->$a();
  exit();
}