<?php
$template = <<<THEVERYENDOFYOU
<div class='titulo'>Perfil de: <b>{{charname}}</b>.</div>
<div class='contenido2'>
<a href="index.php">Volver a la ciudad</a>.<br /><br />
<table width="200">
<tr><td class="title">Personaje</td></tr>
<tr><td>
<b>{{charname}}</b><br />
<center><img src="estilo/imagenes/clase/{{charclass}}.gif"></center><br />
Dificultad: {{difficulty}}<br />
Raza: {{charrace}}<br />
Clase: {{charclass}}<br /><br />
<br /><br />


Nivel: {{nivel}}<br />
Experiencia: {{experience}}<br />
Oro: {{gold}}<br />
Puntos de Vida: {{currenthp}} / {{maxhp}}<br />
Puntos de Magia: {{currentmp}} / {{maxmp}}<br />
Puntos de Recorrido: {{currenttp}} / {{maxtp}}<br /><br />

Fuerza: {{strength}}<br />
Destreza: {{dexterity}}<br />
Poder de Ataque: {{attackpower}}<br />
Poder de Defensa: {{defensepower}}<br />
</td></tr>
</table><br />

<table width="200">
<tr><td class="title">Inventario</td></tr>
<tr><td>
<table width="100%">
<tr><td><img src="estilo/imagenes/iconos/icono_arma.gif" alt="Arma" title="Arma" /></td><td width="100%">Arma: {{weaponname}}</td></tr>
<tr><td><img src="estilo/imagenes/iconos/icono_armadura.gif" alt="Armadura" title="Armadura" /></td><td width="100%">Armadura: {{armorname}}</td></tr>
<tr><td><img src="estilo/imagenes/iconos/icono_escudo.gif" alt="Escudo" title="Escudo" /></td><td width="100%">Escudo: {{shieldname}}</td></tr>
</table>
Espacio 1: {{slot1name}}<br />
Espacio 2: {{slot2name}}<br />
Espacio 3: {{slot3name}}
</td></tr>
</table><br />
</div>
THEVERYENDOFYOU;
?>