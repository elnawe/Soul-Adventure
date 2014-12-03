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
        if ($name == "") { $errors++; $errorlist .= "Requiere un nombre.<br />"; }
        if ($buycost == "") { $errors++; $errorlist .= "Requiere un costo.<br />"; }
        if (!is_numeric($buycost)) { $errors++; $errorlist .= "El costo debe ser un número.<br />"; }
        if ($attribute == "") { $errors++; $errorlist .= "Requiere un atributo.<br />"; }
        if (!is_numeric($attribute)) { $errors++; $errorlist .= "Atributo debe ser un número.<br />"; }
        if ($special == "" || $special == " ") { $special = "X"; }
        
        if ($errors == 0) { 
            $query = doquery("INSERT INTO {{table}} SET name='$name',type='$type',buycost='$buycost',attribute='$attribute',special='$special'", "items");
            admindisplay("Nuevo item creado.","Agregar Items");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />", "Agregar Items");
        }        
        
    }   
$template = gettemplate("admin/paginas/anadir/item");
$page = parsetemplate($template, $row);
    $page = $xml . $page;
admindisplay($page, "Chat");

	
?>