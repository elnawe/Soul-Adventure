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
include_once('../includes/comprueba_admin.php');


switch($_GET['ir'])
{
case 'general' :
	$template = gettemplate("admin/general");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Ajustes Generales");
break;

case 'items' :
	$template = gettemplate("admin/items");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Items");
break;

case 'ciudad' :
	$template = gettemplate("admin/ciudad");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Ciudad");
break;

case 'monstruo' :
	$template = gettemplate("admin/monstruo");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Monstruos");
break;

case 'drop' :
	$template = gettemplate("admin/drop");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Drops");
break;

case 'habilidad' :
	$template = gettemplate("admin/habilidad");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Habilidades");
break;
case 'usuario' :
	$template = gettemplate("admin/usuario");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Usuarios");
break;
}

switch($_GET['opcion'])
{

case 'inicio' :
	$template = gettemplate("admin/inicio");
	$page = parsetemplate($template, $finalarray);
    $page = $xml . $page;
	admindisplay($page, "Administración-Inicio");
break;

case 'principal' :
include_once('principal.php');
break;

case 'chat' :
include_once('chat.php');
break;

case 'noticias' :
include_once('noticias.php');
break;

case 'usuario' :
include_once('usuario.php');
break;

case 'editarusuario' :
include_once('editar/usuario.php');
break;

case 'borrarusuario' :
include_once('borrar/usuario.php');
break;

case 'nivel' :
include_once('nivel.php');
break;

case 'editarnivel' :
include_once('editar/nivel.php');
break;

case 'item' :
include_once('item.php');
break;

case 'anadiritem' :
include_once('anadir/item.php');
break;

case 'editaritem' :
include_once('editar/item.php');
break;

case 'ciudad' :
include_once('ciudad.php');
break;

case 'anadirciudad' :
include_once('anadir/ciudad.php');
break;

case 'editarciudad' :
include_once('editar/ciudad.php');
break;


case 'monstruo' :
include_once('monstruo.php');
break;

case 'anadirmonstruo' :
include_once('anadir/monstruo.php');
break;

case 'editarmonstruo' :
include_once('editar/monstruo.php');
break;

case 'drop' :
include_once('drop.php');
break;

case 'anadirdrop' :
include_once('anadir/drop.php');
break;

case 'editardrop' :
include_once('editar/drop.php');
break;

case 'habilidad' :
include_once('habilidad.php');
break;

case 'anadirhabilidad' :
include_once('anadir/habilidad.php');
break;

case 'editarhabilidad' :
include_once('editar/habilidad.php');
break;

case 'actualizar' :
include_once('update.php');
break;


}


?>