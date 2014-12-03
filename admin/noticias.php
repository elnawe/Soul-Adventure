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
        if ($content == "") { $errors++; $errorlist .= "Requiere contenido.<br />"; }
        if ($errors == 0) { 
            $query = doquery("INSERT INTO {{table}} SET id='',postdate=NOW(),content='$content'", "noticias");
            admindisplay("Nuevo mensaje agregado.","Agregar Noticia");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />Retroceda y vuelva a intentarlo.", "Agregar Noticia");
        }        
        
    }   
	$template = gettemplate("admin/paginas/noticias");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración Noticias");
    
    
	
?>