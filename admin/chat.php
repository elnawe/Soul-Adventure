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


if ($_GET['opcion'] == 'chat')
{
$query = doquery("DELETE FROM {{table}} WHERE id >'0' ", "chat"); //Resetear Chat
$query = doquery("INSERT INTO {{table}} SET fh_mensaje=NOW(), usuario='Administrador', mensaje='Chat limpiado.' ", "chat"); //Mensaje Bot para el chat 
}
$template = gettemplate("admin/paginas/chat");
$page = parsetemplate($template, $controlrow, $userrow);
    $page = $xml . $page;
admindisplay($page, "Administración-Chat");
    
?>