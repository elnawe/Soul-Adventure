<?php
#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribuci�n de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para m�s informaci�n: www.soul-adventure.net							#
# *                                                          				#
#############################################################################
 $query = doquery("SELECT id,name,buycost FROM {{table}} ORDER BY id", "items");
  $template = gettemplate("admin/paginas/item");
	$page = parsetemplate($template,$controlrow);
    $page = $xml . $page;
    $count = 1;
    while ($row = mysql_fetch_array($query)) {
        if ($count == 1) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">".$row["id"]."</td><td style=\"background-color: #eeeeee;\">".$row["name"]."</a></td><td style=\"background-color: #eeeeee;\">".$row["buycost"]."</a></td></tr>\n";}
    }
    if (mysql_num_rows($query) == 0) { $page .= "<tr><td width=\"8%\" style=\"background-color: #eeeeee;\">No items found.</td></tr>\n"; }
    $page .= "</table>";
    admindisplay($page, "Administraci�n-Items");
?>