<?php

function changelog2() { 

    
    $page = "<div class='titulo'>Changelog.</div>";
    $page .= "
	<div class='contenido2'>
	<table width='590'>
<tr>
<td>Version</td>
<td>Cambios</td>
</tr>
<td>2.0</td>
<td>
-Agregado un banco para los usuarios<br>
-Agregada la opcion de entrenar.<br>
-Arreglado el cambio de contrase�a, antes te llevaba a un panel diferente al del juego ahora no.<br>
-Corregido diversos errores gr�ficos en varios archivos del juego.<br>
-Corregidos los archivos de ayuda acordes con las novedades del juego.<br>
-Creado nuevo mapa en el juego, ahora cuando estas explorando se te indica tu posici�n real con un punto azul.<br>
-Bug[#001]El ranking no aparece ordenador por nivel y exp. (Parece que solo por nivel o fecha de registro)-Solucionado<br>
</td>
</tr>
<td>2.0 Beta</td>
<td>
-Ya se pueden agregar drops desde el panel de administraci&oacute;n<br>
-Ya se pueden crear ciudades desde el panel de administraci&oacute;n-<br>
-A�adido este changelog para ver la lista de cambios-<br>
-Ahora el ranking no muestra solo 10 usuarios sino todos-<br>
-Creaci&oacute;n de un logo personalizado.Agradecimientos a <a href='http://innateroaring.blogspot.com/'>InnateRoaring</a>-<br>
-A�adida la funci�n de envio masivo de mensajes por parte de los admin-<br>
-A�adido sistema de clanes sin utilidades por ahora-<br>
-Redise�o total del juego-
-Implementaci&oacute;n de sistema de razas y clases-<br>
-Implementado sistema PVP-<br>
-Eliminacion de iconos del centro del panel-<br>
-A�adido reseteo del chat-<br>
-Mejora en el sistema de chat, ahora tambi&eacute;n existen emoticonos-<br>
-Separaci�n de los diferentes aspectos del panel de administraci�n en archivos php diferentes-<br>
-Cambios en el aspecto grafico del menu de administracion-<br>
-Separacion del codigo html del panel de administraci�n del codigo php mediante la utilizacion de templates-<br>
-Reducci�n de querys y borrado de codigos innecesarios del panel de administracion-<br>
</tr>
<tr>
<td>1.5</td>
<td>
-Capacidad de crear habilidades<br>
-Crear monstros<br>
-Crear items<br>
-Panel admin actualizado<br>
</td>
</tr>
<tr>
<td>1.1.1.2</td>
<td>
    -Se agrego la opci�n 'Agregar Monstruos' desde el panel de administraci�n.<br>
	-[Fix]Error que se en la edici�n de niveles y en la creaci�n de monstruos.<br>
    -�ltimas correciones con la version anterior<br>
    -Se agregaron emoticonos en el ShoutBox<br>
	</td>
</tr>
<tr>
<tr>
<td colspan='2'><a href='index.php?do=changelog'>Ir a la pagina anterior</a> - <a href='index.php?do=changelog3'>Ir a la siguiente pagina</a></td>
</tr>
</table>";
    $page .= "<a href=\"index.php\">Volver</a></div>";
    display($page, "Changelog");  
  
	
}

function changelog3()
{ 
 
    $page = "<div class='titulo'>Changelog.</div>";
    $page .= "
	<div class='contenido2'>
	<table width='590'>
	<tr>
<td>Version</td>
<td>Cambios</td>
</tr>
	<td>1.1.1.2</td>
<td>-Se arreglaron las conexiones a la base de datos del Panel Admin<br>
    -Se arreglo 'Hoja de Personaje'<br>
    -Se arreglo lib.php, correci�n de versi�n.<br>
    -Se arreglaron los errores del foro, en foro.php.<br></td>
</tr>

	<tr>
<td>1.1.1.1</td>
<td>-Se arreglaron los links del panel admin.<br>
    -Se arreglo mapa.php, habia un error en la conexi�n a la tabla de la BD.<br>
    -Se arreglo lib.php, correci�n de versi�n.<br>
    -Se arreglaron los errores del foro, en foro.php.<br></td>
</tr>
    <tr>
	<td>1.1.1.0</td>
	<td>-Se agregaron CSSs generales para la edici�n m�s r�pida.<br>
    -Cambios en todas las bases de datos.<br>
    -Cambios en todos los enlances.<br>
    -M�s r�pidez de manejo en cuestion a im�genes.<br></td>
	</tr>
<tr>
<td>1.0</td>
<td>-Permite a los usuarios crear juegos webbased sin necesidad de programar.-<br>
    -Permite tener una imagen para cada raza en el juego que lo identificar�.-<br>
    -Grandes posibilidades para los monstruos.-<br>
    -Interfase original y c�moda.-<br>
    -Posibilidad de crear juegos adictivos para amantes de los RPG webbased y los text-games-<br></td>
</tr>
<tr>
<td colspan='2'><a href='index.php?do=changelog2'>Ir a la pagina anterior</a></td>
</tr>
</table>";
$page .= "<a href=\"index.php\">Volver</a></div>";
    display($page, "Changelog");  
	}
	
	function changelog()
{ 
 
    $page = "<div class='titulo'>Changelog.</div>";
    $page .= "
	<div class='contenido2'>
	<table width='590'>
	<tr>
<td>Version</td>
<td>Cambios</td>
</tr>
	<td>2.1</td>
<td>- A�adido banco en el panel de administraci�n en editar usuarios.<br />
    - A�adido nombre del personaje y password (en md5) en editar usuarios.<br />
    - A�adido nombre del juego en el login para editarlo desde el panel administraci�n.<br />
    - A�adido al explorar el mapa puedes encontrar peque�as cantidades de oro.<br />
    - Bug[#004] En el mensajero al seleccionar mensajes y darle a borrar borra todos independientemente de si has seleccionado o no.<br />
    - Bug[#005] Al darle a editar el nivel 100 no aparecen los datos rellenos, solo hasta nivel 99<br />
    - Pvp reformado por completo, funcional al 100% con algunos peque�os bugs<br />
    - [FIX] Algunos errores de divs como en el chat cerrado y tipograficos<br /></td>
</tr>

	<tr>
<td>2.2</td>
<td>-Actualizando....<br>
</tr>
<tr>
<td colspan='2'><a href='index.php?do=changelog2'>Ir a la pagina siguiente</a></td>
</tr>
</table>";
$page .= "<a href=\"index.php\">Volver</a></div>";
    display($page, "Changelog");  
	}
	
	
	?>