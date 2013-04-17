<?php

include('../lib.php');
include('../cookies.php');
$link = opendb();
$userrow = checkcookies();
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);
$control = $controlquery.$controlrow ;
if ($userrow == false) { die("Debes entrar al <a href=\"../entrar.php?do=entrar\">juego</a> antes de usar el panel de administración."); }
if ($userrow["autorizacion"] != 1) { die("Tienes que tener privilegios para entrar al panel de administración."); }
$control;

?>