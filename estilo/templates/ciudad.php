<?php
$template = "
<div class='titulo'>Bienvenido a {{name}}</div>
<div class='contenido2'>
 <div class='mapa'> 
<div> 
     <map name='imgmap'>  
         <area shape='poly' coords='320,44,318,115,425,164,474,119,470,51,387,21,322,45,359,52' href='index.php?do=arena' alt='Arena de combate'>  
         <area shape='poly' coords='312,149,208,151,210,240,324,245,314,151,315,150,260,193' href='index.php?do=hotel' alt='Hotel'>  
         <area shape='poly' coords='94,80,109,36,82,83,76,117,142,154,211,126,169,47,108,40,84,84,146,85' href='clan.php' alt='Embajada'>  
         <area shape='poly' coords='70,296,64,366,117,398,178,362,180,323,132,281,71,298,102,316' href='index.php?do=comprar' alt='Tienda de armas y armaduras'>  
         <area shape='poly' coords='357,324,257,373,272,438,435,437,429,386,358,325,437,437' href='index.php?do=mapas' alt='Vendendor de mapas'>  
         <area shape='poly' coords='378,236,362,298,426,343,532,290,496,199,377,238,415,246' href='mensajero.php' alt='Mensajero'>  
		 <area shape='poly' coords='23,181,22,270,69,288,118,258,117,199,61,166,24,184,62,214' href='index.php?do=banco' alt='Banco'>
     </map>  
 </div>  
 </div>
     
     <img src='estilo/imagenes/ciudad/ciudad_a.png' width='543' height='444' alt='Move mouse over image' usemap='#imgmap' border='no-border'>  
 
<div class='notionli'>
{{news}}
</div>
<div class='notionli'>
{{whosonline}}
</div>
</div>
";
?>