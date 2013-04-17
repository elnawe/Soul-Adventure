<?php  
#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribución de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para más información: www.soul-adventure.net							#
# *                                                          				#
#############################################################################
require_once('lib.php'); 
include('cookies.php'); 
$link = opendb(); 
$userrow = checkcookies();
if ($userrow == false) { display("El mapa es solo para usuarios registrados.", "Mapa"); die(); }
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);

// Juego Cerrado.
if ($controlrow["gameopen"] == 0) { display("El juego ha sido cerrado momentaneamente, vuelva más tarde.","Juego Cerrado"); die(); }
// Forzar a verificar.
if ($controlrow["verifyemail"] == 1 && $userrow["verify"] != 1) { header("Location: usuarios.php?do=verificar"); die(); }
// Bloquear usuario.
if ($userrow["autorizacion"] == 2) { die("Tu cuenta ha sido bloqueada."); }


?>
<html>
<head>
<title>Mapa de exploración</title>
<meta http-equiv="refresh" content="10";URL="mapa.php">
<?

$usersquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
while ($usersrow = mysql_fetch_array($usersquery)) {
$brx = $controlrow["gamesize"] - 3 + $usersrow["longitude"];    
$bry = $controlrow["gamesize"] - 3 - $usersrow["latitude"];    

echo "
<style>
.d{
position: absolute;
border: 0px;
left: ".$brx."px;
top: ".$bry."px;
}
</style>
</head>
<body background=\"estilo/imagenes/default/mapa.gif\">
<img id='d' class='d' src='estilo/imagenes/default/dot.gif' title='".$usersrow["charname"]."' alt='".$usersrow["charname"]."'>";
}
?>
</body>
</html>
