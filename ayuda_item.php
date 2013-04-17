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
<h1><? echo $controlrow["gamename"]; ?> Ayuda: Items y Drops</h1>
[ <a href="ayuda.php">Volver a Ayuda</a> | <a href="index.php">Volver al Juego</a> ]

<br /><br /><hr />

<table width="60%" style="border: solid 1px black" cellspacing="0" cellpadding="0">
<tr><td colspan="5" bgcolor="#ffffff"><center><b>Items</b></center></td></tr>
<tr><td><b>Tipo</b></td><td><b>Nombre</b></td><td><b>Precio</b></td><td><b>Atributo</b></td><td><b>Especial</b></td></tr>
<?
$count = 1;
$itemsquery = doquery("SELECT * FROM {{table}} ORDER BY id", "items");
while ($itemsrow = mysql_fetch_array($itemsquery)) {
    if ($count == 1) { $color = "bgcolor=\"#ffffff\""; $count = 2; } else { $color = ""; $count = 1; }
    if ($itemsrow["type"] == 1) { $image = "weapon"; $power = "Ataque"; } elseif ($itemsrow["type"] == 2) { $image = "armor"; $power = "Defensa"; } else { $image = "shield"; $power = "Defensa"; }
    if ($itemsrow["special"] != "X") {
        $special = explode(",",$itemsrow["special"]);
        if ($special[0] == "maxhp") { $attr = "PV Máx"; }
        elseif ($special[0] == "maxmp") { $attr = "PM Máx"; }
        elseif ($special[0] == "maxtp") { $attr = "PR Máx"; }
        elseif ($special[0] == "goldbonus") { $attr = "Bonos de Oro (%)"; }
        elseif ($special[0] == "expbonus") { $attr = "Bonos de Exp (%)"; }
        elseif ($special[0] == "strength") { $attr = "Fuerza"; }
        elseif ($special[0] == "dexterity") { $attr = "Destreza"; }
        elseif ($special[0] == "attackpower") { $attr = "Poder de Ataque"; }
        elseif ($special[0] == "defensepower") { $attr = "Poder de Defensa"; }
        else { $attr = $special[0]; }
        if ($special[1] > 0) { $stat = "+" . $special[1]; } else { $stat = $special[1]; }
        $bigspecial = "$attr $stat";
    } else { $bigspecial = "<span class=\"light\">Nada</span>"; }
    echo "<tr><td $color width=\"5%\"><img src=\"images/icon_$image.gif\" alt=\"$image\"></td><td $color width=\"30%\">".$itemsrow["name"]."</td><td $color width=\"20%\">".$itemsrow["buycost"]." Gold</td><td $color width=\"20%\">Poder de $power: +".$itemsrow["attribute"]."</td><td $color width=\"25%\">$bigspecial</td></tr>\n";
}
?>
</table>
<br />
<br />
<table width="60%" style="border: solid 1px black" cellspacing="0" cellpadding="0">
<tr><td colspan="4" bgcolor="#ffffff"><center><b>Drops</b></center></td></tr>
<tr><td><b>Nombre</b></td><td><b>Nivel de Monstruo</b></td><td><b>Atributo 1</b></td><td><b>Atributo 2</b></td></tr>
<?
$count = 1;
$itemsquery = doquery("SELECT * FROM {{table}} ORDER BY id", "drops");
while ($itemsrow = mysql_fetch_array($itemsquery)) {
    if ($count == 1) { $color = "bgcolor=\"#ffffff\""; $count = 2; } else { $color = ""; $count = 1; }
    if ($itemsrow["attribute1"] != "X") {
        $special1 = explode(",",$itemsrow["attribute1"]);
        if ($special1[0] == "maxhp") { $attr1 = "PV Máx"; }
        elseif ($special1[0] == "maxmp") { $attr1 = "PM Máx"; }
        elseif ($special1[0] == "maxtp") { $attr1 = "PR Máx"; }
        elseif ($special1[0] == "goldbonus") { $attr1 = "Bonos de Oro (%)"; }
        elseif ($special1[0] == "expbonus") { $attr1 = "Bonos de Exp (%)"; }
        elseif ($special1[0] == "strength") { $attr1 = "Fuerza"; }
        elseif ($special1[0] == "dexterity") { $attr1 = "Destreza"; }
        elseif ($special1[0] == "attackpower") { $attr1 = "Poder de Ataque"; }
        elseif ($special1[0] == "defensepower") { $attr1 = "Poder de Defensa"; }
        else { $attr1 = $special1[0]; }
        if ($special1[1] > 0) { $stat1 = "+" . $special1[1]; } else { $stat1 = $special1[1]; }
        $bigspecial1 = "$attr1 $stat1";
    } else { $bigspecial1 = "<span class=\"light\">Nada</span>"; }
    if ($itemsrow["attribute2"] != "X") {
        $special2 = explode(",",$itemsrow["attribute2"]);
        if ($special2[0] == "maxhp") { $attr2 = "PV Máx"; }
        elseif ($special2[0] == "maxmp") { $attr2 = "PM Máx"; }
        elseif ($special2[0] == "maxtp") { $attr2 = "PR Máx"; }
        elseif ($special2[0] == "goldbonus") { $attr2 = "Bonos de Oro (%)"; }
        elseif ($special2[0] == "expbonus") { $attr2 = "Bonos de Exp (%)"; }
        elseif ($special2[0] == "strength") { $attr2 = "Fuerza"; }
        elseif ($special2[0] == "dexterity") { $attr2 = "Destreza"; }
        elseif ($special2[0] == "attackpower") { $attr2 = "Poder de Ataque"; }
        elseif ($special2[0] == "defensepower") { $attr2 = "Poder de Defensa"; }
        else { $attr2 = $special2[0]; }
        if ($special2[1] > 0) { $stat2 = "+" . $special2[1]; } else { $stat2 = $special2[1]; }
        $bigspecial2 = "$attr2 $stat2";
    } else { $bigspecial2 = "<span class=\"light\">Nada</span>"; }
    echo "<tr><td $color width=\"25%\">".$itemsrow["name"]."</td><td $color width=\"15%\">".$itemsrow["mnivel"]."</td><td $color width=\"30%\">$bigspecial1</td><td $color width=\"30%\">$bigspecial2</td></tr>\n";
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