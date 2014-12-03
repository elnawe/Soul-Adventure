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

include('configuracion.php');
include('lib.php');
$start = getmicrotime();
if (isset($_GET["page"])) {
	$page = explode(":",$_GET["page"]);

	
    if ($page[0] == "instalar") { instalar(); }
	elseif ($page[0] == "actualizar") { actualizar(); }
    elseif ($page[0] == "licencia") { licencia(); }
	elseif ($page[0] == "creartablas") { creartablas(); }
	elseif ($page[0] == "administracion") { administracion(); }
	elseif ($page[0] == "cuentacreada") { cuentacreada(); }
	} else { inicio(); }

// Thanks to Predrag Supurovic from php.net for this function!
function dobatch ($p_query) {
  $query_split = preg_split ("/[;]+/", $p_query);
  foreach ($query_split as $command_line) {
   $command_line = trim($command_line);
   if ($command_line != '') {
     $query_result = mysql_query($command_line) or die(mysql_error());
     if ($query_result == 0) {
       break;
     };
   };
  };
  return $query_result;
}

function inicio()
	{
			$page = "<html><head><title>Instalaci&oacute;n de Soul Adventure</title><link href='estilo/css/instalar.css' rel='stylesheet' type='text/css' /></head><body>";
			$page .= "
			<div class='contenido'>
			<div class='menu'><ul><li><a href=\"instalar.php\">Inicio</a></li><li><a href=\"instalar.php?page=instalar\">Instalar</a></li><li><a href=\"instalar.php?page=actualizar\">Actualizar</a></li><li><a href=\"instalar.php?page=licencia\">Licencia</a></li></ul></div>";
			$page .= "<div class='titulo'>Bienvenido a la instalaci&oacute;n de Soul Adventure</div>";
			$page .= "<div><p>Al registrarte te conviertes en un heroe con el cual deberas subir niveles para conseguir objetos, 
			combatir contra otros heroes y contra las criaturas y monstruos que habitan en diferentes ciudades, 
			una gran ayuda para esto es la opcion de magias que tiene el juego.  En las diferentes ciudades segun vayas subiendo de 
			nivel las amenazas seran m&aacute;s fuertes y los items de las tiendas mejores.</p>
			<p> Si quieres que todos tus usuarios disfruten de este script solo deberas dalr al boton Instalar.Recuerda antes leer los termino de licencia
			sobre los que se rige Soul Adventure.</p>
			<p>Si tienes una versión inferior a esta deberas darle al actualizar y sustituir todos los ficheros excepto configuracion.php</p></div></body></html>";
			
			echo $page;
	}
function licencia()
	{
        $page = "<html><head><title>Licencia de Soul Adventure</title><link href='estilo/css/instalar.css' rel='stylesheet' type='text/css' /></head><body>";                                				
		$page .="<div class='contenido'><div class='menu'><ul><li><a href=\"instalar.php\">Inicio</a></li<li><a href=\"instalar.php?page=instalar\">Instalar</a></li><li><a href=\"instalar.php?page=actualizar\">Actualizar</a></li><li><a href=\"instalar.php?page=licencia\">Licencia</a></li></ul></div>";
		$page .= "<div class='titulo'>Licencia de Soul Adventure</div>";
		$page .= "<div>Este proyecto esta bajo una licencia Creative Commons   				
 Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):<p>				
 No se permite un uso comercial de la obra original ni de las posibles	
obras derivadas, la distribuci&oacute;n de las cuales se debe hacer con una	
 licencia igual a la que regula la obra original. </p>  						
 																		
 <p>Este proyecto toma como base los scripts de:<ul>						
  <li>Jamin Seven (Dragon Knight)</li>											
 <li>Adam Dear (Dragon Kingdom)</li>											
<li>Nawe(Soul Adventure)-abandono por falta de tiempo</li></ul></p>		       
<p>Actualmente siguen su desarrollo Ethernity y Skinet</p>						
Para más información: <a href='www.soul-adventure.net'>Foro oficial de soul adventure</a></div></div></body></html>";

echo $page;						
	}

function actualizar()
	{
$page= "<html><head><title>Actualizaci&oacute;n de Soul Adventure</title><link href='estilo/css/instalar.css' rel='stylesheet' type='text/css' /></head><body>";
	if(isset($_POST['si']))
	{
	  $link = opendb();
    global $dbsettings;
    
	$prefix = $dbsettings["prefix"];
	$clan = $prefix . "_clan";
    $babble = $prefix . "_chat";
    $control = $prefix . "_control";
    $drops = $prefix . "_drops";
    $forum = $prefix . "_foro";
    $items = $prefix . "_items";
    $levels = $prefix . "_niveles";
    $monsters = $prefix . "_monstruos";
	$mail = $prefix . "_mail";
    $news = $prefix . "_noticias";
    $spells = $prefix . "_habilidades";
    $towns = $prefix . "_ciudades";
    $users = $prefix . "_usuarios";
    $pvp = $prefix . "_pvp";

$query = "ALTER TABLE `$users` ADD `ip` VARCHAR(15) NOT NULL default '000';";
$query .= "ALTER TABLE `$users` ADD  `pvpganados` int(4) NOT NULL default '0';";
$query .= "ALTER TABLE `$users` ADD  `pvpempatados` int(4) NOT NULL default '0';";
$query .=  "ALTER TABLE `$users` ADD  `pvpperdidos` int(4) NOT NULL default '0';";
$query .=  "ALTER TABLE `$users` CHANGE  `guildname`  `nombreclan` VARCHAR(30) NOT NULL;";

$query .=  "ALTER TABLE `$mail` ADD  `estado`  VARCHAR(30) NOT NULL;";

$query .=  "ALTER TABLE `$clan` CHANGE  `name`  `nombre` VARCHAR(30) NOT NULL;";
$query .=  "ALTER TABLE `$clan` CHANGE  `members`  `miembros` VARCHAR(30) NOT NULL;";
$query .=  "ALTER TABLE `$clan` CHANGE  `description`  `descripcion` VARCHAR(30) NOT NULL;";
$query .=  "ALTER TABLE `$clan` CHANGE  `joincost`  `coste` VARCHAR(30) NOT NULL;";
$query .=  "ALTER TABLE `$clan` CHANGE  `founder`  `fundador` VARCHAR(30) NOT NULL;";
$query .=  "ALTER TABLE `$clan` CHANGE  `gold`  `bancoclan` VARCHAR(30) NOT NULL;";
$query .=  "ALTER TABLE `$clan` ADD  `privado`  smallint(1) NOT NULL;";
$query .= "UPDATE $control SET `race4name` = 'Dark' WHERE `id` = '1';";

		if (dobatch($query) == 1) { echo "Actualizaci&oacute;n con exito.<br />"; } 
		else { echo "Error creando las tablas."; }
			unset($query);
	}
	elseif(isset($_POST['no']))
	{
	header("Location: instalar.php");
	}
	else
		{
		$page .="<div class='contenido'><div class='menu'><ul><li><a href=\"instalar.php\">Inicio</a></li<li><a href=\"instalar.php?page=instalar\">Instalar</a></li><li><a href=\"instalar.php?page=actualizar\">Actualizar</a></li><li><a href=\"instalar.php?page=licencia\">Licencia</a></li></ul></div>";
		$page .= "<div class='titulo'>Actualizaci&oacute;n de Soul Adventure</div>";
$page .= "<div><p>Esta a punto de actualizar su versi&oacute; de Soul Adventure, esta actualizaci&oacute;n solo funciona de la versi&oacute;n 2.1 a la versi&oacute;n 2.2</p>";
 $page .="<p>Pulse en la opcion adecuada</p>";
 $page .="<form action=instalar.php?page=actualizar method='post'>";
 $page .="<input type='submit' name='si' value='Actualizar' class='boton'> <input type='submit' name='no' value='Cancelar' class='boton'></form></div></div></body></html>";
 
echo $page;
}
	}
function instalar() {
$page= "<html><head><title>Instalacion&oacute;n de Soul Adventure</title><link href='estilo/css/instalar.css' rel='stylesheet' type='text/css' /></head><body>";
if (isset($_POST[submit])) {
$myFile = "configuracion.php";
$fh = fopen($myFile, 'w');
$stringData = <<<END
<?php // configuracion.php :: Configuracion para el juego
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
\$dbsettings = Array(
        "server"        => "$_POST[host]",     // Servidor MySQL. (Default: localhost)
        "user"          => "$_POST[user]",              // Usuario MySQL.
        "pass"          => "$_POST[pass]",              // Contraseña MySQL.
        "name"          => "$_POST[name]",              // Nombre de Base de datos MySQL.
        "prefix"        => "$_POST[prefijo]",            // Prefijo para tablas. (Default: sa) NO CAMBIAR
        "secretword"    => "$_POST[secret]");             // Palabra secreta.

?>
END;
fwrite($fh, $stringData);
echo <<<END
<META http-equiv="refresh" content="0;URL=instalar.php?page=creartablas">
END;
} else {
		$page .="<div class='contenido'><div class='menu'><ul><li><a href=\"instalar.php\">Inicio</a></li<li><a href=\"instalar.php?page=instalar\">Instalar</a></li><li><a href=\"instalar.php?page=actualizar\">Actualizar</a></li><li><a href=\"instalar.php?page=licencia\">Licencia</a></li></ul></div>";
		$page .= "<div class='titulo'>Instalaci&oacute;n de Soul Adventure</div>";
		$page .="
<div align='center'><b>Rellena los siguientes campos para crear rellenar automaticamente el archivo configuracion.php</b><br />
  <br />
</div>
<form action='instalar.php?page=instalar' method='post'>
  
  <div align='center'>
    <table border='0'>
      <tr>
        <td>Servidor MySQL:</td>
        <td><input type='text' name='host'></td>
      </tr>
      <tr>
        <td>Usuario:</td>
        <td><input type='text' name='user'></td>
      </tr>
      <tr>
        <td>Contraseña:</td>
        <td><input type='text' name='pass'></td>
      </tr>
      <tr>
        <td>Nombre Base de Datos:</td>
        <td><input type='text' name='name'></td>
      </tr>
      <tr>
	  <tr>
        <td>Prefijo de las tablas:</td>
        <td><input type='text' name='prefijo'></td>
      </tr>
      <tr>
        <td>Palabra Secreta</td>
        <td><input type='text' name='secret'></td>
      </tr>
    </table>
    <input type='submit' name='submit' value='Crear' class='boton'>
  </div>
</form>
</body>
</html>
";
echo $page;
}
}


function creartablas() { // Segunda Página
    $link = opendb();
    global $dbsettings;
   $page= "<html><head><title>Instalaci&oacute;n de Soul Adventure</title><link href='estilo/css/instalar.css' rel='stylesheet' type='text/css' /></head><body><div class='contenido'><div class='titulo'>Estado de la instalaci&oacute;n</div>";
    $prefix = $dbsettings["prefix"];
	$clan = $prefix . "_clan";
    $babble = $prefix . "_chat";
    $control = $prefix . "_control";
    $drops = $prefix . "_drops";
    $forum = $prefix . "_foro";
    $items = $prefix . "_items";
    $levels = $prefix . "_niveles";
    $monsters = $prefix . "_monstruos";
	$mail = $prefix . "_mail";
    $news = $prefix . "_noticias";
    $spells = $prefix . "_habilidades";
    $towns = $prefix . "_ciudades";
    $users = $prefix . "_usuarios";
    $pvp = $prefix . "_pvp";
	    if (isset($_POST["complete"])) { $full = true; } else { $full = false; }


$query = <<<END
CREATE TABLE `$clan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `tag` char(3) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `miembros` smallint(5) unsigned NOT NULL DEFAULT '1',
  `password` varchar(15) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `coste` mediumint(8) NOT NULL DEFAULT '150',
  `fundador` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `rango` int(1) NOT NULL,
  `bancoclan` int(255) NOT NULL,
  `privado` smallint(1) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas del clan fueron creadas.<br />"; } else { $page .= "Error creando las tablas."; }
unset($query);
		
$query = <<<END
CREATE TABLE `$babble` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fh_mensaje` datetime NOT NULL default '0000-00-00 00:00:00',
  `usuario` varchar(30) NOT NULL default '',
  `mensaje` varchar(120) NOT NULL default '',
  `touser` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas del chat fueron creadas.<br />"; } else { $page .= "Error creando las tablas."; }
unset($query);

$query = <<<END
CREATE TABLE `$control` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `gamename` varchar(50) NOT NULL default '',
  `gamesize` smallint(5) unsigned NOT NULL default '0',
  `gameopen` tinyint(3) unsigned NOT NULL default '0',
  `gameurl` varchar(200) NOT NULL default '',
  `adminemail` varchar(100) NOT NULL default '',
  `forumtype` tinyint(3) unsigned NOT NULL default '0',
  `forumaddress` varchar(200) NOT NULL default '',
  `class1name` varchar(50) NOT NULL default '',
  `class2name` varchar(50) NOT NULL default '',
  `class3name` varchar(50) NOT NULL default '',
   `race1name` varchar(25) NOT NULL default '',
  `race2name` varchar(25) NOT NULL default '',
  `race3name` varchar(25) NOT NULL default '',
  `race4name` varchar(25) NOT NULL default '',
  `race5name` varchar(25) NOT NULL default '',
  `diff1name` varchar(50) NOT NULL default '',
  `diff1mod` float unsigned NOT NULL default '0',
  `diff2name` varchar(50) NOT NULL default '',
  `diff2mod` float unsigned NOT NULL default '0',
  `diff3name` varchar(50) NOT NULL default '',
  `diff3mod` float unsigned NOT NULL default '0',
  `compression` tinyint(3) unsigned NOT NULL default '0',
  `verifyemail` tinyint(3) unsigned NOT NULL default '0',
  `shownews` tinyint(3) unsigned NOT NULL default '0',
  `showbabble` tinyint(3) unsigned NOT NULL default '0',
  `showonline` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

END;
if (dobatch($query) == 1) { $page .= "Las tablas de Control fueron creadas.<br />"; } else { $page .= "Error creando las tablas."; }
unset($query);

$query = <<<END
INSERT INTO `$control` VALUES (1, 'SouL Adventure', 250, 1, '', '', 1, '', 'Mago', 'Guerrero', 'Paladin', 'Humano', 'Elfo', 'Enano', 'Dark', 'Orco', 'Facil', '1', 'Intermedio', '1.2', 'Dificil', '1.5', 1, 1, 1, 1, 1);
END;
if (dobatch($query) == 1) { $page .= "Las tablas de control fueron llenadas.<br />"; } else { $page .= "Error al llenar las tablas de control."; }
unset($query);

$query = <<<END
CREATE TABLE `$drops` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `mnivel` smallint(5) unsigned NOT NULL default '0',
  `type` smallint(5) unsigned NOT NULL default '0',
  `attribute1` varchar(30) NOT NULL default '',
  `attribute2` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas de Drop fueron creadas.<br />"; } else { $page .= "Error creando las tablas de control."; }
unset($query);

if ($full == false) {

$query = "INSERT INTO `$drops` VALUES (1, 'Hoja de Vida', 1, 1, 'maxhp,10', 'X');";
$query .= "INSERT INTO `$drops` VALUES (2, 'Piedra de Vida', 10, 1, 'maxhp,25', 'X');";
$query .= "INSERT INTO `$drops` VALUES (3, 'Roca de Vida', 25, 1, 'maxhp,50', 'X');";
$query .= "INSERT INTO `$drops` VALUES (4, 'Hoja Magica', 1, 1, 'maxmp,10', 'X');";
$query .= "INSERT INTO `$drops` VALUES (5, 'Piedra Magica', 10, 1, 'maxmp,25', 'X');";
$query .= "INSERT INTO `$drops` VALUES (6, 'Roca Magica', 25, 1, 'maxmp,50', 'X');";
$query .= "INSERT INTO `$drops` VALUES (7, 'Escama de Dragon', 10, 1, 'defensepower,25', 'X');";
$query .= "INSERT INTO `$drops` VALUES (8, 'Alma de Dragon', 30, 1, 'defensepower,50', 'X');";
$query .= "INSERT INTO `$drops` VALUES (9, 'Garra de Dragon', 10, 1, 'attackpower,25', 'X');";
$query .= "INSERT INTO `$drops` VALUES (10, 'Diente de Dragon', 30, 1, 'attackpower,50', 'X');";
$query .= "INSERT INTO `$drops` VALUES (11, 'Lagrima de Dragon', 35, 1, 'strength,50', 'X');";
$query .= "INSERT INTO `$drops` VALUES (12, 'Ala de Dragon', 35, 1, 'dexterity,50', 'X');";
$query .= "INSERT INTO `$drops` VALUES (13, 'Pecado del Demonio', 35, 1, 'maxhp,-50', 'strength,50');";
$query .= "INSERT INTO `$drops` VALUES (14, 'Caida del Demonio', 35, 1, 'maxmp,-50', 'strength,50');";
$query .= "INSERT INTO `$drops` VALUES (15, 'Mentira del Demonio', 45, 1, 'maxhp,-100', 'strength,100');";
$query .= "INSERT INTO `$drops` VALUES (16, 'Odio del Demonio', 45, 1, 'maxmp,-100', 'strength,100');";
$query .= "INSERT INTO `$drops` VALUES (17, 'Diversion del Angel', 25, 1, 'maxhp,25', 'strength,25');";
$query .= "INSERT INTO `$drops` VALUES (18, 'Ascenso del Angel', 30, 1, 'maxhp,50', 'strength,50');";
$query .= "INSERT INTO `$drops` VALUES (19, 'Verdad del Angel', 35, 1, 'maxhp,75', 'strength,75');";
$query .= "INSERT INTO `$drops` VALUES (20, 'Amor del Angel', 40, 1, 'maxhp,100', 'strength,100');";
$query .= "INSERT INTO `$drops` VALUES (21, 'Diversion del Serafin', 25, 1, 'maxmp,25', 'dexterity,25');";
$query .= "INSERT INTO `$drops` VALUES (22, 'Ascenso del Serafin', 30, 1, 'maxmp,50', 'dexterity,50');";
$query .= "INSERT INTO `$drops` VALUES (23, 'Verdad del Serafin', 35, 1, 'maxmp,75', 'dexterity,75');";
$query .= "INSERT INTO `$drops` VALUES (24, 'Amor del Serafin', 40, 1, 'maxmp,100', 'dexterity,100');";
$query .= "INSERT INTO `$drops` VALUES (25, 'Ruby', 50, 1, 'maxhp,150', 'X');";
$query .= "INSERT INTO `$drops` VALUES (26, 'Perla', 50, 1, 'maxmp,150', 'X');";
$query .= "INSERT INTO `$drops` VALUES (27, 'Esmeralda', 50, 1, 'strength,150', 'X');";
$query .= "INSERT INTO `$drops` VALUES (28, 'Topaz', 50, 1, 'dexterity,150', 'X');";
$query .= "INSERT INTO `$drops` VALUES (29, 'Obsidiana', 50, 1, 'attackpower,150', 'X');";
$query .= "INSERT INTO `$drops` VALUES (30, 'Diamante', 50, 1, 'defensepower,150', 'X');";
$query .= "INSERT INTO `$drops` VALUES (31, 'Bonus de Memoria', 5, 1, 'expbonus,10', 'X');";
$query .= "INSERT INTO `$drops` VALUES (32, 'Bonus de Fortuna', 5, 1, 'goldbonus,10', 'X');";

if (dobatch($query) == 1) { $page .= "Las tablas de drops fueron llenadas.<br />"; } else { $page .= "Error al llenar las tablas de drop."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$forum` (
  `id` int(11) NOT NULL auto_increment,
  `postdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `newpostdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `autor` varchar(30) NOT NULL default '',
  `tema_padre` int(11) NOT NULL default '0',
  `respuesta` int(11) NOT NULL default '0',
  `titulo` varchar(100) NOT NULL default '',
  `pin` tinyint(1) default '0',
  `mensaje` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;

if (dobatch($query) == 1) { $page .= "La tabla de foro fue creada.<br />"; } else { $page .= "Error al crear las tablas de foro."; }
unset($query);

$query = <<<END
CREATE TABLE `$mail` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `mail` varchar(30) NOT NULL,
  `destinatario` varchar(30) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nuevo` varchar(30) NOT NULL,
  `remitente` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `message` varchar(100) NOT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM ;
END;
if (dobatch($query) == 1) { $page .= "Las tablas del Mensajero fueron creadas.<br />"; } else { $page .= "Error al crear las tablas del Mensajero."; }
unset($query);

$query = <<<END
CREATE TABLE `$pvp` (
  `id` smallint(6) NOT NULL auto_increment,
  `desafiador` smallint(6) NOT NULL default '0',
  `apuesta` mediumint(9) NOT NULL default '0',
  `charname` varchar(30) NOT NULL default '',
  `nivelpvp` mediumint(9) NOT NULL default '0',
  `oponente` smallint(6) NOT NULL default '0',
   PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "La tabla de PVP fue creada.<br />"; } else { $page .= "Error al crear la tabla de PVP."; }
unset($query);

$query = <<<END
CREATE TABLE `$items` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `type` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `buycost` smallint(5) unsigned NOT NULL default '0',
  `attribute` smallint(5) unsigned NOT NULL default '0',
  `special` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas de item fueron creadas.<br />"; } else { $page .= "Error al crear las tablas de item."; }
unset($query);

if ($full == false) {
$query = <<<END
INSERT INTO `$items` VALUES (1, 1, 'Palo', 10, 2, 'X');
INSERT INTO `$items` VALUES (2, 1, 'Rama', 30, 4, 'X');
INSERT INTO `$items` VALUES (3, 1, 'Maza', 40, 5, 'X');
INSERT INTO `$items` VALUES (4, 1, 'Daga', 90, 8, 'X');
INSERT INTO `$items` VALUES (5, 1, 'Destral', 150, 12, 'X');
INSERT INTO `$items` VALUES (6, 1, 'Hacha', 200, 16, 'X');
INSERT INTO `$items` VALUES (7, 1, 'Hacha Doble', 300, 25, 'X');
INSERT INTO `$items` VALUES (8, 1, 'Hacha Grande', 500, 35, 'X');
INSERT INTO `$items` VALUES (9, 1, 'Espada Grande', 800, 45, 'X');
INSERT INTO `$items` VALUES (10, 1, 'Hacha de Batalla', 1200, 50, 'X');
INSERT INTO `$items` VALUES (11, 1, 'Guantes de Garra', 2000, 60, 'X');
INSERT INTO `$items` VALUES (12, 1, 'Hacha Oscura', 3000, 100, 'expbonus,-5');
INSERT INTO `$items` VALUES (13, 1, 'Espada Oscura', 4500, 125, 'expbonus,-10');
INSERT INTO `$items` VALUES (14, 1, 'Espada Brillante', 6000, 100, 'expbonus,10');
INSERT INTO `$items` VALUES (15, 1, 'Espada Magica', 10000, 150, 'maxmp,50');
INSERT INTO `$items` VALUES (16, 1, 'Sable del Destino', 50000, 250, 'strength,50');
INSERT INTO `$items` VALUES (17, 2, 'Ropa Interior', 25, 2, 'goldbonus,10');
INSERT INTO `$items` VALUES (18, 2, 'Ropa de Tela', 50, 5, 'X');
INSERT INTO `$items` VALUES (19, 2, 'Armadura de Cuero', 75, 10, 'X');
INSERT INTO `$items` VALUES (20, 2, 'Armadura de Cuero Duro', 150, 25, 'X');
INSERT INTO `$items` VALUES (21, 2, 'Armadura de Cadenas', 300, 30, 'X');
INSERT INTO `$items` VALUES (22, 2, 'Armadura de Bronce', 900, 50, 'X');
INSERT INTO `$items` VALUES (23, 2, 'Armadura de Hierro', 2000, 100, 'X');
INSERT INTO `$items` VALUES (24, 2, 'Armadura Magica', 4000, 125, 'maxmp,50');
INSERT INTO `$items` VALUES (25, 2, 'Armadura Oscura', 5000, 150, 'expbonus,-10');
INSERT INTO `$items` VALUES (26, 2, 'Armadura Brillante', 10000, 175, 'expbonus,10');
INSERT INTO `$items` VALUES (27, 2, 'Armadura del Destino', 50000, 200, 'dexterity,50');
INSERT INTO `$items` VALUES (28, 3, 'Escudo de Lamina', 50, 2, 'X');
INSERT INTO `$items` VALUES (29, 3, 'Buckler', 100, 4, 'X');
INSERT INTO `$items` VALUES (30, 3, 'Escudo Pequeño', 500, 10, 'X');
INSERT INTO `$items` VALUES (31, 3, 'Escudo Largo', 2500, 30, 'X');
INSERT INTO `$items` VALUES (32, 3, 'Escudo de Plata', 10000, 60, 'X');
INSERT INTO `$items` VALUES (33, 3, 'Escudo del Destino', 25000, 100, 'maxhp,50');
END;
if (dobatch($query) == 1) { $page .= "La tabla de items se lleno.<br />"; } else { $page .= "Error al llenar las tablas de items."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$levels` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `1_exp` mediumint(8) unsigned NOT NULL default '0',
  `1_hp` smallint(5) unsigned NOT NULL default '0',
  `1_mp` smallint(5) unsigned NOT NULL default '0',
  `1_tp` smallint(5) unsigned NOT NULL default '0',
  `1_strength` smallint(5) unsigned NOT NULL default '0',
  `1_dexterity` smallint(5) unsigned NOT NULL default '0',
  `1_spells` tinyint(3) unsigned NOT NULL default '0',
  `2_exp` mediumint(8) unsigned NOT NULL default '0',
  `2_hp` smallint(5) unsigned NOT NULL default '0',
  `2_mp` smallint(5) unsigned NOT NULL default '0',
  `2_tp` smallint(5) unsigned NOT NULL default '0',
  `2_strength` smallint(5) unsigned NOT NULL default '0',
  `2_dexterity` smallint(5) unsigned NOT NULL default '0',
  `2_spells` tinyint(3) unsigned NOT NULL default '0',
  `3_exp` mediumint(8) unsigned NOT NULL default '0',
  `3_hp` smallint(5) unsigned NOT NULL default '0',
  `3_mp` smallint(5) unsigned NOT NULL default '0',
  `3_tp` smallint(5) unsigned NOT NULL default '0',
  `3_strength` smallint(5) unsigned NOT NULL default '0',
  `3_dexterity` smallint(5) unsigned NOT NULL default '0',
  `3_spells` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas de niveles se crearon.<br />"; } else { $page .= "Error al crear las tablas de niveles."; }
unset($query);

if ($full == false) {
$query = <<<END
INSERT INTO `$levels` VALUES (1, 0, 15, 0, 5, 5, 5, 0, 0, 15, 0, 5, 5, 5, 0, 0, 15, 0, 5, 5, 5, 0);
INSERT INTO `$levels` VALUES (2, 15, 2, 5, 1, 0, 1, 1, 18, 2, 4, 1, 2, 1, 1, 20, 2, 5, 1, 0, 2, 1);
INSERT INTO `$levels` VALUES (3, 45, 3, 4, 2, 1, 2, 0, 54, 2, 3, 2, 3, 2, 0, 60, 2, 3, 2, 1, 3, 0);
INSERT INTO `$levels` VALUES (4, 105, 3, 3, 2, 1, 2, 6, 126, 2, 3, 2, 3, 2, 0, 140, 2, 4, 2, 1, 3, 0);
INSERT INTO `$levels` VALUES (5, 195, 2, 5, 2, 0, 1, 0, 234, 2, 4, 2, 2, 1, 6, 260, 2, 4, 2, 0, 2, 6);
INSERT INTO `$levels` VALUES (6, 330, 4, 5, 2, 2, 3, 0, 396, 3, 4, 2, 4, 3, 0, 440, 3, 5, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (7, 532, 3, 4, 2, 1, 2, 11, 639, 2, 3, 2, 3, 2, 0, 710, 2, 3, 2, 1, 3, 0);
INSERT INTO `$levels` VALUES (8, 835, 2, 4, 2, 0, 1, 0, 1003, 2, 3, 2, 2, 1, 11, 1115, 2, 4, 2, 0, 2, 11);
INSERT INTO `$levels` VALUES (9, 1290, 5, 3, 2, 3, 4, 2, 1549, 4, 2, 2, 5, 4, 0, 1722, 4, 2, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (10, 1973, 10, 3, 2, 4, 3, 0, 2369, 10, 2, 2, 6, 3, 0, 2633, 10, 3, 2, 4, 4, 0);
INSERT INTO `$levels` VALUES (11, 2997, 5, 2, 2, 3, 4, 0, 3598, 4, 1, 2, 5, 4, 2, 3999, 4, 1, 2, 3, 5, 2);
INSERT INTO `$levels` VALUES (12, 4533, 4, 2, 2, 2, 3, 7, 5441, 4, 1, 2, 4, 3, 0, 6047, 4, 2, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (13, 6453, 4, 3, 2, 2, 3, 0, 7745, 4, 2, 2, 4, 3, 0, 8607, 4, 2, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (14, 8853, 5, 4, 2, 3, 4, 17, 10625, 4, 3, 2, 5, 4, 7, 11807, 4, 4, 2, 3, 5, 7);
INSERT INTO `$levels` VALUES (15, 11853, 5, 5, 2, 3, 4, 0, 14225, 4, 4, 2, 5, 4, 0, 15808, 4, 4, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (16, 15603, 5, 3, 2, 3, 4, 0, 18725, 5, 2, 2, 5, 4, 0, 20807, 5, 3, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (17, 20290, 4, 2, 2, 2, 3, 12, 24350, 4, 1, 2, 4, 3, 0, 27057, 4, 1, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (18, 25563, 4, 2, 2, 2, 3, 0, 30678, 3, 1, 2, 4, 3, 14, 34869, 3, 2, 2, 2, 4, 17);
INSERT INTO `$levels` VALUES (19, 31495, 4, 5, 2, 2, 3, 0, 37797, 3, 4, 2, 4, 3, 0, 43657, 3, 4, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (20, 38169, 10, 6, 2, 3, 3, 0, 45805, 10, 5, 2, 5, 3, 0, 53543, 10, 6, 2, 3, 4, 0);
INSERT INTO `$levels` VALUES (21, 45676, 4, 4, 2, 2, 3, 0, 54814, 4, 3, 2, 4, 3, 0, 64664, 4, 3, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (22, 54121, 5, 5, 2, 3, 4, 0, 64949, 4, 4, 2, 5, 4, 12, 77175, 4, 5, 2, 3, 5, 12);
INSERT INTO `$levels` VALUES (23, 63622, 5, 3, 2, 3, 4, 0, 76350, 4, 2, 2, 5, 4, 0, 91250, 4, 2, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (24, 74310, 5, 5, 2, 3, 4, 0, 89176, 4, 4, 2, 5, 4, 0, 107083, 4, 5, 2, 3, 5, 0);
INSERT INTO `$levels` VALUES (25, 86334, 4, 4, 2, 2, 3, 3, 103605, 3, 3, 2, 4, 3, 17, 124895, 3, 3, 2, 2, 4, 14);
INSERT INTO `$levels` VALUES (26, 99861, 6, 3, 2, 4, 5, 0, 119837, 5, 2, 2, 6, 5, 0, 144933, 5, 3, 2, 4, 6, 0);
INSERT INTO `$levels` VALUES (27, 115078, 6, 2, 2, 4, 5, 0, 138098, 5, 1, 2, 6, 5, 0, 167475, 5, 1, 2, 4, 6, 0);
INSERT INTO `$levels` VALUES (28, 132197, 4, 2, 2, 2, 3, 0, 158641, 4, 1, 2, 4, 3, 0, 192835, 4, 2, 2, 2, 4, 0);
INSERT INTO `$levels` VALUES (29, 151456, 6, 3, 2, 4, 5, 0, 181751, 5, 2, 2, 6, 5, 3, 221365, 5, 2, 2, 4, 6, 3);
INSERT INTO `$levels` VALUES (30, 173121, 10, 4, 3, 4, 4, 0, 207749, 10, 3, 3, 6, 4, 0, 253461, 10, 4, 3, 4, 5, 0);
INSERT INTO `$levels` VALUES (31, 197494, 5, 5, 3, 3, 4, 8, 236996, 4, 3, 3, 5, 4, 0, 289568, 4, 3, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (32, 224913, 6, 4, 3, 4, 5, 0, 269898, 5, 3, 3, 6, 5, 0, 330188, 5, 4, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (33, 255758, 5, 4, 3, 3, 4, 0, 306912, 5, 3, 3, 5, 4, 0, 375885, 5, 3, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (34, 290458, 6, 4, 3, 4, 5, 0, 348552, 5, 3, 3, 6, 5, 8, 427294, 5, 4, 3, 4, 6, 8);
INSERT INTO `$levels` VALUES (35, 329495, 5, 3, 3, 3, 4, 0, 395397, 4, 2, 3, 5, 4, 0, 485126, 4, 2, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (36, 373412, 4, 3, 3, 2, 3, 18, 448097, 5, 2, 3, 4, 3, 0, 550188, 5, 3, 3, 2, 4, 0);
INSERT INTO `$levels` VALUES (37, 422818, 5, 4, 3, 3, 4, 0, 507384, 5, 3, 3, 5, 4, 0, 623383, 5, 3, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (38, 478399, 6, 5, 3, 4, 5, 0, 574081, 5, 4, 3, 6, 5, 15, 705726, 5, 5, 3, 4, 6, 18);
INSERT INTO `$levels` VALUES (39, 540927, 6, 4, 3, 4, 5, 0, 649115, 5, 3, 3, 6, 5, 0, 798362, 5, 3, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (40, 611271, 15, 3, 3, 5, 5, 13, 733528, 15, 2, 3, 7, 5, 0, 902577, 15, 3, 3, 5, 6, 0);
INSERT INTO `$levels` VALUES (41, 690408, 7, 3, 3, 5, 2, 0, 828492, 6, 2, 3, 7, 2, 0, 1019818, 6, 2, 3, 5, 3, 0);
INSERT INTO `$levels` VALUES (42, 779437, 7, 4, 3, 5, 6, 0, 935326, 6, 3, 3, 7, 6, 0, 1151714, 6, 4, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (43, 879592, 8, 5, 3, 6, 7, 0, 1055514, 7, 4, 3, 8, 7, 0, 1300096, 7, 4, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (44, 992268, 6, 3, 3, 4, 5, 0, 1190725, 5, 2, 3, 6, 5, 0, 1448478, 5, 3, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (45, 1119028, 5, 8, 3, 3, 4, 4, 1325936, 5, 8, 3, 5, 4, 18, 1596860, 5, 8, 3, 3, 5, 4);
INSERT INTO `$levels` VALUES (46, 1245788, 6, 5, 3, 4, 5, 0, 1461147, 5, 4, 3, 6, 5, 0, 1745242, 5, 5, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (47, 1372548, 7, 4, 3, 5, 6, 0, 1596358, 6, 3, 3, 7, 6, 0, 1893624, 6, 3, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (48, 1499308, 6, 4, 3, 4, 5, 0, 1731569, 5, 3, 3, 6, 5, 0, 2042006, 5, 4, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (49, 1626068, 5, 3, 3, 3, 4, 0, 1866780, 4, 2, 3, 5, 4, 0, 2190388, 4, 2, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (50, 1752828, 15, 3, 3, 5, 5, 0, 2001991, 15, 2, 3, 7, 5, 0, 2338770, 15, 3, 3, 5, 6, 0);
INSERT INTO `$levels` VALUES (51, 1879588, 6, 2, 3, 4, 5, 9, 2137202, 5, 1, 3, 6, 5, 13, 2487152, 5, 1, 3, 4, 6, 13);
INSERT INTO `$levels` VALUES (52, 2006348, 7, 2, 3, 5, 6, 0, 2272413, 6, 1, 3, 7, 6, 0, 2635534, 6, 2, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (53, 2133108, 8, 2, 3, 6, 7, 0, 2407624, 7, 1, 3, 8, 7, 0, 2783916, 7, 1, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (54, 2259868, 8, 4, 3, 6, 7, 0, 2542835, 7, 3, 3, 8, 7, 0, 2932298, 7, 4, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (55, 2386628, 7, 4, 3, 5, 6, 0, 2678046, 6, 3, 3, 7, 6, 0, 3080680, 6, 3, 3, 5, 7, 0);
INSERT INTO `$levels` VALUES (56, 2513388, 7, 4, 3, 5, 6, 0, 2813257, 6, 3, 3, 7, 6, 0, 3229062, 6, 4, 3, 5, 7, 9);
INSERT INTO `$levels` VALUES (57, 2640148, 6, 5, 3, 4, 5, 0, 2948468, 6, 4, 3, 6, 5, 0, 3377444, 6, 4, 3, 4, 6, 0);
INSERT INTO `$levels` VALUES (58, 2766908, 5, 5, 3, 3, 4, 0, 3083679, 5, 4, 3, 5, 4, 19, 3525826, 5, 5, 3, 3, 5, 0);
INSERT INTO `$levels` VALUES (59, 2893668, 8, 3, 3, 6, 7, 0, 3218890, 7, 2, 3, 8, 7, 0, 3674208, 7, 2, 3, 6, 8, 0);
INSERT INTO `$levels` VALUES (60, 3020428, 15, 4, 4, 6, 6, 19, 3354101, 15, 3, 4, 8, 6, 0, 3822590, 15, 4, 4, 6, 7, 15);
INSERT INTO `$levels` VALUES (61, 3147188, 8, 5, 4, 6, 7, 0, 3489312, 7, 4, 4, 8, 7, 0, 3970972, 7, 4, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (62, 3273948, 8, 4, 4, 6, 7, 0, 3624523, 7, 3, 4, 8, 7, 0, 4119354, 7, 4, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (63, 3400708, 9, 5, 4, 7, 8, 0, 3759734, 8, 4, 4, 9, 8, 0, 4267736, 8, 4, 4, 7, 9, 0);
INSERT INTO `$levels` VALUES (64, 3527468, 5, 5, 4, 3, 4, 0, 3894945, 5, 4, 4, 5, 4, 0, 4416118, 5, 5, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (65, 3654228, 6, 4, 4, 4, 5, 0, 4030156, 6, 3, 4, 6, 5, 0, 4564500, 6, 3, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (66, 3780988, 8, 4, 4, 6, 7, 0, 4165367, 8, 3, 4, 8, 7, 0, 4712882, 8, 4, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (67, 3907748, 7, 3, 4, 5, 6, 0, 4300578, 7, 2, 4, 7, 6, 0, 4861264, 7, 2, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (68, 4034508, 9, 3, 4, 7, 8, 0, 4435789, 8, 2, 4, 9, 8, 0, 5009646, 8, 3, 4, 7, 9, 0);
INSERT INTO `$levels` VALUES (69, 4161268, 5, 4, 4, 3, 4, 0, 4571000, 5, 3, 4, 5, 4, 0, 5158028, 5, 3, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (70, 4288028, 20, 4, 4, 6, 6, 5, 4706211, 20, 3, 4, 8, 6, 16, 5306410, 20, 4, 4, 6, 7, 0);
INSERT INTO `$levels` VALUES (71, 4414788, 5, 5, 4, 3, 4, 0, 4841422, 5, 4, 4, 5, 4, 0, 5454792, 5, 4, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (72, 4541548, 6, 2, 4, 4, 5, 0, 4976633, 5, 1, 4, 6, 5, 0, 5603174, 5, 2, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (73, 4668308, 8, 4, 4, 6, 7, 0, 5111844, 8, 3, 4, 8, 7, 0, 5751556, 8, 3, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (74, 4795068, 7, 5, 4, 5, 6, 0, 5247055, 6, 4, 4, 7, 6, 0, 5899938, 6, 5, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (75, 4921828, 5, 3, 4, 3, 4, 0, 5382266, 5, 2, 4, 5, 4, 0, 6048320, 5, 2, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (76, 5048588, 6, 3, 4, 4, 5, 0, 5517477, 6, 2, 4, 6, 5, 0, 6196702, 6, 3, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (77, 5175348, 6, 4, 4, 4, 5, 0, 5652688, 7, 3, 4, 6, 5, 0, 6345084, 7, 3, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (78, 5302108, 7, 4, 4, 5, 6, 0, 5787899, 7, 3, 4, 7, 6, 0, 6493466, 7, 4, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (79, 5428868, 8, 4, 4, 6, 7, 10, 5923110, 7, 3, 4, 8, 7, 0, 6641848, 7, 3, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (80, 5555628, 20, 5, 4, 6, 7, 0, 6058321, 20, 4, 4, 8, 7, 0, 6790230, 20, 5, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (81, 5682388, 7, 3, 4, 5, 6, 0, 6193532, 7, 2, 4, 7, 6, 0, 6938612, 7, 2, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (82, 5809148, 6, 4, 4, 4, 5, 0, 6328743, 5, 3, 4, 6, 5, 0, 7086994, 5, 4, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (83, 5935908, 6, 2, 4, 4, 5, 0, 6463954, 6, 1, 4, 6, 5, 0, 7235376, 6, 1, 4, 4, 6, 0);
INSERT INTO `$levels` VALUES (84, 6062668, 5, 4, 4, 3, 4, 0, 6599165, 5, 3, 4, 5, 4, 0, 7383758, 5, 4, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (85, 6189428, 7, 4, 4, 5, 6, 0, 6734376, 6, 3, 4, 7, 6, 0, 7532140, 6, 3, 4, 5, 7, 0);
INSERT INTO `$levels` VALUES (86, 6316188, 8, 5, 4, 6, 7, 0, 6869587, 8, 4, 4, 8, 7, 0, 7680522, 8, 5, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (87, 6442948, 8, 4, 4, 6, 7, 0, 7004798, 7, 3, 4, 8, 7, 0, 7828904, 7, 3, 4, 6, 8, 0);
INSERT INTO `$levels` VALUES (88, 6569708, 9, 5, 4, 7, 8, 0, 7140009, 8, 4, 4, 9, 8, 0, 7977286, 8, 5, 4, 7, 9, 0);
INSERT INTO `$levels` VALUES (89, 6696468, 5, 2, 4, 3, 4, 0, 7275220, 5, 1, 4, 5, 4, 0, 8125668, 5, 1, 4, 3, 5, 0);
INSERT INTO `$levels` VALUES (90, 6823228, 20, 2, 5, 7, 8, 0, 7410431, 20, 1, 5, 9, 8, 0, 8274050, 20, 2, 5, 7, 9, 0);
INSERT INTO `$levels` VALUES (91, 6949988, 5, 3, 5, 3, 4, 0, 7545642, 5, 2, 5, 5, 4, 0, 8422432, 5, 2, 5, 3, 5, 0);
INSERT INTO `$levels` VALUES (92, 7076748, 6, 3, 5, 4, 5, 0, 7680853, 4, 2, 5, 6, 5, 0, 8570814, 4, 3, 5, 4, 6, 0);
INSERT INTO `$levels` VALUES (93, 7203508, 8, 4, 5, 6, 7, 0, 7816064, 6, 2, 5, 8, 7, 0, 8719196, 6, 2, 5, 6, 8, 0);
INSERT INTO `$levels` VALUES (94, 7330268, 4, 4, 5, 3, 3, 0, 7951275, 4, 3, 5, 5, 3, 0, 8867578, 4, 4, 5, 3, 4, 0);
INSERT INTO `$levels` VALUES (95, 7457028, 3, 3, 5, 5, 2, 0, 8086486, 4, 2, 5, 7, 2, 0, 9015960, 4, 2, 5, 5, 3, 0);
INSERT INTO `$levels` VALUES (96, 7583788, 5, 3, 5, 4, 3, 0, 8221697, 5, 2, 5, 7, 3, 0, 9164342, 5, 3, 5, 4, 4, 0);
INSERT INTO `$levels` VALUES (97, 7710548, 5, 4, 5, 4, 5, 0, 8356908, 5, 3, 5, 7, 5, 0, 9312724, 5, 3, 5, 4, 6, 0);
INSERT INTO `$levels` VALUES (98, 7837308, 4, 5, 5, 4, 3, 0, 8492119, 4, 3, 5, 7, 3, 0, 9461106, 4, 4, 5, 4, 4, 0);
INSERT INTO `$levels` VALUES (99, 7964068, 15, 5, 5, 6, 5, 0, 8627330, 17, 3, 5, 9, 5, 0, 9609488, 20, 4, 5, 6, 6, 0);
INSERT INTO `$levels` VALUES (100, 8090828, 50, 20, 20, 9, 11, 0, 8762541, 70, 15, 20, 14, 11, 0, 9757870, 100, 30, 30, 19, 16, 0);
END;
if (dobatch($query) == 1) { $page .= "Las tablas de niveles se llenaron.<br />"; } else { $page .= "Error al llenar las tablas de niveles."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$monsters` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `maxhp` smallint(5) unsigned NOT NULL default '0',
  `maxdam` smallint(5) unsigned NOT NULL default '0',
  `armor` smallint(5) unsigned NOT NULL default '0',
  `nivel` smallint(5) unsigned NOT NULL default '0',
  `maxexp` smallint(5) unsigned NOT NULL default '0',
  `maxgold` smallint(5) unsigned NOT NULL default '0',
  `immune` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas de monstruos se crearon.<br />"; } else { $page .= "Error al llenar las tablas de monstruos."; }
unset($query);

if ($full == false) {
$query = <<<END
INSERT INTO `$monsters` VALUES (1, 'Baba Azul', 4, 3, 1, 1, 1, 1, 0);
INSERT INTO `$monsters` VALUES (2, 'Baba Roja', 6, 5, 1, 1, 2, 1, 0);
INSERT INTO `$monsters` VALUES (3, 'Critter', 6, 5, 2, 1, 4, 2, 0);
INSERT INTO `$monsters` VALUES (4, 'Creatura', 10, 8, 2, 2, 4, 2, 0);
INSERT INTO `$monsters` VALUES (5, 'Sombra', 10, 9, 3, 2, 6, 2, 1);
INSERT INTO `$monsters` VALUES (6, 'Drake', 11, 10, 3, 2, 8, 3, 0);
INSERT INTO `$monsters` VALUES (7, 'Shade', 12, 10, 3, 3, 10, 3, 1);
INSERT INTO `$monsters` VALUES (8, 'Drakelor', 14, 12, 4, 3, 10, 3, 0);
INSERT INTO `$monsters` VALUES (9, 'Baba de Plata', 15, 100, 200, 30, 15, 1000, 2);
INSERT INTO `$monsters` VALUES (10, 'Scamp', 16, 13, 5, 4, 15, 5, 0);
INSERT INTO `$monsters` VALUES (11, 'Cuervo', 16, 13, 5, 4, 18, 6, 0);
INSERT INTO `$monsters` VALUES (12, 'Escorpion', 18, 14, 6, 5, 20, 7, 0);
INSERT INTO `$monsters` VALUES (13, 'Ilusion', 20, 15, 6, 5, 20, 7, 1);
INSERT INTO `$monsters` VALUES (14, 'Sombra Nocturna', 22, 16, 6, 6, 24, 8, 0);
INSERT INTO `$monsters` VALUES (15, 'Drakemal', 22, 18, 7, 6, 24, 8, 0);
INSERT INTO `$monsters` VALUES (16, 'Cuervo de la Sombra', 24, 18, 7, 6, 26, 9, 1);
INSERT INTO `$monsters` VALUES (17, 'Fantasma', 24, 20, 8, 6, 28, 9, 0);
INSERT INTO `$monsters` VALUES (18, 'Cuervo de Hielo', 26, 20, 8, 7, 30, 10, 0);
INSERT INTO `$monsters` VALUES (19, 'Escorpion Silencioso', 28, 22, 9, 7, 32, 11, 0);
INSERT INTO `$monsters` VALUES (20, 'Zombie', 29, 24, 9, 7, 34, 11, 0);
INSERT INTO `$monsters` VALUES (21, 'Mago', 30, 24, 10, 8, 36, 12, 0);
INSERT INTO `$monsters` VALUES (22, 'Pícaro', 30, 25, 12, 8, 40, 13, 0);
INSERT INTO `$monsters` VALUES (23, 'Drakefin', 32, 26, 12, 8, 40, 13, 0);
INSERT INTO `$monsters` VALUES (24, 'Reflejo', 32, 26, 14, 8, 45, 15, 1);
INSERT INTO `$monsters` VALUES (25, 'Cuervo de Fuego', 34, 28, 14, 9, 45, 15, 0);
INSERT INTO `$monsters` VALUES (26, 'Dybbuk', 34, 28, 14, 9, 50, 17, 0);
INSERT INTO `$monsters` VALUES (27, 'Knave', 36, 30, 15, 9, 52, 17, 0);
INSERT INTO `$monsters` VALUES (28, 'Duende', 36, 30, 15, 10, 54, 18, 0);
INSERT INTO `$monsters` VALUES (29, 'Esqueleto', 38, 30, 18, 10, 58, 19, 0);
INSERT INTO `$monsters` VALUES (30, 'Baba de Oscuridad', 38, 32, 18, 10, 62, 21, 0);
INSERT INTO `$monsters` VALUES (31, 'Escorpion de Plata', 30, 160, 350, 40, 63, 2000, 2);
INSERT INTO `$monsters` VALUES (32, 'Espejo', 40, 32, 20, 11, 64, 21, 1);
INSERT INTO `$monsters` VALUES (33, 'Hechizero', 41, 33, 22, 11, 68, 23, 0);
INSERT INTO `$monsters` VALUES (34, 'Imp', 42, 34, 22, 12, 70, 23, 0);
INSERT INTO `$monsters` VALUES (35, 'Ninfa', 43, 35, 22, 12, 70, 23, 0);
INSERT INTO `$monsters` VALUES (36, 'Sinvergüenza', 43, 35, 22, 12, 75, 25, 0);
INSERT INTO `$monsters` VALUES (37, 'Megaesqueleto', 44, 36, 24, 13, 78, 26, 0);
INSERT INTO `$monsters` VALUES (38, 'Lobo Gris', 44, 36, 24, 13, 82, 27, 0);
INSERT INTO `$monsters` VALUES (39, 'Phantom', 46, 38, 24, 14, 85, 28, 1);
INSERT INTO `$monsters` VALUES (40, 'Espectro', 46, 38, 24, 14, 90, 30, 0);
INSERT INTO `$monsters` VALUES (41, 'Escorpion Oscuro', 48, 40, 26, 15, 95, 32, 1);
INSERT INTO `$monsters` VALUES (42, 'Warlock', 48, 40, 26, 15, 100, 33, 1);
INSERT INTO `$monsters` VALUES (43, 'Orco', 49, 42, 28, 15, 104, 35, 0);
INSERT INTO `$monsters` VALUES (44, 'Silfo', 49, 42, 28, 15, 106, 35, 0);
INSERT INTO `$monsters` VALUES (45, 'Wraith', 50, 45, 30, 16, 108, 36, 0);
INSERT INTO `$monsters` VALUES (46, 'Hellion', 50, 45, 30, 16, 110, 37, 0);
INSERT INTO `$monsters` VALUES (47, 'Bandito', 52, 45, 30, 16, 114, 38, 0);
INSERT INTO `$monsters` VALUES (48, 'Ultraesqueleto', 52, 46, 32, 16, 116, 39, 0);
INSERT INTO `$monsters` VALUES (49, 'Lobo Oscuro', 54, 47, 36, 17, 120, 40, 1);
INSERT INTO `$monsters` VALUES (50, 'Troll', 56, 48, 36, 17, 120, 40, 0);
INSERT INTO `$monsters` VALUES (51, 'Hombre Lobo', 56, 48, 38, 17, 124, 41, 0);
INSERT INTO `$monsters` VALUES (52, 'Gato del Infierno', 58, 50, 38, 18, 128, 43, 0);
INSERT INTO `$monsters` VALUES (53, 'Espiritu', 58, 50, 38, 18, 132, 44, 0);
INSERT INTO `$monsters` VALUES (54, 'Nisse', 60, 52, 40, 19, 132, 44, 0);
INSERT INTO `$monsters` VALUES (55, 'Dawk', 60, 54, 40, 19, 136, 45, 0);
INSERT INTO `$monsters` VALUES (56, 'Figment', 64, 55, 42, 19, 140, 47, 1);
INSERT INTO `$monsters` VALUES (57, 'Cazador del Infierno', 66, 56, 44, 20, 140, 47, 0);
INSERT INTO `$monsters` VALUES (58, 'Mago Oscuro', 66, 56, 44, 20, 144, 48, 0);
INSERT INTO `$monsters` VALUES (59, 'Uruk', 68, 58, 44, 20, 146, 49, 0);
INSERT INTO `$monsters` VALUES (60, 'Sirena Maldita', 68, 400, 800, 50, 10000, 50, 2);
INSERT INTO `$monsters` VALUES (61, 'Megawraith', 70, 60, 46, 21, 155, 52, 0);
INSERT INTO `$monsters` VALUES (62, 'Dawkin', 70, 60, 46, 21, 155, 52, 0);
INSERT INTO `$monsters` VALUES (63, 'Oso Gris', 70, 62, 48, 21, 160, 53, 0);
INSERT INTO `$monsters` VALUES (64, 'Haunt', 72, 62, 48, 22, 160, 53, 0);
INSERT INTO `$monsters` VALUES (65, 'Bestia del Infierno', 74, 64, 50, 22, 165, 55, 0);
INSERT INTO `$monsters` VALUES (66, 'Miedo', 76, 66, 52, 23, 165, 55, 0);
INSERT INTO `$monsters` VALUES (67, 'Bestia', 76, 66, 52, 23, 170, 57, 0);
INSERT INTO `$monsters` VALUES (68, 'Ogro', 78, 68, 54, 23, 170, 57, 0);
INSERT INTO `$monsters` VALUES (69, 'Oso Oscuro', 80, 70, 56, 24, 175, 58, 1);
INSERT INTO `$monsters` VALUES (70, 'Fuego', 80, 72, 56, 24, 175, 58, 0);
INSERT INTO `$monsters` VALUES (71, 'Polgergeist', 84, 74, 58, 25, 180, 60, 0);
INSERT INTO `$monsters` VALUES (72, 'Fright', 86, 76, 58, 25, 180, 60, 0);
INSERT INTO `$monsters` VALUES (73, 'Licantropo', 88, 78, 60, 25, 185, 62, 0);
INSERT INTO `$monsters` VALUES (74, 'Terra Elemental', 88, 80, 62, 25, 185, 62, 1);
INSERT INTO `$monsters` VALUES (75, 'Necromancer', 90, 80, 62, 26, 190, 63, 0);
INSERT INTO `$monsters` VALUES (76, 'Ultrawraith', 90, 82, 64, 26, 190, 63, 0);
INSERT INTO `$monsters` VALUES (77, 'Dawkor', 92, 82, 64, 26, 195, 65, 0);
INSERT INTO `$monsters` VALUES (78, 'Hombre Oso', 92, 84, 65, 26, 195, 65, 0);
INSERT INTO `$monsters` VALUES (79, 'Bruto', 94, 84, 65, 27, 200, 67, 0);
INSERT INTO `$monsters` VALUES (80, 'Gran Bestia', 96, 88, 66, 27, 200, 67, 0);
INSERT INTO `$monsters` VALUES (81, 'Horror', 96, 88, 68, 27, 210, 70, 0);
INSERT INTO `$monsters` VALUES (82, 'Flama', 100, 90, 70, 28, 210, 70, 0);
INSERT INTO `$monsters` VALUES (83, 'Señor Licantropo', 100, 90, 70, 28, 210, 70, 0);
INSERT INTO `$monsters` VALUES (84, 'Wyrm', 100, 92, 72, 28, 220, 73, 0);
INSERT INTO `$monsters` VALUES (85, 'Aero Elemental', 104, 94, 74, 29, 220, 73, 1);
INSERT INTO `$monsters` VALUES (86, 'Dawkare', 106, 96, 76, 29, 220, 73, 0);
INSERT INTO `$monsters` VALUES (87, 'Gran Bruto', 108, 98, 78, 29, 230, 77, 0);
INSERT INTO `$monsters` VALUES (88, 'Wyrm de Hielo', 110, 100, 80, 30, 230, 77, 0);
INSERT INTO `$monsters` VALUES (89, 'Caballero', 110, 102, 80, 30, 240, 80, 0);
INSERT INTO `$monsters` VALUES (90, 'Rey Licantropo', 112, 104, 82, 30, 240, 80, 0);
INSERT INTO `$monsters` VALUES (91, 'Terror', 115, 108, 84, 31, 250, 83, 0);
INSERT INTO `$monsters` VALUES (92, 'Blaze', 118, 108, 84, 31, 250, 83, 0);
INSERT INTO `$monsters` VALUES (93, 'Aqua Elemental', 120, 110, 90, 31, 260, 87, 1);
INSERT INTO `$monsters` VALUES (94, 'Wyrm de Fuego', 120, 110, 90, 32, 260, 87, 0);
INSERT INTO `$monsters` VALUES (95, 'Wyvern Deforme', 122, 110, 92, 32, 270, 90, 0);
INSERT INTO `$monsters` VALUES (96, 'Apocaliptico', 124, 112, 92, 32, 270, 90, 0);
INSERT INTO `$monsters` VALUES (97, 'Caballero Armado', 130, 115, 95, 33, 280, 93, 0);
INSERT INTO `$monsters` VALUES (98, 'Wyvern', 134, 120, 95, 33, 290, 97, 0);
INSERT INTO `$monsters` VALUES (99, 'Pesadilla', 138, 125, 100, 33, 300, 100, 0);
INSERT INTO `$monsters` VALUES (100, 'Fira Elemental', 140, 125, 100, 34, 310, 103, 1);
INSERT INTO `$monsters` VALUES (101, 'Mega Apocaliptico', 140, 128, 105, 34, 320, 107, 0);
INSERT INTO `$monsters` VALUES (102, 'Wyvern Gigante', 145, 130, 105, 34, 335, 112, 0);
INSERT INTO `$monsters` VALUES (103, 'Advocate', 148, 132, 108, 35, 350, 117, 0);
INSERT INTO `$monsters` VALUES (104, 'Caballero Gigante', 150, 135, 110, 35, 365, 122, 0);
INSERT INTO `$monsters` VALUES (105, 'Liche', 150, 135, 110, 35, 380, 127, 0);
INSERT INTO `$monsters` VALUES (106, 'Ultra Apocaliptico', 155, 140, 115, 36, 395, 132, 0);
INSERT INTO `$monsters` VALUES (107, 'Fanatic', 160, 140, 115, 36, 410, 137, 0);
INSERT INTO `$monsters` VALUES (108, 'Dragon Verde', 160, 140, 115, 36, 425, 142, 0);
INSERT INTO `$monsters` VALUES (109, 'Demonio', 160, 145, 120, 37, 445, 148, 0);
INSERT INTO `$monsters` VALUES (110, 'Wyvern Ultragigante', 162, 150, 120, 37, 465, 155, 0);
INSERT INTO `$monsters` VALUES (111, 'Lesser Devil', 164, 150, 120, 37, 485, 162, 0);
INSERT INTO `$monsters` VALUES (112, 'Maestro Liche', 168, 155, 125, 38, 505, 168, 0);
INSERT INTO `$monsters` VALUES (113, 'Zealot', 168, 155, 125, 38, 530, 177, 0);
INSERT INTO `$monsters` VALUES (114, 'Serademonio', 170, 155, 125, 38, 555, 185, 0);
INSERT INTO `$monsters` VALUES (115, 'Caballero Paladin del Infierno', 175, 160, 130, 39, 580, 193, 0);
INSERT INTO `$monsters` VALUES (116, 'Dragon Azul', 180, 160, 130, 39, 605, 202, 0);
INSERT INTO `$monsters` VALUES (117, 'Obsesivo', 180, 160, 135, 40, 630, 210, 0);
INSERT INTO `$monsters` VALUES (118, 'Demonio Maldito', 184, 164, 135, 40, 666, 222, 0);
INSERT INTO `$monsters` VALUES (119, 'Principe Liche', 190, 168, 138, 40, 660, 220, 0);
INSERT INTO `$monsters` VALUES (120, 'Cherudemonio', 195, 170, 140, 41, 690, 230, 0);
INSERT INTO `$monsters` VALUES (121, 'Dragon Rojo', 200, 180, 145, 41, 720, 240, 0);
INSERT INTO `$monsters` VALUES (122, 'Demonio Maldito Grande', 200, 180, 145, 41, 750, 250, 0);
INSERT INTO `$monsters` VALUES (123, 'Renegado', 205, 185, 150, 42, 780, 260, 0);
INSERT INTO `$monsters` VALUES (124, 'Archidemonio', 210, 190, 150, 42, 810, 270, 0);
INSERT INTO `$monsters` VALUES (125, 'Señor Liche', 210, 190, 155, 42, 850, 283, 0);
INSERT INTO `$monsters` VALUES (126, 'Demonio Maldito Gigante', 215, 195, 160, 43, 890, 297, 0);
INSERT INTO `$monsters` VALUES (127, 'Caballero Oscuro', 220, 200, 160, 43, 930, 310, 0);
INSERT INTO `$monsters` VALUES (128, 'Gigante', 220, 200, 165, 43, 970, 323, 0);
INSERT INTO `$monsters` VALUES (129, 'Dragon de las Sombras', 225, 200, 170, 44, 1010, 337, 0);
INSERT INTO `$monsters` VALUES (130, 'Rey Liche', 225, 205, 170, 44, 1050, 350, 0);
INSERT INTO `$monsters` VALUES (131, 'Incubus', 230, 205, 175, 44, 1100, 367, 1);
INSERT INTO `$monsters` VALUES (132, 'Traidor', 230, 205, 175, 45, 1150, 383, 0);
INSERT INTO `$monsters` VALUES (133, 'Demonio de la Muerte', 240, 210, 180, 45, 1200, 400, 0);
INSERT INTO `$monsters` VALUES (134, 'Dragon Oscuro', 245, 215, 180, 45, 1250, 417, 1);
INSERT INTO `$monsters` VALUES (135, 'Insurgente', 250, 220, 190, 46, 1300, 433, 0);
INSERT INTO `$monsters` VALUES (136, 'Leviathan', 255, 225, 190, 46, 1350, 450, 0);
INSERT INTO `$monsters` VALUES (137, 'Daemon Gris', 260, 230, 190, 46, 1400, 467, 0);
INSERT INTO `$monsters` VALUES (138, 'Succubus', 265, 240, 200, 47, 1460, 487, 1);
INSERT INTO `$monsters` VALUES (139, 'Principe Demonio', 270, 240, 200, 47, 1520, 507, 0);
INSERT INTO `$monsters` VALUES (140, 'Dragon Negro', 275, 250, 205, 47, 1580, 527, 1);
INSERT INTO `$monsters` VALUES (141, 'Nihilista', 280, 250, 205, 47, 1640, 547, 0);
INSERT INTO `$monsters` VALUES (142, 'Behemoth', 285, 260, 210, 48, 1700, 567, 0);
INSERT INTO `$monsters` VALUES (143, 'Demagogo', 290, 260, 210, 48, 1760, 587, 0);
INSERT INTO `$monsters` VALUES (144, 'Señor Demonio', 300, 270, 220, 48, 1820, 607, 0);
INSERT INTO `$monsters` VALUES (145, 'Daemon Rojo', 310, 280, 230, 48, 1880, 627, 0);
INSERT INTO `$monsters` VALUES (146, 'Coloso', 320, 300, 240, 49, 1940, 647, 0);
INSERT INTO `$monsters` VALUES (147, 'Rey Demonio', 330, 300, 250, 49, 2000, 667, 0);
INSERT INTO `$monsters` VALUES (148, 'Daemon Oscuro', 340, 320, 260, 49, 2200, 733, 1);
INSERT INTO `$monsters` VALUES (149, 'Titan', 360, 340, 270, 50, 2400, 800, 0);
INSERT INTO `$monsters` VALUES (150, 'Daemon Negro', 400, 400, 280, 50, 3000, 1000, 1);
END;
if (dobatch($query) == 1) { $page .= "Las tablas de monstruos han sido llenadas.<br />"; } else { $page .= "Error al llenar las tablas de monstruos."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$news` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `postdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Tablas de noticias creadas.<br />"; } else { $page .= "Error al crear las tablas de noticias."; }
unset($query);

$query = <<<END
INSERT INTO `$news` VALUES (1, '2009-01-01 12:00:00', 'Gracias por utilizar SouL Adventure. Para borrar esta noticia debes ingresar una nueva en el panel de Administración.');
END;
if (dobatch($query) == 1) { $page .= "Tablas de Noticias llenadas.<br />"; } else { $page .= "Error al llenar las tablas de noticias."; }
unset($query);

$query = <<<END
CREATE TABLE `$spells` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `mp` smallint(5) unsigned NOT NULL default '0',
  `attribute` smallint(5) unsigned NOT NULL default '0',
  `type` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas de habilidades han sido creadas.<br />"; } else { $page .= "Error al crear las tablas de habilidades."; }
unset($query);

if ($full == false) {
$query = <<<END
INSERT INTO `$spells` VALUES (1, 'Curar', 5, 10, 1);
INSERT INTO `$spells` VALUES (2, 'Revivir', 10, 25, 1);
INSERT INTO `$spells` VALUES (3, 'Vida', 25, 50, 1);
INSERT INTO `$spells` VALUES (4, 'Aliento', 50, 100, 1);
INSERT INTO `$spells` VALUES (5, 'Gaia', 75, 150, 1);
INSERT INTO `$spells` VALUES (6, 'Daño', 5, 15, 2);
INSERT INTO `$spells` VALUES (7, 'Dolor', 12, 35, 2);
INSERT INTO `$spells` VALUES (8, 'Mutilar', 25, 70, 2);
INSERT INTO `$spells` VALUES (9, 'Deformar', 40, 100, 2);
INSERT INTO `$spells` VALUES (10, 'Caos', 50, 130, 2);
INSERT INTO `$spells` VALUES (11, 'Dormir', 10, 5, 3);
INSERT INTO `$spells` VALUES (12, 'Sueño', 30, 9, 3);
INSERT INTO `$spells` VALUES (13, 'Pesadilla', 60, 13, 3);
INSERT INTO `$spells` VALUES (14, 'Locura', 10, 10, 4);
INSERT INTO `$spells` VALUES (15, 'Ira', 20, 25, 4);
INSERT INTO `$spells` VALUES (16, 'Furia', 30, 50, 4);
INSERT INTO `$spells` VALUES (17, 'Ward', 10, 10, 5);
INSERT INTO `$spells` VALUES (18, 'Fend', 20, 25, 5);
INSERT INTO `$spells` VALUES (19, 'Barrera', 30, 50, 5);
END;
if (dobatch($query) == 1) { $page .= "Las tablas de habilidad fueron llenadas.<br />"; } else { $page .= "Error al llenar las tablas de habilidad."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$towns` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `latitude` smallint(6) NOT NULL default '0',
  `longitude` smallint(6) NOT NULL default '0',
  `innprice` tinyint(4) NOT NULL default '0',
  `mapprice` smallint(6) NOT NULL default '0',
  `travelpoints` smallint(5) unsigned NOT NULL default '0',
  `itemslist` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas de ciudades fueron creadas.<br />"; } else { $page .= "Error al crear las tablas de ciudades."; }
unset($query);

if ($full == false) {
$query = <<<END
INSERT INTO `$towns` VALUES (1, 'Klamhin', 0, 0, 5, 0, 0, '1,2,3,17,18,19,28,29');
INSERT INTO `$towns` VALUES (2, 'Pilium', 30, 30, 10, 25, 5, '2,3,4,18,19,29');
INSERT INTO `$towns` VALUES (3, 'Lumita', 70, -70, 25, 50, 15, '2,3,4,5,18,19,20,29.30');
INSERT INTO `$towns` VALUES (4, 'Kalle', -100, 100, 40, 100, 30, '5,6,8,10,12,21,22,23,29,30');
INSERT INTO `$towns` VALUES (5, 'Narcissa', -130, -130, 60, 500, 50, '4,7,9,11,13,21,22,23,29,30,31');
INSERT INTO `$towns` VALUES (6, 'Yaelon', 170, 170, 90, 1000, 80, '10,11,12,13,14,23,24,30,31');
INSERT INTO `$towns` VALUES (7, 'Gilead', 200, -200, 100, 3000, 110, '12,13,14,15,24,25,26,32');
INSERT INTO `$towns` VALUES (8, 'Auckland', -250, -250, 125, 9000, 160, '16,27,33');
END;
if (dobatch($query) == 1) { $page .= "Las tablas de ciudades fueron llenadas.<br />"; } else { $page .= "Error al llenar las tablas de ciudades."; }
unset($query);
}

$query = <<<END
CREATE TABLE `$users` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `usuario` varchar(30) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `verify` varchar(8) NOT NULL default '0',
  `charname` varchar(30) NOT NULL default '',
  `charrace` varchar(30) NOT NULL default '',
  `regdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `onlinetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `autorizacion` tinyint(3) unsigned NOT NULL default '0',
  `nivelpvp` mediumint(9) DEFAULT '1' NOT NULL,
  `latitude` smallint(6) NOT NULL default '0',
  `longitude` smallint(6) NOT NULL default '0',
  `difficulty` tinyint(3) unsigned NOT NULL default '0',
  `charclass` tinyint(4) unsigned NOT NULL default '0',
  `currentaction` varchar(30) NOT NULL default 'En la ciudad',
  `currentfight` tinyint(4) unsigned NOT NULL default '0',
  `currentmonster` smallint(6) unsigned NOT NULL default '0',
  `currentmonsterhp` smallint(6) unsigned NOT NULL default '0',
  `currentmonstersleep` tinyint(3) unsigned NOT NULL default '0',
  `currentmonsterimmune` tinyint(4) NOT NULL default '0',
  `currentuberdamage` tinyint(3) unsigned NOT NULL default '0',
  `currentuberdefense` tinyint(3) unsigned NOT NULL default '0',
  `currenthp` smallint(6) unsigned NOT NULL default '15',
  `currentmp` smallint(6) unsigned NOT NULL default '0',
  `currenttp` smallint(6) unsigned NOT NULL default '10',
  `maxhp` smallint(6) unsigned NOT NULL default '15',
  `maxmp` smallint(6) unsigned NOT NULL default '0',
  `maxtp` smallint(6) unsigned NOT NULL default '10',
  `nivel` smallint(5) unsigned NOT NULL default '1',
  `gold` mediumint(8) unsigned NOT NULL default '100',
  `experience` mediumint(8) unsigned NOT NULL default '0',
  `goldbonus` smallint(5) NOT NULL default '0',
  `expbonus` smallint(5) NOT NULL default '0',
  `strength` smallint(5) unsigned NOT NULL default '5',
  `dexterity` smallint(5) unsigned NOT NULL default '5',
  `attackpower` smallint(5) unsigned NOT NULL default '5',
  `defensepower` smallint(5) unsigned NOT NULL default '5',
  `weaponid` smallint(5) unsigned NOT NULL default '0',
  `armorid` smallint(5) unsigned NOT NULL default '0',
  `shieldid` smallint(5) unsigned NOT NULL default '0',
  `slot1id` smallint(5) unsigned NOT NULL default '0',
  `slot2id` smallint(5) unsigned NOT NULL default '0',
  `slot3id` smallint(5) unsigned NOT NULL default '0',
  `weaponname` varchar(30) NOT NULL default 'None',
  `armorname` varchar(30) NOT NULL default 'None',
  `shieldname` varchar(30) NOT NULL default 'None',
  `slot1name` varchar(30) NOT NULL default 'None',
  `slot2name` varchar(30) NOT NULL default 'None',
  `slot3name` varchar(30) NOT NULL default 'None',
  `dropcode` mediumint(8) unsigned NOT NULL default '0',
  `spells` varchar(50) NOT NULL default '0',
  `towns` varchar(50) NOT NULL default '0',
  `customtitle` varchar(50),
  `postcount`  smallint(4) default '0',
  `chattime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nombreclan` VARCHAR( 50 ) NULL DEFAULT NULL,
  `banco` bigint(50) unsigned NOT NULL DEFAULT '0',
  `ip` VARCHAR( 16 ) NOT NULL default '000',
  `pvpganados` int(4) NOT NULL default '0',
  `pvpempatados` int(4) NOT NULL default '0',
  `pvpperdidos` int(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
END;
if (dobatch($query) == 1) { $page .= "Las tablas de usuarios fueron llenadas.<br />"; } else { $page .= "Error al llenar las tablas de usuarios."; }
unset($query);
    
    global $start;
    $time = round((getmicrotime() - $start), 4);
    $page .= "<br />La instalación de la base de datos fue completada en $time segundos.<br /><br /><form action=\"instalar.php?page=administracion\" method='post'><input type='submit' value='Continuar' class='boton'></form></div></body></html>";
    echo $page;
	die();
    
}

function administracion() { // Tercera Página.
$page= "<html><head><title>Instalaci&oacute;n de Soul Adventure</title><link href='estilo/css/instalar.css' rel='stylesheet' type='text/css' /></head><body>";

$page .= '<div class="contenido"><div class="titulo">Creaci&oacute;n de la cuenta de administrador</div>
Ahora debes crear la cuenta de administración. Con esta cuenta podrás entrar al panel de administración y también podrás jugar tu juego. Completa el siguiente formulario, algunos valores los podras modificar en el panel de administración.<br /><br />
<form action="instalar.php?page=cuentacreada" method="post">
<table width="50%">
<tr><td width="20%" style="vertical-align:top;">Usuario:</td><td><input type="text" name="usuario" size="30" maxlength="30" /><br /><br /><br /></td></tr>
<tr><td style="vertical-align:top;">Contraseña:</td><td><input type="password" name="password1" size="30" maxlength="30" /></td></tr>
<tr><td style="vertical-align:top;">Verificar Contraseña:</td><td><input type="password" name="password2" size="30" maxlength="30" /><br /><br /><br /></td></tr>
<tr><td style="vertical-align:top;">E-mail:</td><td><input type="text" name="email1" size="30" maxlength="100" /></td></tr>
<tr><td style="vertical-align:top;">Verificar E-mail:</td><td><input type="text" name="email2" size="30" maxlength="100" /><br /><br /><br /></td></tr>
<tr><td style="vertical-align:top;">Nombre del Personaje:</td><td><input type="text" name="charname" size="30" maxlength="30" /></td></tr>
<tr><td>Raza:</td><td><select name="charrace"><option value="1">Humano</option><option value="2">Elfo</option><option value="3">Enano</option><option value="4">Dark</option><option value="5">Orco</option></select></td></tr>
<tr><td>Clase:</td><td><select name="charclass"><option value="1">Mago</option><option value="2">Guerrero</option><option value="3">Paladin</option></select><br />La clase de su personaje definirá sus habilidades.</td></tr>
<tr><td style="vertical-align:top;">Dificultad:</td><td><select name="difficulty"><option value="1">Facil</option><option value="2">Medio</option><option value="3">Dificil</option></select></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Registrarme" class="boton"/> <input type="reset" name="reset" value="Reiniciar" class="boton"/></td></tr>
</table>
</div>
</form>
</body>
</html>';

echo $page;
die();

}

function cuentacreada() { // Cuarta Página
    $link = opendb();
    extract($_POST);
    if (!isset($usuario)) { die("Se requiere usuario."); }
    if (!isset($password1)) { die("Se requiere contraseña."); }
    if (!isset($password2)) { die("Se requiere verificar contraseña."); }
    if ($password1 != $password2) { die("Las contraseñas no concuerdan."); }
    if (!isset($email1)) { die("Se requiere e-mail."); }
    if (!isset($email2)) { die("Se requiere verificar e-mail."); }
    if ($email1 != $email2) { die("Los e-mails no concuerdan."); }
    if (!isset($charname)) { die("Se requiere nombre de usuario."); }
    $password = md5($password1);
    
    global $dbsettings;
    $users = $dbsettings["prefix"] . "_usuarios";
    $query = mysql_query("INSERT INTO $users SET id='1',usuario='$usuario',password='$password',email='$email1',verify='1',charname='$charname',charclass='$charclass',charrace='$charrace',regdate=NOW(),onlinetime=NOW(),autorizacion='1'") or die(mysql_error());
$page= "<html><head><title>Instalaci&oacute;n de Soul Adventure</title><link href='estilo/css/instalar.css' rel='stylesheet' type='text/css' /></head><body>";
$page .= '
<div class="contenido">
<div class="titulo">Instalaci&oacute;n realizada con exito</div>
Tu cuenta ha sido creada satisfactoriamente. La instalaci&oacute;n est&aacute; completa.<br /><br />
Por favor, borre instalar.php para continuar con el juego.<br /><br />
Ahora puedes empezar a <a href="ir.php">jugar</a>. Nota: Si quieres usar el panel de administración, primero debes loguearte como usuario para después llegar al mismo con el link de la barra superior.<br /><br/>
Gracias por usar SouL Adventure!
</div>
</body>
</html>';
    echo $page;
    die();

}
?>                                                                           