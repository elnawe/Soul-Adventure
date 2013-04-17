<?php

$template = "<b><u>Cambios Principales</u></b><br />
Estas opciones serán utilizadas para cambiar las configuraciones principales del juego.<br /><br />
<form action='administracion.php?opcion=principal' method='post'>
<table width='90%'>
<tr><td width='20%'><span class='highlight'>Estado del Juego:</span></td><td><select name='gameopen'><option value='1' {{open1select}}>Abierto</option><option value='0' {{open0select}}>Cerrado</option></select><br /><span class='small'>Cierra el juego si estás trabajando en el servidor o haciendo cambios del mismo.</span></td></tr>
<tr><td width='20%'>Nombre del Juego:</td><td><input type='text' name='gamename' size='30' maxlength='50' value='{{gamename}}' /><br /><span class='small'>Elije el nombre del juego.</span></td></tr>
<tr><td width='20%'>URL del Juego:</td><td><input type='text' name='gameurl' size='50' maxlength='100' value='{{gameurl}}' /><br /><span class='small'>La especificación de la URL del Juego.</span></td></tr>
<tr><td width='20%'>E-mail de Administración:</td><td><input type='text' name='adminemail' size='30' maxlength='100' value='{{adminemail}}' /><br /><span class='small'>Aparecerá cuando ocurra algún error.</span></td></tr>
<tr><td width='20%'>Tamaño del Mapa:</td><td><input type='text' name='gamesize' size='3' maxlength='3' value='{{gamesize}}' /><br /><span class='small'>Debe ser divisor de 5.</span></td></tr>
<tr><td width='20%'>Tipo de Foro:</td><td><select name='forumtype'><option value='0' {{selecttype0}}>Desactivado</option><option value='1' {{selecttype1}}>Interno</option><option value='2' {{selecttype2}}>Externo</option></select><br /><span class='small'>Cual será el tipo del foro utilizado.</span></td></tr>
<tr><td width='20%'>Foro Externo:</td><td><input type='text' name='forumaddress' size='30' maxlength='200' value='{{forumaddress}}' /><br /><span class='small'>Describe la URL del foro Externo (Si se eligió esta opción).</span></td></tr>
<tr><td width='20%'>Compresión de Página:</td><td><select name='compression'><option value='0' {{selectcomp0}}>Desactivada</option><option value='1' {{selectcomp1}}>Activada</option></select><br /><span class='small'>Recude la cantidad de banda ancha gastada.</span></td></tr>
<tr><td width='20%'>Verificación Anti-SPAM:</td><td><select name='verifyemail'><option value='0' {{selectverify0}}>Desactivada</option><option value='1' {{selectverify1}}>Activada</option></select><br /><span class='small'>Los usuarios deberán verificar su e-mail al registrarse.<br /> <b>NOTA:</b> En algunos servidores no funciona.</span></td></tr>
<tr><td width='20%'>Mostrar Noticias:</td><td><select name='shownews'><option value='0' {{selectnews0}}>No</option><option value='1' {{selectnews1}}>Sí</option></select><br /><span class='small'>Muestra las noticias de administración.</td></tr>
<tr><td width='20%'>Mostrar Conectados:</td><td><select name='showonline'><option value='0' {{selectonline0}}>No</option><option value='1' {{selectonline1}}>Sí</option></select><br /><span class='small'>Muestra los conectados.</span></td></tr>
<tr><td width='20%'>Mostrar Chat:</td><td><select name='showbabble'><option value='0' {{selectbabble0}}>No</option><option value='1' {{selectbabble1}}>Sí</option></select><br /><span class='small'>Activa o desactiva el chat.</span></td></tr>
<tr><td width='20%'>Clase 1:</td><td><input type='text' name='class1name' size='20' maxlength='50' value='{{class1name}}'/><br /></td></tr>
<tr><td width='20%'>Clase 2:</td><td><input type='text' name='class2name' size='20' maxlength='50' value='{{class2name}}' /><br /></td></tr>
<tr><td width='20%'>Clase 3:</td><td><input type='text'  name='class3name' size='20' maxlength='50' value='{{class3name}}' /><br /></td></tr>
<tr><td width='20%'>Raza 1:</td><td><input type='text'  name='race1name' size='20' maxlength='50' value='{{race1name}}' /><br /></td></tr>
<tr><td width='20%'>Raza 2:</td><td><input type='text'  name='race2name' size='20' maxlength='50' value='{{race2name}}' /><br /></td></tr>
<tr><td width='20%'>Raza 3:</td><td><input type='text'  name='race3name' size='20' maxlength='50' value='{{race3name}}' /><br /></td></tr>
<tr><td width='20%'>Raza 4:</td><td><input type='text'  name='race4name' size='20' maxlength='50' value='{{race4name}}' /><br /></td></tr>
<tr><td width='20%'>Raza 5:</td><td><input type='text'  name='race5name' size='20' maxlength='50' value='{{race5name}}' /><br /></td></tr>
<tr><td width='20%'>Dificultad 1:</td><td><input type='text' name='diff1name' size='20' maxlength='50' value='{{diff1name}}' /><br /></td></tr>
<tr><td width='20%'>Dificultad 2:</td><td><input type='text' name='diff2name' size='20' maxlength='50' value='{{diff2name}}' /><br /></td></tr>
<tr><td width='20%'>Dificultad 2 - Valor:</td><td><input type='text' name='diff2mod' size='3' maxlength='3' value='{{diff2mod}}' /><br /><span class='small'>Valor de la dificultad 2.</span></td></tr>
<tr><td width='20%'>Dificultad 3:</td><td><input type='text' name='diff3name' size='20' maxlength='50' value='{{diff3name}}' /><br /></td></tr>
<tr><td width='20%'>Dificultad 3 - Valor:</td><td><input type='text' name='diff3mod' size='3' maxlength='3' value='{{diff3mod}}' /><br /><span class='small'>Valor de la dificultad 3.</span></td></tr>
</table>
<input type='submit' name='submit' value='Guardar' /> <input type='reset' name='reset' value='Cancelar' />
</form>";

?>