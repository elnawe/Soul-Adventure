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
        if ($name == "") { $errors++; $errorlist .= "Se requiere nombre.<br />"; }
        if ($mnivel == "") { $errors++; $errorlist .= "Se requiere Nivel de Monstruo.<br />"; }
        if (!is_numeric($mnivel)) { $errors++; $errorlist .= "Nivel de Monstruo debe ser un número.<br />"; }
        if ($attribute1 == "" || $attribute1 == " " || $attribute1 == "X") { $errors++; $errorlist .= "Se requiere un atributo primario.<br />"; }
        if ($attribute2 == "" || $attribute2 == " ") { $attribute2 = "X"; }
        
        if ($errors == 0) { 
            $query = doquery("INSERT INTO {{table}} SET name='$name',mnivel='$mnivel',attribute1='$attribute1',attribute2='$attribute2'", "drops");
            admindisplay("Item drop Creado.","Agregar Drops");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />", "Agregar Drops");
        }        
        
    }   

$template = gettemplate("admin/paginas/anadir/drop");
$page = parsetemplate($template,$row);
    $page = $xml . $page;
admindisplay($page, "Chat");
?>