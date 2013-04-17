<?php
$template = "
<div class='texto'>
<table width='100%'>
<tr><td class='title'><img border=0 src=\"estilo/imagenes/default/explorar.png\" ></td></tr>
<tr><td>
Actualmente: {{currentaction}}<br />
Latitud: {{latitude}}<br />
Longitud: {{longitude}}<br />
<center>
<TABLE>
<form action='index.php?do=mover' method='post'>
<TD align='justify'>
<input name='north' ALIGN=TOP type='image' src='estilo/imagenes/compas/norte.png'/><br>
<input name='west' ALIGN=LEFT type='image' src='estilo/imagenes/compas/oeste.png'/>
<input name='east' ALIGN=LEFT type='image' src='estilo/imagenes/compas/este.png'/><br>
<input name='south' VALIGN=TOP ALIGN=LEFT type='image' src='estilo/imagenes/compas/sur.png'/>
</TD>
</form>
</TABLE>
</center><br />
<a href='javascript:openmappopup()'><center><img border=0 src=\"estilo/imagenes/default/mapa.png\" ></center></a><br /><br />
</form>
</td></tr>
</table><br />

<table width='100%'>
<tr><td class='title'><img border=0 src=\"estilo/imagenes/default/ciudades.png\" ></td></tr>
<tr><td>
{{currenttown}}
Viajar a:<br />
{{townslist}}
</td></tr>
</table><br />
</div>

";
?>