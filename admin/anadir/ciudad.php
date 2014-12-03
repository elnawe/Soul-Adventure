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
        if ($latitude == "") { $errors++; $errorlist .= "Requiere una latitud.<br />"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "Latitud debe ser un número.<br />"; }
        if ($longitude == "") { $errors++; $errorlist .= "Requiere una longitud.<br />"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "Logitud debe ser un número.<br />"; }
        if ($innprice == "") { $errors++; $errorlist .= "Requiere precio de hotel.<br />"; }
        if (!is_numeric($innprice)) { $errors++; $errorlist .= "Precio de hotel debe ser un número.<br />"; }
        if ($mapprice == "") { $errors++; $errorlist .= "Requiere un precio de mapa.<br />"; }
        if (!is_numeric($mapprice)) { $errors++; $errorlist .= "Precio de mapa debe ser un número.<br />"; }

        if ($travelpoints == "") { $errors++; $errorlist .= "Requiere Puntos de Recorrido.<br />"; }
        if (!is_numeric($travelpoints)) { $errors++; $errorlist .= "Puntos de recorrido deben ser números.<br />"; }
        if ($itemslist == "") { $errors++; $errorlist .= "Requiere lista de items.<br />"; }
        
        if ($errors == 0) { 
		$query = doquery("INSERT INTO {{table}} SET id='',name='$name',latitude='$latitude',longitude='$longitude',innprice='$innprice',mapprice='$mapprice',travelpoints='$travelpoints',itemslist='$itemslist'", "ciudades");
		$page = "Ciudad añadida con exito";
            admindisplay($page,"Agregar Ciudades");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />", "Agregar Ciudades");
        }        
        
    }   
$template = gettemplate("admin/paginas/anadir/ciudad");
$page = parsetemplate($template,$row);
    $page = $xml . $page;
admindisplay($page, "Chat");
    

?>