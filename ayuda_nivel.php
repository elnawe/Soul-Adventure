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
<h1><? echo $controlrow["gamename"]; ?> Ayuda: Niveles</h1>
[ <a href="ayuda.php">Volver a Ayuda</a> | <a href="index.php">Volver al Juego</a> ]

<br /><br /><hr />

<table width="50%" style="border: solid 1px black" cellspacing="0" cellpadding="0">
<tr><td colspan="8" bgcolor="#ffffff"><center><b>Niveles para <? echo $controlrow["class1name"]; ?></b></center></td></tr>
<tr><td><b>Nivel</b><td><b>Exp.</b></td><td><b>PV</b></td><td><b>PM</b></td><td><b>PR</b></td><td><b>Fuerza</b></td><td><b>Destreza</b></td><td><b>Habilidad</b></td></tr>
<?
$count = 1;
$itemsquery = doquery("SELECT id,1_exp,1_hp,1_mp,1_tp,1_strength,1_dexterity,1_spells FROM {{table}} ORDER BY id", "niveles");
$spellsquery = doquery("SELECT * FROM {{table}} ORDER BY id", "habilidades");
$spells = array();
while ($spellsrow = mysql_fetch_array($spellsquery)) {
    $spells[$spellsrow["id"]] = $spellsrow;
}
while ($itemsrow = mysql_fetch_array($itemsquery)) {
    if ($count == 1) { $color = "bgcolor=\"#ffffff\""; $count = 2; } else { $color = ""; $count = 1; }
    if ($itemsrow["1_spells"] != 0) { $spell = $spells[$itemsrow["1_spells"]]["name"]; } else { $spell = "<span class=\"light\">Nada</span>"; }
    if ($itemsrow["id"] != 100) { echo "<tr><td $color width=\"12%\">".$itemsrow["id"]."</td><td $color width=\"12%\">".number_format($itemsrow["1_exp"])."</td><td $color width=\"12%\">".$itemsrow["1_hp"]."</td><td $color width=\"12%\">".$itemsrow["1_mp"]."</td><td $color width=\"12%\">".$itemsrow["1_tp"]."</td><td $color width=\"12%\">".$itemsrow["1_strength"]."</td><td $color width=\"12%\">".$itemsrow["1_dexterity"]."</td><td $color width=\"12%\">$spell</td></tr>\n"; }
}
?>
</table>
<br /><br />
<table width="50%" style="border: solid 1px black" cellspacing="0" cellpadding="0">
<tr><td colspan="8" bgcolor="#ffffff"><center><b>Niveles para <? echo $controlrow["class2name"]; ?> </b></center></td></tr>
<tr><td><b>Nivel</b><td><b>Exp.</b></td><td><b>PV</b></td><td><b>PM</b></td><td><b>PR</b></td><td><b>Fuerza</b></td><td><b>Destreza</b></td><td><b>Habilidad</b></td></tr>
<?
$count = 1;
$itemsquery = doquery("SELECT id,2_exp,2_hp,2_mp,2_tp,2_strength,2_dexterity,2_spells FROM {{table}} ORDER BY id", "niveles");
$spellsquery = doquery("SELECT * FROM {{table}} ORDER BY id", "habilidades");
$spells = array();
while ($spellsrow = mysql_fetch_array($spellsquery)) {
    $spells[$spellsrow["id"]] = $spellsrow;
}
while ($itemsrow = mysql_fetch_array($itemsquery)) {
    if ($count == 1) { $color = "bgcolor=\"#ffffff\""; $count = 2; } else { $color = ""; $count = 1; }
    if ($itemsrow["2_spells"] != 0) { $spell = $spells[$itemsrow["2_spells"]]["name"]; } else { $spell = "<span class=\"light\">Nada</span>"; }
    if ($itemsrow["id"] != 100) { echo "<tr><td $color width=\"12%\">".$itemsrow["id"]."</td><td $color width=\"12%\">".number_format($itemsrow["2_exp"])."</td><td $color width=\"12%\">".$itemsrow["2_hp"]."</td><td $color width=\"12%\">".$itemsrow["2_mp"]."</td><td $color width=\"12%\">".$itemsrow["2_tp"]."</td><td $color width=\"12%\">".$itemsrow["2_strength"]."</td><td $color width=\"12%\">".$itemsrow["2_dexterity"]."</td><td $color width=\"12%\">$spell</td></tr>\n"; }
}
?>
</table>
<br /><br />
<table width="50%" style="border: solid 1px black" cellspacing="0" cellpadding="0">
<tr><td colspan="8" bgcolor="#ffffff"><center><b>Niveles para <? echo $controlrow["class3name"]; ?></b></center></td></tr>
<tr><td><b>Nivel</b><td><b>Exp.</b></td><td><b>PV</b></td><td><b>PM</b></td><td><b>PR</b></td><td><b>Fuerza</b></td><td><b>Destreza</b></td><td><b>Habilidad</b></td></tr>
<?
$count = 1;
$itemsquery = doquery("SELECT id,3_exp,3_hp,3_mp,3_tp,3_strength,3_dexterity,3_spells FROM {{table}} ORDER BY id", "niveles");
$spellsquery = doquery("SELECT * FROM {{table}} ORDER BY id", "habilidades");
$spells = array();
while ($spellsrow = mysql_fetch_array($spellsquery)) {
    $spells[$spellsrow["id"]] = $spellsrow;
}
while ($itemsrow = mysql_fetch_array($itemsquery)) {
    if ($count == 1) { $color = "bgcolor=\"#ffffff\""; $count = 2; } else { $color = ""; $count = 1; }
    if ($itemsrow["3_spells"] != 0) { $spell = $spells[$itemsrow["3_spells"]]["name"]; } else { $spell = "<span class=\"light\">Nada</span>"; }
    if ($itemsrow["id"] != 100) { echo "<tr><td $color width=\"12%\">".$itemsrow["id"]."</td><td $color width=\"12%\">".number_format($itemsrow["3_exp"])."</td><td $color width=\"12%\">".$itemsrow["3_hp"]."</td><td $color width=\"12%\">".$itemsrow["3_mp"]."</td><td $color width=\"12%\">".$itemsrow["3_tp"]."</td><td $color width=\"12%\">".$itemsrow["3_strength"]."</td><td $color width=\"12%\">".$itemsrow["3_dexterity"]."</td><td $color width=\"12%\">$spell</td></tr>\n"; }
}
?>
</table>
<br />
Los puntos de experiencia enlistados son el total de la experiencia que se necesita para pasar de nivel.
<br /><br />
<table class="copyright" width="100%"><tr>
<td width="50%" align="center">Hecho por: Nahuel Sacchetti &copy; 2009</td>
<td width="50%" align="center">Powered by <a href="http://soul-project.com.ar">SouL Project</td>
</tr></table>
</body>
</html>