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

 $query = doquery("SELECT * FROM {{table}} group by ip order by ip asc", 'usuarios'); //Sacamos los usuarios ordenados por IP
 
 while ($row = mysql_fetch_assoc($query)) {    //MIRAMOS 1 POR 1
    if($row['ip'] > 1 AND $row['ip'] != NULL AND $row['ip'] != 0000) { //Si esta ip tiene mas de 1 ultimo login
    $query2 = doquery("SELECT id,username,user_lastip FROM {{table}} where user_lastip='{$row['user_lastip']}' order by username asc", 'users'); //Sacamos los usuarios que usan la ip
    $parse['multi'] .= "<tr>";
    $parse['multi'] .= "<td class=\"c\" colspan=\"2\" style=\"color:#FFFFFF\"><strong>{$row['user_lastip']} </strong> <a href=\"lista-multi.php?banear={$row['user_lastip']}\"> [Banearlos]</A></td>";
    $parse['multi'] .= "</tr>";
    
    while ($row2 = mysql_fetch_assoc($query2)) {
    $parse['multi'] .= "<tr>";
    $parse['multi'] .= "<td class=\"c\" align=\"center\"><img src=\"../styles/skins/evolution/img/m.gif\"></td>";
    $parse['multi'] .= "<td class=\"b\" style=\"color:#FFFFFF\"><strong>{$row2['username']}</strong></td>";
    $parse['multi'] .= "</tr>";    
    }
	
	 //Finalizamos el Parsing
    admindisplay($page, "Administración-Multicuentas");
	
	?>