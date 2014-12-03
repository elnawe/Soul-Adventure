<?
$template = <<<THEVERYENDOFYOU
<table width="100%">
<tr><td class="title">Personaje</td></tr>
<tr><td>
<b>{{charname}}</b><br />
<center><img src="estilo/imagenes/clase/{{charclass}}.gif"></center><br />
Dificultad: {{difficulty}}<br />
Raza: {{charrace}}<br />
Clase: {{charclass}}<br /><br />


Nivel: {{nivel}}<br />
Experiencia: {{experience}} {{plusexp}}<br />
Sig. Nivel: {{siguientenivel}}<br />
Oro: {{gold}} {{plusgold}}<br />
Puntos de Vida: {{currenthp}} / {{maxhp}}<br />
Puntos de Magia: {{currentmp}} / {{maxmp}}<br />
Puntos de Recorrido: {{currenttp}} / {{maxtp}}<br /><br />

Fuerza: {{strength}}<br />
Destreza: {{dexterity}}<br />
Poder de Ataque: {{attackpower}}<br />
Poder de Defensa: {{defensepower}}<br />
</td></tr>
</table><br />

<table width="100%">
<tr><td class="title">Inventario</td></tr>
<tr><td>
<table width="100%">
<tr><td><img src="estilo/imagenes/iconos/icono_arma.gif" alt="Weapon" title="Weapon" /></td><td width="100%">Arma: {{weaponname}}</td></tr>
<tr><td><img src="estilo/imagenes/iconos/icono_armadura.gif" alt="Armor" title="Armor" /></td><td width="100%">Armadura: {{armorname}}</td></tr>
<tr><td><img src="estilo/imagenes/iconos/icono_escudo.gif" alt="Shield" title="Shield" /></td><td width="100%">Escudo: {{shieldname}}</td></tr>
</table>
Espacio 1: {{slot1name}}<br />
Espacio 2: {{slot2name}}<br />
Espacio 3: {{slot3name}}
</td></tr>
</table><br />

<table width="100%">
<tr><td class="title">Habilidades</td></tr>
<tr><td>
{{magiclist}}
</td></tr>
</table><br />
THEVERYENDOFYOU;
?>