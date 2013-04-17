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
	$id= $_POST['id'];   
    $query = doquery("SELECT * FROM {{table}} WHERE id='$id'", "usuarios");
    $row = mysql_fetch_array($query);
    global $controlrow;
    $diff1name = $controlrow["diff1name"];
    $diff2name = $controlrow["diff2name"];
    $diff3name = $controlrow["diff3name"];
    $class1name = $controlrow["class1name"];
    $class2name = $controlrow["class2name"];
    $class3name = $controlrow["class3name"];
	$race1name = $controlrow["race1name"];
	$race2name = $controlrow["race2name"];
	$race3name = $controlrow["race3name"];
	$race4name = $controlrow["race4name"];
	$race5name = $controlrow["race5name"];
	if ($row["autorizacion"] == 0) { $row["auth0select"] = "selected"; } else { $row["auth0select"] = ""; }
    if ($row["autorizacion"] == 1) { $row["auth1select"] = "selected"; } else { $row["auth1select"] = ""; }
    if ($row["autorizacion"] == 2) { $row["auth2select"] = "selected"; } else { $row["auth2select"] = ""; }
    if ($row["charclass"] == 1) { $row["class1select"] = "selected"; } else { $row["class1select"] = ""; }
    if ($row["charclass"] == 2) { $row["class2select"] = "selected"; } else { $row["class2select"] = ""; }
    if ($row["charclass"] == 3) { $row["class3select"] = "selected"; } else { $row["class3select"] = ""; }
	
	if ($row["charrace"] == 1) { $row["race1select"] = "selected"; } else { $row["race1select"] = ""; }
    if ($row["charrace"] == 2) { $row["race2select"] = "selected"; } else { $row["race2select"] = ""; }
    if ($row["charrace"] == 3) { $row["race3select"] = "selected"; } else { $row["race3select"] = ""; }
	if ($row["charrace"] == 4) { $row["race1select"] = "selected"; } else { $row["race4select"] = ""; }
    if ($row["charrace"] == 5) { $row["race2select"] = "selected"; } else { $row["race5select"] = ""; }

    if ($row["difficulty"] == 1) { $row["diff1select"] = "selected"; } else { $row["diff1select"] = ""; }
    if ($row["difficulty"] == 2) { $row["diff2select"] = "selected"; } else { $row["diff2select"] = ""; }
    if ($row["difficulty"] == 3) { $row["diff3select"] = "selected"; } else { $row["diff3select"] = ""; }

		$template = gettemplate("admin/paginas/editar/usuario");
$page = parsetemplate($template, $row);
    $page = $xml . $page;
admindisplay($page, "Administración-Editar Usuario");
   

    
    

    

 
        
?>