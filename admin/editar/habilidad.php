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
        
    $id=$_POST['id'];
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id' LIMIT 1", "habilidades");
    $row = mysql_fetch_array($query);
    if ($row["type"] == 1) { $row["type1select"] = "selected"; } else { $row["type1select"] = ""; }
    if ($row["type"] == 2) { $row["type2select"] = "selected"; } else { $row["type2select"] = ""; }
    if ($row["type"] == 3) { $row["type3select"] = "selected"; } else { $row["type3select"] = ""; }
    if ($row["type"] == 4) { $row["type4select"] = "selected"; } else { $row["type4select"] = ""; }
    if ($row["type"] == 5) { $row["type5select"] = "selected"; } else { $row["type5select"] = ""; }
    
   $template = gettemplate("admin/paginas/editar/habilidad");
$page = parsetemplate($template,$row);
    $page = $xml . $page;
admindisplay($page, "Administración- Editar habilidad");
?>