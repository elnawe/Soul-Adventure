<?php
$template = "
<div class='texto'>
	<div class='title'><img border=0 src=\"estilo/imagenes/default/estado.png\" ></div>
	<div class='nombrepersonaje'><b>{{charname}}</b><br /></div>
	<div>
		<div class='raza'><img src='estilo/imagenes/clase/{{charrace}}.gif'></div>
			<div class='barras'>{{statbars}}</div>
				<div >
				<ul class='informacion'> 
					<br /><li>
						<span class='informacion2' id='tituloinfo'>Clase</span>
						<span class='informacion3' id='tituloinfo'>Nivel</span> 
					</li>
					<li>
						<span class='informacion2'>{{charclass}}</span>
						<span class='informacion3'>{{nivel}}</span>
					</li>
					<li>
					<span class='informacion2' id='tituloinfo'>Exp</span>
					<span class='informacion3' id='tituloinfo'>Oro </span>
					</li>
					<li>
					<span class='informacion2'>{{experience}}</span>
					<span class='informacion3'>{{gold}}  </span>
					</li>
				</ul>
			</div>
			<div class='hojapersonaje'><a href='javascript:opencharpopup()'><img border=0 src=\"estilo/imagenes/default/ficha.png\" ></a></div>
	</div>
	<div class='inventario'>
			<div class='tituloinventario'><img border=0 src=\"estilo/imagenes/default/inventario.png\" ></div>
			<div><img src='estilo/imagenes/iconos/icono_arma.gif' alt='Arma' title='Arma' /> Arma: {{weaponname}}</div>
			<div><img src='estilo/imagenes/iconos/icono_armadura.gif' alt='Armadura' title='Armadura' /> Armadura: {{armorname}}</div>
			<div><img src='estilo/imagenes/iconos/icono_escudo.gif' alt='Escudo' title='Escudo' /> Escudo: {{shieldname}}</div>
			<div><img src='estilo/imagenes/iconos/icono_mochila.gif' alt='Mochila' title='Mochila' /> Espacio 1: {{slot1name}}</div>
			<div><img src='estilo/imagenes/iconos/icono_mochila.gif' alt='Mochila' title='Mochila' /> Espacio 2: {{slot2name}}</div>
			<div><img src='estilo/imagenes/iconos/icono_mochila.gif' alt='Mochila' title='Mochila' /> Espacio 3: {{slot3name}}</div>
	</div>
	<div class='habilidades'>
		<div class='title'><img border=0 src=\"estilo/imagenes/default/magias.png\" ></div><br /><br />
			<div>
				{{magiclist}}
			</div>
	</div>
</div>
";
?>