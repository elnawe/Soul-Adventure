<?php
$template = <<<THEVERYENDOFYOU
<head>
<title>{{title}}</title>
<link rel="shortcut icon" href="../estilo/imagenes/default/favicon.ico" />
<LINK rel='stylesheet' type='text/css' href='../estilo/css/administracion.css'>
</style>
</head>
<body>
<div class='superior'>
<a href='../index.php'>Juego</a>|<a href='administracion.php?opcion=inicio'>Admin</a>|<a href='../ayuda_admin.php'>Ayuda</a></div>
<div class='menu'>
	<ul>
		<li><span>Administración</span></li>
		<li><a href='administracion.php?ir=general'>Ajustes generales:</a></li>
		<li><span>Ajustes de juego:</span></li>
		<li><a href='administracion.php?ir=usuario'>Usuarios</a></li>
		<li><a href='administracion.php?ir=items'>Items</a></li>
		<li><a href='administracion.php?ir=ciudad'>Ciudades</a></li>
		<li><a href='administracion.php?ir=monstruo'>Monstruos</a></li>
		<li><a href='administracion.php?ir=drop'>Drops</a></li>
		<li><a href='administracion.php?ir=habilidad'>Habilidades</a></li>
</div>
<div class='contenido'>
{{content}}
<div class='copyright'>
</a>Powered by <a href='http://www.soul-adventure.net/' target='_new'> SouL Adventure</a>{{totaltime}} Segundos, {{numqueries}} Consultas {{version}} 
</div>
</div>
</center></body>
</html>
THEVERYENDOFYOU;
?>