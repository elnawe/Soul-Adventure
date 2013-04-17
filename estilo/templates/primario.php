<?php
$template = <<<THEVERYENDOFYOU
<head>
<title>{{title}}</title>
<link rel="shortcut icon" href="estilo/imagenes/default/favicon.ico" />
<LINK rel="stylesheet" type="text/css" href="estilo/css/principal.css">
<script>
function opencharpopup(){
var popurl="index.php?do=verpj"
winpops=window.open(popurl,"","width=210,height=500,scrollbars")
}
function openmappopup(){
var popurl="mapa.php"
winpops=window.open(popurl,"","width=501,height=501,noscrollbars")
}
</script>
</head>
<body>
<div class='centrar'>
<div class='no_pie'>
<div id=content>
<div class='cabecera'>{{topnav}}</div>
<div class='left'>{{leftnav}}</div>
<div class='contenido'>{{content}}</div>
<div class='right'>{{rightnav}}</div>
</div>
</div>
<div class="copyright">
Powered by <a href="http://www.soul-adventure.net/" target="_new"> Soul Adventure</a> {{totaltime}} Segundos, {{numqueries}}  Consultas {{version}} {{build}}</div>
</div></body>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7430683-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</html>
THEVERYENDOFYOU;
?>