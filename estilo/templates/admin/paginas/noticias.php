<?php
$template = "
<b><u>Agregar una nueva Noticia</u></b>
<br/><br/>
<form action='administracion.php?opcion=noticias' method='post'>
Escribe la noticia abajo y despu&eacute;s presione Enviar para publicarla.<br/>
<textarea name='content' rows='5' cols='50'></textarea>
<br/>
<input type='submit' name='submit' value='Enviar'/> 
<input type='reset' name='reset' value='Cancelar'/>
</form>
<p><a href='administracion.php?ir=general'>Volver</a></p>
";

?>