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
     if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Requiere nombre.<br />"; }
        if ($maxhp == "") { $errors++; $errorlist .= "Requiere PV máxima.<br />"; }
        if (!is_numeric($maxhp)) { $errors++; $errorlist .= "PV máxima debe ser un número.<br />"; }
        if ($maxdam == "") { $errors++; $errorlist .= "Daño máximo requerido.<br />"; }
        if (!is_numeric($maxdam)) { $errors++; $errorlist .= "El daño máximo debe ser un número.<br />"; }
        if ($armor == "") { $errors++; $errorlist .= "Requiere armadura.<br />"; }
        if (!is_numeric($armor)) { $errors++; $errorlist .= "Armadura debe ser un número.<br />"; }
        if ($nivel == "") { $errors++; $errorlist .= "Nivel de monstruo requerido.<br />"; }
        if (!is_numeric($nivel)) { $errors++; $errorlist .= "Nivel del monstruo debe ser un número.<br />"; }
        if ($maxexp == "") { $errors++; $errorlist .= "Experiencia máxima requerida.<br />"; }
        if (!is_numeric($maxexp)) { $errors++; $errorlist .= "Experiencia máxima debe ser un número.<br />"; }
        if ($maxgold == "") { $errors++; $errorlist .= "Oro máximo requerido.<br />"; }
        if (!is_numeric($maxgold)) { $errors++; $errorlist .= "Oro máximo debe ser un número.<br />"; }
        
        if ($errors == 0) { 
		$query = doquery("INSERT INTO {{table}} SET id='',name='$name',maxhp='$maxhp',maxdam='$maxdam',armor='$armor',nivel='$nivel',maxexp='$maxexp',maxgold='$maxgold',immune='$immune' ", "monstruos");
            admindisplay("Monstruo creado.","Crear nuevo monstruo");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />", "Agregar Monstruo");
        }        
        
    }   
$template = gettemplate("admin/paginas/anadir/monstruo");
$page = parsetemplate($template,$row);
    $page = $xml . $page;
admindisplay($page, "Chat");


?>