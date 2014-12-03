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
include_once('../includes/comprueba_admin.php');


switch ($_GET['opcion'])

{
case 'editarusuario' :

if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
		if ($id == $_POST) { $errors++; $errorlist .= "No puedes cambiar la id del usuario.<br />"; }
        if ($email == "") { $errors++; $errorlist .= "Se requiere E-mail.<br />"; }
        if ($verify == "") { $errors++; $errorlist .= "Se requiere Verificación.<br />"; }
        if ($charname == "") { $errors++; $errorlist .= "Se requiere Nombre de Personaje.<br />"; }
        if ($autorizacion == "") { $errors++; $errorlist .= "Se requiere Nivel de Autorización.<br />"; }
        if ($latitude == "") { $errors++; $errorlist .= "Se requiere Latitud.<br />"; }
        if ($longitude == "") { $errors++; $errorlist .= "Se requiere Longitud.<br />"; }
        if ($difficulty == "") { $errors++; $errorlist .= "Se requiere Dificultad.<br />"; }
        if ($charclass == "") { $errors++; $errorlist .= "Se requiere Clase de Personaje.<br />"; }
		if ($charrace == "") { $errors++; $errorlist .= "Se requiere Raza de Personaje.<br />"; }
        if ($currentaction == "") { $errors++; $errorlist .= "Se requiere Acción actual.<br />"; }
        if ($currentfight == "") { $errors++; $errorlist .= "Se requiere Pelea actual.<br />"; }
        
        if ($currentmonster == "") { $errors++; $errorlist .= "Se requiere Monstruo actual.<br />"; }
        if ($currentmonsterhp == "") { $errors++; $errorlist .= "Se requiere PV del Monstruo actual.<br />"; }
        if ($currentmonstersleep == "") { $errors++; $errorlist .= "Se requiere Sueño del Monstruo actual.<br />"; }
        if ($currentmonsterimmune == "") { $errors++; $errorlist .= "Se requiere Inmunidades del Monstro actual.<br />"; }
        if ($currentuberdamage == "") { $errors++; $errorlist .= "Se requiere Aura de Ataque actual.<br />"; }
        if ($currentuberdefense == "") { $errors++; $errorlist .= "Se requiere Aura de Defensa actual.<br />"; }
        if ($currenthp == "") { $errors++; $errorlist .= "Se requiere PV actual.<br />"; }
        if ($currentmp == "") { $errors++; $errorlist .= "Se requiere PM actual.<br />"; }
        if ($currenttp == "") { $errors++; $errorlist .= "Se requiere PR actual.<br />"; }
        if ($maxhp == "") { $errors++; $errorlist .= "Se requiere PV Máx.<br />"; }

        if ($maxmp == "") { $errors++; $errorlist .= "Se requiere PM Máx.<br />"; }
        if ($maxtp == "") { $errors++; $errorlist .= "Se requiere PR Máx.<br />"; }
        if ($nivel == "") { $errors++; $errorlist .= "Se requiere Nivel.<br />"; }
        if ($gold == "") { $errors++; $errorlist .= "Se requiere Oro.<br />"; }
		if ($banco == "") { $errors++; $errorlist .= "Se requiere Oro para el banco.<br />"; }
        if ($experience == "") { $errors++; $errorlist .= "Se requiere Experiencia.<br />"; }
        if ($goldbonus == "") { $errors++; $errorlist .= "Se requiere Bonus de Oro.<br />"; }
        if ($expbonus == "") { $errors++; $errorlist .= "Se requiere Bonus de Experiencia.<br />"; }
        if ($strength == "") { $errors++; $errorlist .= "Se requiere Fuerza.<br />"; }
        if ($dexterity == "") { $errors++; $errorlist .= "Se requiere Destreza.<br />"; }
        if ($attackpower == "") { $errors++; $errorlist .= "Se requiere Poder de Ataque.<br />"; }

        if ($defensepower == "") { $errors++; $errorlist .= "Se requiere Poder de Defensa.<br />"; }
        if ($weaponid == "") { $errors++; $errorlist .= "Se requiere ID de Arma.<br />"; }
        if ($armorid == "") { $errors++; $errorlist .= "Se requiere ID de Armadura.<br />"; }
        if ($shieldid == "") { $errors++; $errorlist .= "Se requiere ID de Escudo.<br />"; }
        if ($slot1id == "") { $errors++; $errorlist .= "Se requiere ID de Espacio 1.<br />"; }
        if ($slot2id == "") { $errors++; $errorlist .= "Se requiere ID de Espacio 2.<br />"; }
        if ($slot3id == "") { $errors++; $errorlist .= "Se requiere ID de Espacio 3.<br />"; }
        if ($weaponname == "") { $errors++; $errorlist .= "Se requiere Nombre de Arma.<br />"; }
        if ($armorname == "") { $errors++; $errorlist .= "Se requiere Nombre de Armadura.<br />"; }
        if ($shieldname == "") { $errors++; $errorlist .= "Se requiere Nombre de Escudo.<br />"; }

        if ($slot1name == "") { $errors++; $errorlist .= "Se requiere nombre para Espacio 1.<br />"; }
        if ($slot2name == "") { $errors++; $errorlist .= "Se requiere nombre para Espacio 2.<br />"; }
        if ($slot3name == "") { $errors++; $errorlist .= "Se requiere nombre para Espacio 3.<br />"; }
        if ($dropcode == "") { $errors++; $errorlist .= "Se requiere Código de Drop.<br />"; }
        if ($spells == "") { $errors++; $errorlist .= "Se requiere Habilidades.<br />"; }
        if ($towns == "") { $errors++; $errorlist .= "Se requiere Ciudades.<br />"; }
        
        if (!is_numeric($autorizacion)) { $errors++; $errorlist .= "El Nivel de Autorización debe ser un numero.<br />"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "La Latitud debe ser un número.<br />"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "La Longitud debe ser un número.<br />"; }
        if (!is_numeric($difficulty)) { $errors++; $errorlist .= "La Dificultad debe ser un número.<br />"; }
        if (!is_numeric($charclass)) { $errors++; $errorlist .= "La Raza de Personaje debe ser un número.<br />"; }
        if (!is_numeric($currentfight)) { $errors++; $errorlist .= "La Pelea Actual debe ser un número.<br />"; }
        if (!is_numeric($currentmonster)) { $errors++; $errorlist .= "El Monstruo Actual debe ser un número.<br />"; }
        if (!is_numeric($currentmonsterhp)) { $errors++; $errorlist .= "Los PV del Monstruo Actual deben estar indicados en números.<br />"; }
        if (!is_numeric($currentmonstersleep)) { $errors++; $errorlist .= "El Sueño del Monstruo Actual debe ser un número.<br />"; }
        
        if (!is_numeric($currentmonsterimmune)) { $errors++; $errorlist .= "La Inmunidad del Monstruo Actual debe ser un número.<br />"; }
        if (!is_numeric($currentuberdamage)) { $errors++; $errorlist .= "El Aura de Ataque Actual debe ser un número.<br />"; }
        if (!is_numeric($currentuberdefense)) { $errors++; $errorlist .= "El Aura de Defensa Actual debe ser un número.<br />"; }
        if (!is_numeric($currenthp)) { $errors++; $errorlist .= "Los PV Actuales deben ser números.<br />"; }
        if (!is_numeric($currentmp)) { $errors++; $errorlist .= "Los PM Actuales deben ser números.<br />"; }
        if (!is_numeric($currenttp)) { $errors++; $errorlist .= "Los PR Actuales deben ser números.<br />"; }
        if (!is_numeric($maxhp)) { $errors++; $errorlist .= "Los PV Máximos deben ser números.<br />"; }
        if (!is_numeric($maxmp)) { $errors++; $errorlist .= "Los PM Máximos deben ser números.<br />"; }
        if (!is_numeric($maxtp)) { $errors++; $errorlist .= "Los PR Máximos deben ser números.<br />"; }
        if (!is_numeric($nivel)) { $errors++; $errorlist .= "El Nivel debe ser un número.<br />"; }
        
        if (!is_numeric($gold)) { $errors++; $errorlist .= "El Oro debe ser un número.<br />"; }
        if (!is_numeric($experience)) { $errors++; $errorlist .= "La Experiencia debe ser un número.<br />"; }
        if (!is_numeric($goldbonus)) { $errors++; $errorlist .= "El Bonus de Oro debe estar indicado en números.<br />"; }
        if (!is_numeric($expbonus)) { $errors++; $errorlist .= "El Bonus de Experiencia debe estar indicado en números.<br />"; }
        if (!is_numeric($strength)) { $errors++; $errorlist .= "La Fuerza debe estar indicada en números.<br />"; }
        if (!is_numeric($dexterity)) { $errors++; $errorlist .= "La Destreza debe estar indicada en números.<br />"; }
        if (!is_numeric($attackpower)) { $errors++; $errorlist .= "El Poder de Ataque debe estar indicado en números.<br />"; }
        if (!is_numeric($defensepower)) { $errors++; $errorlist .= "El Poder de Defensa debe estar indicado en números.<br />"; }
        if (!is_numeric($weaponid)) { $errors++; $errorlist .= "El ID del Arma debe estar indicado en números.<br />"; }
        if (!is_numeric($armorid)) { $errors++; $errorlist .= "El ID de la Armadura debe estar indicado en números.<br />"; }
        
        if (!is_numeric($shieldid)) { $errors++; $errorlist .= "El ID del Escudo debe estar indicado en números.<br />"; }
        if (!is_numeric($slot1id)) { $errors++; $errorlist .= "El ID del Espacio 1 debe estar indicado en números.<br />"; }
        if (!is_numeric($slot2id)) { $errors++; $errorlist .= "El ID del Espacio 2 debe estar indicado en números.<br />"; }
        if (!is_numeric($slot3id)) { $errors++; $errorlist .= "El ID del Espacio 3 debe estar indicado en números.<br />"; }
        if (!is_numeric($dropcode)) { $errors++; $errorlist .= "El Código de Drop debe estar indicado en números.<br />"; }
        
        if ($errors == 0) { 
		extract($_POST);
$updatequery= doquery("UPDATE {{table}} SET
email='$email', verify='$verify', charname='$charname', autorizacion='$autorizacion', latitude='$latitude',
longitude='$longitude', difficulty='$difficulty',  charclass='$charclass', charrace='$charrace', currentaction='$currentaction', currentfight='$currentfight',
currentmonster='$currentmonster', currentmonsterhp='$currentmonsterhp', currentmonstersleep='$currentmonstersleep', currentmonsterimmune='$currentmonsterimmune', currentuberdamage='$currentuberdamage',
currentuberdefense='$currentuberdefense', currenthp='$currenthp', currentmp='$currentmp', currenttp='$currenttp', maxhp='$maxhp',
maxmp='$maxmp', maxtp='$maxtp', nivel='$nivel', gold='$gold', banco='$banco', experience='$experience',
goldbonus='$goldbonus', expbonus='$expbonus', strength='$strength', dexterity='$dexterity', attackpower='$attackpower',
defensepower='$defensepower', weaponid='$weaponid', armorid='$armorid', shieldid='$shieldid', slot1id='$slot1id',
slot2id='$slot2id', slot3id='$slot3id', weaponname='$weaponname', armorname='$armorname', shieldname='$shieldname',
slot1name='$slot1name', slot2name='$slot2name', slot3name='$slot3name', dropcode='$dropcode', spells='$spells',
towns='$towns' WHERE id='$id'" , "usuarios");
            admindisplay("Usuario Actualizado.","Editar Usuarios");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />Retroceda y vuelva a intentarlo.", "Editar Usuarios");
        }        
        
    }   
break;

case 'editarnivel' :

 if (!isset($_POST["level"])) { admindisplay("No hay nivel para editar.", "Editar Niveles"); die(); }
   
    
    if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($_POST["one_exp"] == "") { $errors++; $errorlist .= "Experiencia de la Raza 1 es requerida.<br />"; }
        if ($_POST["one_hp"] == "") { $errors++; $errorlist .= "PV de la Raza 1 es requerida.<br />"; }
        if ($_POST["one_mp"] == "") { $errors++; $errorlist .= "PM de la Raza 1 es requerida.<br />"; }
        if ($_POST["one_tp"] == "") { $errors++; $errorlist .= "PR de la Raza 1 es requerida.<br />"; }
        if ($_POST["one_strength"] == "") { $errors++; $errorlist .= "Fuerza de la Raza 1 es requerida.<br />"; }
        if ($_POST["one_dexterity"] == "") { $errors++; $errorlist .= "Destreza de la Raza 1 es requerida.<br />"; }
        if ($_POST["one_spells"] == "") { $errors++; $errorlist .= "Habilidades de la Raza 1 es requerida.<br />"; }
        if (!is_numeric($_POST["one_exp"])) { $errors++; $errorlist .= "Experiencia de la Raza 1 debe ser un número.<br />"; }
        if (!is_numeric($_POST["one_hp"])) { $errors++; $errorlist .= "PV de la Raza 1 debe ser un número.<br />"; }
        if (!is_numeric($_POST["one_mp"])) { $errors++; $errorlist .= "PM de la Raza 1 debe ser un número.<br />"; }
        if (!is_numeric($_POST["one_tp"])) { $errors++; $errorlist .= "PR de la Raza 1 debe ser un número.<br />"; }
        if (!is_numeric($_POST["one_strength"])) { $errors++; $errorlist .= "Fuerza de la Raza 1 debe ser un número.<br />"; }
        if (!is_numeric($_POST["one_dexterity"])) { $errors++; $errorlist .= "Destreza de la Raza 1 debe ser un número.<br />"; }
        if (!is_numeric($_POST["one_spells"])) { $errors++; $errorlist .= "Habilidades de la Raza 1 deben ser números.<br />"; }

        if ($_POST["two_exp"] == "") { $errors++; $errorlist .= "Experiencia de la Raza 2 es requerida.<br />"; }
        if ($_POST["two_hp"] == "") { $errors++; $errorlist .= "PV de la Raza 2 es requerida.<br />"; }
        if ($_POST["two_mp"] == "") { $errors++; $errorlist .= "PM de la Raza 2 es requerida.<br />"; }
        if ($_POST["two_tp"] == "") { $errors++; $errorlist .= "PR de la Raza 2 es requerida.<br />"; }
        if ($_POST["two_strength"] == "") { $errors++; $errorlist .= "Fuerza de la Raza 2 es requerida.<br />"; }
        if ($_POST["two_dexterity"] == "") { $errors++; $errorlist .= "Destreza de la Raza 2 es requerida.<br />"; }
        if ($_POST["two_spells"] == "") { $errors++; $errorlist .= "Habilidades de la Raza 2 es requerida.<br />"; }
        if (!is_numeric($_POST["two_exp"])) { $errors++; $errorlist .= "Experiencia de la Raza 2 debe ser un número.<br />"; }
        if (!is_numeric($_POST["two_hp"])) { $errors++; $errorlist .= "PV de la Raza 2 debe ser un número.<br />"; }
        if (!is_numeric($_POST["two_mp"])) { $errors++; $errorlist .= "PM de la Raza 2 debe ser un número.<br />"; }
        if (!is_numeric($_POST["two_tp"])) { $errors++; $errorlist .= "PR de la Raza 2 debe ser un número.<br />"; }
        if (!is_numeric($_POST["two_strength"])) { $errors++; $errorlist .= "Fuerza de la Raza 2 debe ser un número.<br />"; }
        if (!is_numeric($_POST["two_dexterity"])) { $errors++; $errorlist .= "Destreza de la Raza 2 debe ser un número.<br />"; }
        if (!is_numeric($_POST["two_spells"])) { $errors++; $errorlist .= "Habilidades de la Raza 2 deben ser números.<br />"; }
                
        if ($_POST["three_exp"] == "") { $errors++; $errorlist .= "Experiencia de la Raza 3 es requerida.<br />"; }
        if ($_POST["three_hp"] == "") { $errors++; $errorlist .= "PV de la Raza 3 es requerida.<br />"; }
        if ($_POST["three_mp"] == "") { $errors++; $errorlist .= "PM de la Raza 3 es requerida.<br />"; }
        if ($_POST["three_tp"] == "") { $errors++; $errorlist .= "PR de la Raza 3 es requerida.<br />"; }
        if ($_POST["three_strength"] == "") { $errors++; $errorlist .= "Fuerza de la Raza 3 es requerida.<br />"; }
        if ($_POST["three_dexterity"] == "") { $errors++; $errorlist .= "Destreza de la Raza 3 es requerida.<br />"; }
        if ($_POST["three_spells"] == "") { $errors++; $errorlist .= "Habilidades de la Raza 3 es requerida.<br />"; }
        if (!is_numeric($_POST["three_exp"])) { $errors++; $errorlist .= "Experiencia de la Raza 3 debe ser un número.<br />"; }
        if (!is_numeric($_POST["three_hp"])) { $errors++; $errorlist .= "PV de la Raza 3 debe ser un número.<br />"; }
        if (!is_numeric($_POST["three_mp"])) { $errors++; $errorlist .= "PM de la Raza 3 debe ser un número.<br />"; }
        if (!is_numeric($_POST["three_tp"])) { $errors++; $errorlist .= "PR de la Raza 3 debe ser un número.<br />"; }
        if (!is_numeric($_POST["three_strength"])) { $errors++; $errorlist .= "Fuerza de la Raza 3 debe ser un número.<br />"; }
        if (!is_numeric($_POST["three_dexterity"])) { $errors++; $errorlist .= "Destreza de la Raza 3 debe ser un número.<br />"; }
        if (!is_numeric($_POST["three_spells"])) { $errors++; $errorlist .= "Habilidades de la Raza 3 deben ser números.<br />"; }

        if ($errors == 0) { 
$updatequery = <<<END
UPDATE {{table}} SET
1_exp='$one_exp', 1_hp='$one_hp', 1_mp='$one_mp', 1_tp='$one_tp', 1_strength='$one_strength', 1_dexterity='$one_dexterity', 1_spells='$one_spells',
2_exp='$two_exp', 2_hp='$two_hp', 2_mp='$two_mp', 2_tp='$two_tp', 2_strength='$two_strength', 2_dexterity='$two_dexterity', 2_spells='$two_spells',
3_exp='$three_exp', 3_hp='$three_hp', 3_mp='$three_mp', 3_tp='$three_tp', 3_strength='$three_strength', 3_dexterity='$three_dexterity', 3_spells='$three_spells'
WHERE id='$id' LIMIT 1
END;
			$query = doquery($updatequery, "niveles");
            admindisplay("Niveles Actualizados.","Editar Niveles");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />Retroceda y vuelva a intetarlo.", "Editar Niveles");
        }        
        
    }   
 break;
 
case 'editaritem' :
if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Se requiere un nombre.<br />"; }
        if ($buycost == "") { $errors++; $errorlist .= "Se requiere un precio.<br />"; }
        if (!is_numeric($buycost)) { $errors++; $errorlist .= "El precio debe ser numérico.<br />"; }
        if ($attribute == "") { $errors++; $errorlist .= "Se requiere un atributo.<br />"; }
        if (!is_numeric($attribute)) { $errors++; $errorlist .= "El atributo debe ser numérico.<br />"; }
        if ($special == "" || $special == " ") { $special = "X"; }
        
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',type='$type',buycost='$buycost',attribute='$attribute',special='$special' WHERE id='$id' LIMIT 1", "items");
            admindisplay("Actualizado.","Editar Items");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />.", "Editar Items");
        }        
        
    }   
break;

case 'editarciudad' :

if (isset($_POST["submit"])) {
            $id = $_POST['id'];
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Se requiere un nombre.<br />"; }
        if ($latitude == "") { $errors++; $errorlist .= "Se requiere una latitud.<br />"; }
        if (!is_numeric($latitude)) { $errors++; $errorlist .= "La latitud debe ser un número.<br />"; }
        if ($longitude == "") { $errors++; $errorlist .= "Se requiere una longitud.<br />"; }
        if (!is_numeric($longitude)) { $errors++; $errorlist .= "La longitud debe ser un número.<br />"; }
        if ($innprice == "") { $errors++; $errorlist .= "Se requiere un precio para el hotel.<br />"; }
        if (!is_numeric($innprice)) { $errors++; $errorlist .= "El precio del hotel debe ser un número.<br />"; }
        if ($mapprice == "") { $errors++; $errorlist .= "Se requiere un precio para el mapa.<br />"; }
        if (!is_numeric($mapprice)) { $errors++; $errorlist .= "El precio del mapa debe ser un número.<br />"; }

        if ($travelpoints == "") { $errors++; $errorlist .= "Se requiere los Puntos de Recorrido.<br />"; }
        if (!is_numeric($travelpoints)) { $errors++; $errorlist .= "Los Puntos de Recorrido deben estar en números.<br />"; }
        if ($itemslist == "") { $errors++; $errorlist .= "Se requiere la lista de items.<br />"; }
        
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',latitude='$latitude',longitude='$longitude',innprice='$innprice',mapprice='$mapprice',travelpoints='$travelpoints',itemslist='$itemslist' WHERE id='$id' LIMIT 1", "ciudades");
            admindisplay("Ciudades actualizadas.","Editar Ciudades");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />Retroceda y vuelva a intentarlo.", "Editar Ciudades");
        }        
        
    }   
        
break;

case 'editarmonstruo' :
  if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Se requiere un nombre.<br />"; }
        if ($maxhp == "") { $errors++; $errorlist .= "Se requiere un PV Máx.<br />"; }
        if (!is_numeric($maxhp)) { $errors++; $errorlist .= "Los PV Máx deben ser números.<br />"; }
        if ($maxdam == "") { $errors++; $errorlist .= "Se requiere un Daño Máximo.<br />"; }
        if (!is_numeric($maxdam)) { $errors++; $errorlist .= "El Daño Máximo debe estar indicado en números.<br />"; }
        if ($armor == "") { $errors++; $errorlist .= "Se requiere Armadura.<br />"; }
        if (!is_numeric($armor)) { $errors++; $errorlist .= "La Armadura debe ser indicada en números.<br />"; }
        if ($nivel == "") { $errors++; $errorlist .= "Se requiere un Nivel del Monstruo.<br />"; }
        if (!is_numeric($nivel)) { $errors++; $errorlist .= "El Nivel del Monstruo debe estar indicado en números.<br />"; }
        if ($maxexp == "") { $errors++; $errorlist .= "Se requiere una Experiencia Máxima.<br />"; }
        if (!is_numeric($maxexp)) { $errors++; $errorlist .= "La Experiencia Máxima debe estar indicada en números.<br />"; }
        if ($maxgold == "") { $errors++; $errorlist .= "Se requiere un Oro Máximo.<br />"; }
        if (!is_numeric($maxgold)) { $errors++; $errorlist .= "El Oro Máximo debe estar indicado en números.<br />"; }
        
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',maxhp='$maxhp',maxdam='$maxdam',armor='$armor',nivel='$nivel',maxexp='$maxexp',maxgold='$maxgold',immune='$immune' WHERE id='$id' LIMIT 1", "monstruos");
            admindisplay("Monstruos Actualizados.","Editar Monstruos");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />Retroceda y vuelva a intentarlo.", "Editar Monstruos");
        }        
        
    }   
       
break;

case 'editardrop' :
  if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Nombre requerido.<br />"; }
        if ($mnivel == "") { $errors++; $errorlist .= "Nivel de Monstruo requerido.<br />"; }
        if (!is_numeric($mnivel)) { $errors++; $errorlist .= "El nivel del monstruo debe ser un número.<br />"; }
        if ($attribute1 == "" || $attribute1 == " " || $attribute1 == "X") { $errors++; $errorlist .= "Se requiere un atributo.<br />"; }
        if ($attribute2 == "" || $attribute2 == " ") { $attribute2 = "X"; }
        
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',mnivel='$mnivel',attribute1='$attribute1',attribute2='$attribute2' WHERE id='$id' LIMIT 1", "drops");
            admindisplay("Item actualizado.","Editar Drops");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />Retroceda y vuelva a intentarlo.", "Editar Drops");
        }        
        
    }   
break;

case 'editarhabilidad' :

if (isset($_POST["submit"])) {
        
        extract($_POST);
        $errors = 0;
        $errorlist = "";
        if ($name == "") { $errors++; $errorlist .= "Se requiere un Nombre.<br />"; }
        if ($mp == "") { $errors++; $errorlist .= "Se requiere un PM.<br />"; }
        if (!is_numeric($mp)) { $errors++; $errorlist .= "Los PM deben estar indicados en números.<br />"; }
        if ($attribute == "") { $errors++; $errorlist .= "Se requiere un atributo.<br />"; }
        if (!is_numeric($attribute)) { $errors++; $errorlist .= "Los atributos deben estar indicados en números.<br />"; }
        
        if ($errors == 0) { 
            $query = doquery("UPDATE {{table}} SET name='$name',mp='$mp',attribute='$attribute',type='$type' WHERE id='$id' LIMIT 1", "habilidades");
            admindisplay("Habilidades Actualzadas.","Editar Habilidades");
        } else {
            admindisplay("<b>Errores:</b><br /><div style=\"color:red;\">$errorlist</div><br />Retroceda y vuelva a intentarlo.", "Editar Habilidades");
        }        
        
    }   
break;

case 'borrarusuario' :
$id= $_POST['id'];
$query= doquery("delete from {{table}} where id=$id", "usuarios");
admindisplay("Usuario borrado con exito.","Borrado de usuarios");
break;

}