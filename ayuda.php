<?php 
#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribuci�n de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para m�s informaci�n: www.soul-adventure.net							#
# *                                                          				#
#############################################################################
include('lib.php'); 
$link = opendb();
$controlquery = doquery("SELECT * FROM {{table}} WHERE id='1' LIMIT 1", "control");
$controlrow = mysql_fetch_array($controlquery);
ob_start("ob_gzhandler");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Ayuda para <? echo $controlrow["gamename"]; ?></title>
<LINK rel="stylesheet" type="text/css" href="estilo/css/ayuda.css">
</head>
<body>
<a name="top"></a>
<h1>Ayuda para <? echo $controlrow["gamename"]; ?></h1>
[ <a href="index.php">Ir al Juego</a> ]

<br /><br /><hr />

<h3>Tabla de Contenidos</h3>
<ul>
<li /><a href="#intro">Introducci�n</a>
<li /><a href="#classes">Clases y Razas del Personaje</a>
<li /><a href="#difficulties">Dificultades</a>
<li /><a href="#intown">Jugando: En la Ciudad</a>
<li /><a href="#exploring">Jugando: Explorando y Peleando</a>
<li /><a href="#status">Jugando: Paneles de Estado</a>
<li /><a href="ayuda_item.php">Otros: Items y Drops</a>
<li /><a href="ayuda_monstruo.php">Otros: Monstruos</a>
<li /><a href="ayuda_habilidad.php">Otros: Hechizos</a>
<li /><a href="ayuda_nivel.php">Otros: Niveles</a>
<li /><a href="#credits">Cr�ditos y Staff</a>
</ul>

<hr />

<h3><a name="intro"></a>Introducci�n</h3>
Al registrarte en este juego pasas a ser un heroe del mundo de <? echo $controlrow["gamename"]; ?> en el cual deberas combatir contra monstruos y tus enemigos, aliate con tus amigos creando vuestro propio clan y dominar el juego!<br /><br /><br />
[ <a href="#top">Volver al Inicio</a> ]

<br /><br /><hr />

<h3><a name="classes"></a>Raza del Personajes</h3>
En <? echo $controlrow["gamename"]; ?> hay 3 clases de personajes dividas en 5 razas. Cada clase tiene unas caracteristicas principales.<br /><br />
<b>Razas</b><br />
<br />
<li /><? echo $controlrow["race1name"]; ?>
<li /><? echo $controlrow["race2name"]; ?>
<li /><? echo $controlrow["race3name"]; ?>
<li /><? echo $controlrow["race4name"]; ?>
<li /><? echo $controlrow["race5name"]; ?><br />
<br />
<b>Clases</b>
<br />
<br />
<? echo $controlrow["class1name"]; ?>
<ul>
<li />Nivelaci�n: Alta
<li />PV: Altos
<li />PM: Altos
<li />Fuerza: Baja
<li />Destreza: Baja
<li />Habilidades de Curaci�n: 5
<li />Habilidades de Da�o: 5
<li />Habilidades de Sue�o: 3
<li />Auras de Defensa: 3
<li />Auras de Ataque: 0
</ul>
<? echo $controlrow["class2name"]; ?>
<ul>
<li />
<li />Nivelaci�n: Media
<li />PM: Bajos
<li />Fuerza: Alta
<li />Destreza: Baja
<li />Habilidades de Curaci�n: 3
<li />Habilidades de Da�o: 3
<li />Habilidades de Sue�o: 2
<li />Auras de Defensa: 3
<li />Auras de Ataque: 3
</ul>
<? echo $controlrow["class3name"]; ?>
<ul>
<li />Nivelaci�n: Baja
<li />PV: Medios
<li />PM: Medios
<li />Fuerza: Baja
<li />Destreza: Alta
<li />Habilidades de Curaci�n: 4
<li />Habilidades de Da�o: 4
<li />Habilidades de Sue�o: 3
<li />Auras de Defensa: 2
<li />Auras de Ataque: 2
</ul>
[ <a href="#top">Volver al Inicio</a> ]

<br /><br /><hr />

<h3><a name="difficulties"></a>Dificultades</h3>
En <? echo $controlrow["gamename"]; ?> podr�s elegir el nivel de dificultad en la que quieras jugar. La dificultad agregar� un duplicador, por cada nivel m�s alto de dificultad elegido, aumentar� el oro y la experiencia recibida, pero tambi�n aumentar� el ataque y la vida del monstruo.<br />
<ul>
<li /><? echo $controlrow["diff1name"] . ": <b>" . $controlrow["diff1mod"] . "</b>"; ?>
<li /><? echo $controlrow["diff2name"] . ": <b>" . $controlrow["diff2mod"] . "</b>"; ?>
<li /><? echo $controlrow["diff3name"] . ": <b>" . $controlrow["diff3mod"] . "</b>"; ?>
</ul>
[ <a href="#top">Volver al Inicio</a> ]

<br /><br /><hr />

<h3><a name="intown"></a>Jugando: En la Ciudad</h3>
Cuando comienzas a jugar <? echo $controlrow["gamename"]; ?>, lo primero que ver�s ser� la ciudad. En esta vamos a poder curarnos, comprar items y mapas para viajar r�pidamente a otras ciudades.<br /><br />
Para curarte debes usar la opci�n "Dormir en un Hotel". Esto recuperar� tu Salud al m�ximo, tambi�n tus Puntos de Magia y los Puntos de Recorrido que sirven para viajar a otras ciudades sin recorrer el mapa. Cada ciudad tiene un hotel, y cada hotel tiene un precio m�s caro, dependiendo de la ciudad en que te encuentres. No es de interes en que ciudad te encuentres, ya que todos los hoteles cumplen las mismas funciones. Si no te encuentras cerca de la ciudad puedes empezar usando habilidades de curaci�n y ir caminando a las ciudades.<br /><br />
Todos los usuarios de <? echo $controlrow["gamename"]; ?> son libres de comprar su equipamiento. Para eso deben usar la opci�n "Ir al Mercado". Aqu� podr�n encontrar Armas, Armaduras y Escudos para equiparse correctamente. En la primera ciudad conocida (Klamhin), los equipamentos que puedes comprar son de bajo nivel, pero te van a servir para esos primeros niveles, despu�s deber�s viajar a otras ciudades para equiparte mejor. Una vez que estes en el mercado ver�s varias listas, cada una definir� que tipo de item es (Arma, Armadura o Escudo), el precio, y el Poder de Ataque/Defensa.
Si ves un Asterisco(<span class="highlight">*</span>) al lado del nombre de los items, significa que estos tienen atributos especiales. Los Atributos Especiales modifican una parte del perfil del personaje y pueden ser positivos o negativos (Aumentar/Decrecer Fuerza). Tienes que mirar la secci�n de Items y Drops para ver m�s informaci�n sobre el tema.<br /><br />
Otras cosas que puedes hacer en la ciudad es comprar mapas. Esto te servir� para viajar r�pido hacia otras ciudades. Para esto necesitar�s Puntos de Recorrido, que var�an seg�n la ciudad a la que quieras viajar.<br /><br /><br />
[ <a href="#top">Volver al Inicio</a> ]

<br /><br /><hr />

<h3><a name="exploring"></a>Jugando: Explorando y Peleando</h3>
Una vez que ya hayas explorado la ciudad, estas listo para adentrarte en la aventura. Tienes que usar los botones de movimiento para viajar por el mundo de <? echo $controlrow["gamename"]; ?>.
Basicamente, este mundo es un gran cuadrado divido en 4 cuadrantes. Cada cuadrante tiene <? echo $controlrow["gamesize"]; ?> espacios.
La primer ciudad est� ubicada en el v�rtice principal (0N,0E). Ahora para salir de la primera ciudad podemos salir por los 4 puntos cardinales. Vamos a movernos hacia el norte para ver las pruebas de coordenadas, en donde se indica 1 hacia el norte, 0 hacia las demas posiciones (1N,0E).
Las coordenadas de definen de esta forma. Un n�mero para Norte o Sur, definida la posici�n con la letra de cada punto cardinal (N-S), y otro n�mero para Este u Oeste, definida la posici�n con la letra de cada punto cardinal (E-O).<br /><br />
Ocacionalmente, mientras exploras, puedes encontrarte con bichos, que van pasando de nivel, dependiendo de la ubicaci�n en que te encuentres. Una vez que encuentres un bicho, la pantalla pasar� de ser "Exploraci�n" a "Pelea".<br /><br />
Cuando la pelea comienze, ver�s una foto del monstruo, sus puntos de vida y que comando realiz�, y se te va a dar la oportunidar de atacar en cuanto sea tu turno. Tendr�s 3 opciones. Atacar, Usar una habilidad o Correr.<br /><br />
Si atacas sin usar una habilidad, el da�o se calcular� de tu Poder de Ataque y se le descontar� la armadura del monstruo. Tambi�n tendr�s la posibildad de pegar un "Golpe Excelente", que duplicar� la fuerza de tu ataque, haciendolo que el da�o sea el doble al normal. Tambi�n puede ocurrir que el monstruo esquive algunos de los ataques y no puedas da�arlo.<br /><br />
Para usar una habilidad deber�s usar el "Men� de Habilidad". Aqu� podr�s ver todas las habilidades disponibles, seleccionar una y despu�s presionar en Usar Habilidad para usarla.<br /><br />
Finalmente, tienes la posibilidad de Escapar, para esto debemos seleccionar la opci�n correcta. Debes saber que hay posiblidades de que el monstruo bloquee tu camino y no te deje escapar, tambi�n te atacar�. Entonces si tus puntos de vida son bajos, es conveniente que estes por lugares donde los monstruos no te peguen mucho.<br /><br />
Una vez termines con tu turno, el monstruo tendr� el suyo, tambi�n tendr�s la posibilidad de esquivar los ataques de los monstruos.<br /><br />
El resultado final de la batalla se calcular� cuando uno de los dos (el monstruo o el jugador) lleguen a 0 Puntos de Vida. Si ganas, el monstruo muerto te dar� experiencia y oro, tambi�n tendr�s la posibilidad que tire un "DROP", que es un item accesorio que tira el monstruo y que podr�s equiparte. Si pierdes y mueres, se te quitar� la mitad de oro para revivirte. Y recuparar�s una peque�a cantidad de Puntos de Vida para que puedas recaudar oro, por si no tienes para pagar un Hotel.<br /><br />
Cuando la pelea termine podr�s continuar explorando.<br /><br />
[ <a href="#top">Volver al Inicio</a> ]

<br /><br /><hr />

<h3><a name="status"></a>Jugando: Paneles de Estado</h3>
Hay dos Paneles de Estado en <? echo $controlrow["gamename"]; ?>. El de Jugador y el de Personaje<br /><br />
En el de Jugador, podremos ver varias opciones, como para movernos, ir a las diferentes secciones del juego, y ver nuestro estado actual: (En la Ciudad, Explorando, Peleando).<br /><br />
En el Panel de Personaje podremos ver el estado de nuestro personaje, el inventario, y las habilidades r�pidas.<br /><br />
Tambi�n se muestran las caracteristicas m�s importantes del personaje, y 3 barras de estado que son su vida, su Puntos de Magia y su Puntos de Recorrido. Estas barras tienen 3 colores. Verdes: Si est�n al m�ximo, Amarillos: Si est�n a medias, y Rojo: Si est�n muy bajas.<br /><br />
La secci�n de Habilidades R�pidas son para curarse mientras se explora, para eso hay que tener la habilidad de cura (que la aprenden todos los personajes).<br />
[ <a href="#top">Volver al Inicio</a> ]

<br /><br /><hr />

<h3><a name="credits"></a>Cr�ditos y Staff</h3>
<ul>
<li /><b>Este proyecto partio a partir de Dragon Knight de Jamin Seven</b>.<br /><br />
<li /><b>Soul Adventure</b> fue creado por Nahuel Jes�s Sacchetti (elnawe)<br /><br />
<li />Gracias a Dalez de GameFAQs por la tabla de experiencia.<br /><br />
<li />Las personas que colaborar�n directamente con este juego fueron:<br /><br />
<b>Programaci�n versiones 2.0 y superior:</b>
<ul><br />
<li />Skinet
<li />Ethernity
<li />elnawe
</ul><br />
<li />Gracias a <b>ti</b> por usar <b><a href="http://soul-adventure.net">SouL Adventure</a></b>!<br /><br />
</ul>
[ <a href="#top">Volver al Inicio</a> ]

<br /><br /><hr /><br />

<br /><br />
</body>
</html>