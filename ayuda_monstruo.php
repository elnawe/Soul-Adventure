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
include('lib.php'); 
$link = opendb();
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);
ob_start("ob_gzhandler");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Ayuda para <? echo $controlrow["gamename"]; ?></title>
<LINK rel="stylesheet" type="text/css" href="estilo/css/ayuda.css">
</head>
<body>
<a name="top"></a>
<h1><? echo $controlrow["gamename"]; ?> - Ayuda: Monstruos</h1>
[ <a href="ayuda.php">Volver a Ayuda</a> | <a href="index.php">Volver al Juego</a> ]

<br /><br /><hr />

<table width="75%" style="border: solid 1px black" cellspacing="0" cellpadding="0">
<tr><td colspan="8" bgcolor="#ffffff"><center><b>Monstruos</b></center></td></tr>
<tr><td><b>Nombre</b></td><td><b>PV Máx</b></td><td><b>Daño Máx</b></td><td><b>Armadura</b></td><td><b>Nivel</b></td><td><b>Exp. Máx</b></td><td><b>Oro Máx</b></td><td><b>Inmunidad</b></td></tr>
<?
$count = 1;
$itemsquery = doquery("SELECT * FROM {{table}} ORDER BY id", "monstruos");
while ($itemsrow = mysql_fetch_array($itemsquery)) {
    if ($count == 1) { $color = "bgcolor=\"#ffffff\""; $count = 2; } else { $color = ""; $count = 1; }
    if ($itemsrow["immune"] == 0) { $immune = "<span class=\"light\">Nada</span>"; } elseif ($itemsrow["immune"] == 1) { $immune = "Daño"; } else { $immune = "Daño y Sueño"; }
    echo "<tr><td $color width=\"30%\">".$itemsrow["name"]."</td><td $color width=\"10%\">".$itemsrow["maxhp"]."</td><td $color width=\"10%\">".$itemsrow["maxdam"]."</td><td $color width=\"10%\">".$itemsrow["armor"]."</td><td $color width=\"10%\">".$itemsrow["nivel"]."</td><td $color width=\"10%\">".$itemsrow["maxexp"]."</td><td $color width=\"10%\">".$itemsrow["maxgold"]."</td><td $color width=\"20%\">$immune</td></tr>\n";
}
?>
</table>
<br />
<table class="copyright" width="100%"><tr>
<td width="50%" align="center">Hecho por: Nahuel Sacchetti &copy; 2009</td>
<td width="50%" align="center">Powered by <a href="http://soul-project.com.ar">SouL Project</td>
</tr></table>
</body>
</html>