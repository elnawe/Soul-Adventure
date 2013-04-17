<?php  
#############################################################################
# *                                                          				#
# * SOUL ADVENTURE	                                         				#
# *                                                        					#
# * Este proyecto esta bajo una licencia Creative Commons   				#
# * Reconocimiento - NoComercial - CompartirIgual (by-nc-sa):				#
# * No se permite un uso comercial de la obra original ni de las posibles	#
# * obras derivadas, la distribución de las cuales se debe hacer con una	#
# * licencia igual a la que regula la obra original.   						#
# * 																		#
# * Este proyecto toma como base los scripts de:							#
# *  -Jamin Seven (Dragon Knight)											#
# *  -Adam Dear (Dragon Kingdom)											#
# *  -Nawe(Soul Adventure)-abandono por falta de tiempo				        #
# * Actualmente siguen su desarrollo Ethernity y Skinet						#
# * Para más información: www.soul-adventure.net							#
# *                                                          				#
#############################################################################
//  Comienzo del entrenamiento
function entrenar() {
global $userrow;


// Ajuste de precios 
  $strcost = ($userrow["strength"] * $userrow["strength"]); //Fuerza
  $dexcost = ($userrow["dexterity"]* $userrow["dexterity"]); //Destreza
  $attcost = ($userrow["attackpower"] * $userrow["attackpower"]); //Poder de ataque
  $defcost = ($userrow["defensepower"] * $userrow["defensepower"]); //Poder de defensa
  $hpcost = ($userrow["maxhp"] * $userrow["maxhp"]); //Vida
  $mpcost = ($userrow["maxmp"] * $userrow["maxmp"]); //Mana

// Formulario
$title = "Entrenamiento"; 

$page = "<div class='contenido2'>Aqui puedes mejorar tus habilidades, piensa antes lo que vas a hacer y como quieres que sea tu personaje. Suerte con tu entrenamiento!</td></tr><br>\n"; 

$page .= "<div align=center>¿Que atributo deseas mejorar?</div><br><br>\n"; 

$page .= "Costara $strcost de oro para aumentar la fuerza de ".$userrow["strength"]." a ".($userrow["strength"] + 1).".\n";
$page .= "<form action=\"index.php?do=entrenar\" method=\"post\">\n";
$page .= "<input type=\"submit\" name=\"str\" value=\"Entrenar!\" /><br><br>\n"; 

$page .= "Costara $dexcost de oro aumentar la destreza de ".$userrow["dexterity"]." a ".($userrow["dexterity"] + 1).".\n"; 
$page .= "<form action=\"index.php?do=entrenar\" method=\"post\">\n"; 
$page .= "<input type=\"submit\" name=\"dex\" value=\"Entrenar!\" /><br><br>\n";

$page .= "Costara $attcost de oro aumentar el poder de ataque ".$userrow["attackpower"]." to ".($userrow["attackpower"] + 1).".\n"; 
$page .= "<form action=\"index.php?do=entrenar\" method=\"post\">\n"; 
$page .= "<input type=\"submit\" name=\"att\" value=\"Entrenar!\" /><br><br>\n"; 

$page .= "Costara $defcost de oro aumentar el poder de defensa de ".$userrow["defensepower"]." a ".($userrow["defensepower"] + 1).".\n"; 
$page .= "<form action=\"index.php?do=entrenar\" method=\"post\">\n"; 
$page .= "<input type=\"submit\" name=\"def\" value=\"Entrenar!\" /><br><br>\n"; 

$page .= "Costara $hpcost de oro aumentar la vitalidad de ".$userrow["maxhp"]." a ".($userrow["maxhp"] + 1).".\n"; 
$page .= "<form action=\"index.php?do=entrenar\" method=\"post\">\n"; 
$page .= "<input type=\"submit\" name=\"hp\" value=\"Entrenar!\" /><br><br>\n"; 

$page .= "Costara $mpcost de oro aumentar los puntos de magia de ".$userrow["maxmp"]." a ".($userrow["maxmp"] + 1).".\n"; 
$page .= "<form action=\"index.php?do=entrenar\" method=\"post\">\n"; 
$page .= "<input type=\"submit\" name=\"mp\" value=\"Entrenar!\" /><br><br>\n"; 
 
$page .= "<div align=center>Volver a la <a href=\"index.php\">ciudad</a>.</div></div>"; 

display($page, "Entrenar"); 
}

//Ajuste de Precios
  $strcost = ($userrow["strength"] * $userrow["strength"]); //Fuerza
  $dexcost = ($userrow["dexterity"]* $userrow["dexterity"]); //Destreza
  $attcost = ($userrow["attackpower"] * $userrow["attackpower"]); //Poder de ataque
  $defcost = ($userrow["defensepower"] * $userrow["defensepower"]); //Poder de defensa
  $hpcost = ($userrow["maxhp"] * $userrow["maxhp"]); //Vida
  $mpcost = ($userrow["maxmp"] * $userrow["maxmp"]); //Mana
  

//Confirmación del formulario
 if (isset($_POST['str'])) 
  {
    $cost = $strcost;
    if($cost > $userrow["gold"]){ $page = "<div class='contenido2'>No tienes suficiente oro.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a></div>"; $die = true;
display($page, "Entrenar"); }
    
    if($die == false)
    {
      doquery("UPDATE {{table}} SET `strength` = `strength` + '1', `gold` = `gold` - '$cost' WHERE `id` = '".$userrow["id"]."'", "usuarios");
      $page = "<div class='contenido2'>Tu entrenamiento ha concluido.Has conseguido aumentar tu fuerza. <br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>";
display($page, "Entrenar"); 
    }
  }
  
 if (isset($_POST['dex']))
  {
    $cost = $dexcost;
    if($cost > $userrow["gold"]){ $page = "<div class='contenido2'>No tienes suficiente oro.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>"; $die = true;
display($page, "Entrenar"); }
    
    if($die == false)
    {
      doquery("UPDATE {{table}} SET `dexterity` = `dexterity` + '1', `gold` = `gold` - '$cost' WHERE `id` = '".$userrow["id"]."'", "usuarios");
      $page = "<div class='contenido2'>Tu entrenamiento ha concluido. Has conseguido aumentar tu destreza. <br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>";
display($page, "Entrenar"); 
    }
  }
  
 if (isset($_POST['att']))
  {
    $cost = $attcost;
    if($cost > $userrow["gold"]){ $page = "<div class='contenido2'>No tienes suficiente oro.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>"; $die = true;
display($page, "Entrenar"); }
    if($die == false)
    {
      doquery("UPDATE {{table}} SET `attackpower` = `attackpower` + '1', `gold` = `gold` - '$cost' WHERE `id` = '".$userrow["id"]."'", "usuarios");
      $page = "<div class='contenido2'>Tu entrenamiento ha concluido. Has conseguido aumentar tu poder de ataque.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>";
display($page, "Entrenar"); 
    }
  }


 if (isset($_POST['def']))
  {
    $cost = $defcost;
    if($cost > $userrow["gold"]){ $page = "<div class='contenido2'>No tienes suficiente oro.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>"; $die = true; 
display($page, "Entrenar"); }
    
    if($die == false)
    {
      doquery("UPDATE {{table}} SET `defensepower` = `defensepower` + '1', `gold` = `gold` - '$cost' WHERE `id` = '".$userrow["id"]."'", "usuarios");
      $page = "<div class='contenido2'>Tu entrenamiento ha concluido. Has conseguido aumentar tu poder de defensa.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>";
display($page, "Entrenar"); 
    }
  }
  
   if (isset($_POST['hp']))
  {
    $cost = $hpcost;
    if($cost > $userrow["gold"]){ $page = "<div class='contenido2'>No tienes suficiente oro.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>"; $die = true; 
display($page, "Entrenar"); }
    
    if($die == false)
    {
      doquery("UPDATE {{table}} SET `maxhp` = `maxhp` + '1', `gold` = `gold` - '$cost' WHERE `id` = '".$userrow["id"]."'", "usuarios");
      $page = "<div class='contenido2'>Tu entrenamiento ha concluido. Has conseguido aumentar tu vitalidad.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>";
display($page, "Entrenar"); 
    }
  }
  
     if (isset($_POST['mp']))
  {
    $cost = $mpcost;
    if($cost > $userrow["gold"]){ $page = "<div class='contenido2'>No tienes suficiente oro.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>"; $die = true; 
display($page, "Entrenar"); }
    
    if($die == false)
    {
      doquery("UPDATE {{table}} SET `maxmp` = `maxmp` + '1', `gold` = `gold` - '$cost' WHERE `id` = '".$userrow["id"]."'", "usuarios");
      $page = "<div class='contenido2'>Tu entrenamiento ha concluido. Has conseguido aumentar tus puntos de magia.<br /><br /><a href=\"index.php?do=entrenar\">Volver al entrenamiento</a>.</div>";
display($page, "Entrenar"); 
    }
  }
  
 // FINAL DEL ENTRENAMIENTO
  
?>