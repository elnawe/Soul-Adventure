<?php
$template = <<<THEVERYENDOFYOU
<div class='logo'><img src='estilo/imagenes/default/logo.png' alt='SouL Adventure' title='SouL Adventure' border='0' class='logo'/>
<div class='menusup'>
		<ul>
		{{forumslink}}
		<li><a href='index.php?do=chat'>Chat</a></li>
		<li><a href='index.php?do=rank'>Ranking</a></li>
		<li><a href='index.php?do=cambiar'>Cambiar Contraseña</a></li>
		<li><a href='ayuda.php'>Ayuda</a></li>
		<li><a href='entrar.php?do=salir'>Salir</a></li>
		{{adminlink}}
		</ul>
</div>
THEVERYENDOFYOU;
?>