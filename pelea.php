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
function fight() { // Esta función determina la pelea
    
    global $userrow, $controlrow;
    if ($userrow["currentaction"] != "Peleando") { display("Se detecto el uso de Cheats.<br /><br />", "Error"); }
    $pagearray = array();
    $playerisdead = 0;
    
    $pagearray["magiclist"] = "";
    $userspells = explode(",",$userrow["spells"]);
    $spellquery = doquery("SELECT id,name FROM {{table}}", "habilidades");
    while ($spellrow = mysql_fetch_array($spellquery)) {
        $spell = false;
        foreach ($userspells as $a => $b) {
            if ($b == $spellrow["id"]) { $spell = true; }
        }
        if ($spell == true) {
            $pagearray["magiclist"] .= "<option value=\"".$spellrow["id"]."\">".$spellrow["name"]."</option>\n";
        }
        unset($spell);
    }
    if ($pagearray["magiclist"] == "") { $pagearray["magiclist"] = "<option value=\"0\">Nada</option>\n"; }
    $magiclist = $pagearray["magiclist"];
    
    $chancetoswingfirst = 1;

    // Mira si necesita elegir monstruo.
    if ($userrow["currentfight"] == 1) {
        
        if ($userrow["latitude"] < 0) { $userrow["latitude"] *= -1; } // Negativos
        if ($userrow["longitude"] < 0) { $userrow["longitude"] *= -1; }
        $maxlevel = floor(max($userrow["latitude"]+5, $userrow["longitude"]+5) / 5); // Un nivel más cada 5 espacios.
        if ($maxlevel < 1) { $maxlevel = 1; }
        $minlevel = $maxlevel - 2;
        if ($minlevel < 1) { $minlevel = 1; }
        
        
        // Elegir monstruo.
        $monsterquery = doquery("SELECT * FROM {{table}} WHERE nivel>='$minlevel' AND nivel<='$maxlevel' ORDER BY RAND() LIMIT 1", "monstruos");
        $monsterrow = mysql_fetch_array($monsterquery);
        $userrow["currentmonster"] = $monsterrow["id"];
        $userrow["currentmonsterhp"] = rand((($monsterrow["maxhp"]/5)*4),$monsterrow["maxhp"]);
        if ($userrow["difficulty"] == 2) { $userrow["currentmonsterhp"] = ceil($userrow["currentmonsterhp"] * $controlrow["diff2mod"]); }
        if ($userrow["difficulty"] == 3) { $userrow["currentmonsterhp"] = ceil($userrow["currentmonsterhp"] * $controlrow["diff3mod"]); }
        $userrow["currentmonstersleep"] = 0;
        $userrow["currentmonsterimmune"] = $monsterrow["immune"];
        
        $chancetoswingfirst = rand(1,10) + ceil(sqrt($userrow["dexterity"]));
        if ($chancetoswingfirst > (rand(1,7) + ceil(sqrt($monsterrow["maxdam"])))) { $chancetoswingfirst = 1; } else { $chancetoswingfirst = 0; }
        
        unset($monsterquery);
        unset($monsterrow);
        
    }
    
    // Estadisticas del Monstruo.
    $monsterquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["currentmonster"]."' LIMIT 1", "monstruos");
    $monsterrow = mysql_fetch_array($monsterquery);
    $pagearray["monstername"] = $monsterrow["name"];
    
    // Correr información.
    if (isset($_POST["run"])) {

        $chancetorun = rand(4,10) + ceil(sqrt($userrow["dexterity"]));
        if ($chancetorun > (rand(1,5) + ceil(sqrt($monsterrow["maxdam"])))) { $chancetorun = 1; } else { $chancetorun = 0; }
        
        if ($chancetorun == 0) { 
		    $pagearray["monsterimg"] = "<img src=\"estilo/imagenes/monstruos/".$userrow["currentmonster"].".jpg\" />";
            $pagearray["yourturn"] = "Intentas correr pero te bloquearon!<br /><br />";
            $pagearray["monsterhp"] = "PV del Monstruo: " . $userrow["currentmonsterhp"] . "<br /><br />";
            $pagearray["monsterturn"] = "";
            if ($userrow["currentmonstersleep"] != 0) { // Cuando se despertará.
                $chancetowake = rand(1,15);
                if ($chancetowake > $userrow["currentmonstersleep"]) {
                    $userrow["currentmonstersleep"] = 0;
                    $pagearray["monsterturn"] .= "El monstruo se despertó.<br />";
                } else {
                    $pagearray["monsterturn"] .= "El monstruo sigue dormido.<br />";
                }
            }
            if ($userrow["currentmonstersleep"] == 0) { // Solo hace esto si el monstruo sigue dormido.
                $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
                if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
                if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
                $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
                $tododge = rand(1,150);
                if ($tododge <= sqrt($userrow["dexterity"])) {
                    $tohit = 0; $pagearray["monsterturn"] .= "Esquivas el ataque del monstruo y no recibes daño.<br />";
                    $persondamage = 0;
                } else {
                    $persondamage = $tohit - $toblock;
                    if ($persondamage < 1) { $persondamage = 1; }
                    if ($userrow["currentuberdefense"] != 0) {
                        $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                    }
                    if ($persondamage < 1) { $persondamage = 1; }
                }
                $pagearray["monsterturn"] .= "El monstruo te atacó. Pierdes: $persondamage Puntos de Vida.<br /><br />";
                $userrow["currenthp"] -= $persondamage;
                if ($userrow["currenthp"] <= 0) {
                    $newgold = ceil($userrow["gold"]/2);
                    $newhp = ceil($userrow["maxhp"]/4);
                    $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En la ciudad',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
                    $playerisdead = 1;
                }
            }
        }

        $updatequery = doquery("UPDATE {{table}} SET currentaction='Explorando' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
        header("Location: index.php");
        die();
        
    // Configuración de Pelea.
    } elseif (isset($_POST["fight"])) {
        
        // Tu turno.
        $pagearray["yourturn"] = "";
        $tohit = ceil(rand($userrow["attackpower"]*.75,$userrow["attackpower"])/3);
        $toexcellent = rand(1,150);
        if ($toexcellent <= sqrt($userrow["strength"])) { $tohit *= 2; $pagearray["yourturn"] .= "Golpe excelente!<br />"; }
        $toblock = ceil(rand($monsterrow["armor"]*.75,$monsterrow["armor"])/3);        
        $tododge = rand(1,200);
        if ($tododge <= sqrt($monsterrow["armor"])) { 
            $tohit = 0; $pagearray["yourturn"] .= "El monstruo ha esquivado tu ataque. No recibe daño.<br />"; 
            $monsterdamage = 0;
        } else {
            $monsterdamage = $tohit - $toblock;
            if ($monsterdamage < 1) { $monsterdamage = 1; }
            if ($userrow["currentuberdamage"] != 0) {
                $monsterdamage += ceil($monsterdamage * ($userrow["currentuberdamage"]/100));
            }
        }
        $pagearray["yourturn"] .= "Atacas al monstruo. Pierde $monsterdamage Puntos de Vida.<br /><br />";
        $userrow["currentmonsterhp"] -= $monsterdamage;
        $pagearray["monsterhp"] = "PV del Monstruo: " . $userrow["currentmonsterhp"] . "<br /><br />";
        if ($userrow["currentmonsterhp"] <= 0) {
            $updatequery = doquery("UPDATE {{table}} SET currentmonsterhp='0' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
            header("Location: index.php?do=victoria");
            die();
        }
        
        // Turno del Monstruo.
        $pagearray["monsterturn"] = "";
        if ($userrow["currentmonstersleep"] != 0) { // Cuando se despertará.
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $pagearray["monsterturn"] .= "El monstruo se despertó.<br />";
            } else {
                $pagearray["monsterturn"] .= "El monstruo continua dormido.<br />";
            }
        }
        if ($userrow["currentmonstersleep"] == 0) { // Solo hace esto si el monstruo sigue dormido.
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; $pagearray["monsterturn"] .= "Rápidamente esquivas el ataque del monstruo y no recibes daño.<br />";
                $persondamage = 0;
            } else {
                $persondamage = $tohit - $toblock;
                if ($persondamage < 1) { $persondamage = 1; }
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $pagearray["monsterturn"] .= "El monstruo te ha atacado. Pierdes $persondamage Puntos de Vida.<br /><br />";
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En la ciudad',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
                $playerisdead = 1;
            }
        }
        
    // Habilidades.
    } elseif (isset($_POST["spell"])) {
        
        // Tu turno.
        $pickedspell = $_POST["userspell"];
        if ($pickedspell == 0) { display("<div class='contenido2'>Necesitas elegir un ataque, por favor, vuelve e intentalo de nuevo.</div>", "Error"); die(); }
        
        $newspellquery = doquery("SELECT * FROM {{table}} WHERE id='$pickedspell' LIMIT 1", "habilidades");
        $newspellrow = mysql_fetch_array($newspellquery);
        $spell = false;
        foreach($userspells as $a => $b) {
            if ($b == $pickedspell) { $spell = true; }
        }
        if ($spell != true) { display("<div class='contenido2'>Todavia no has aprendido ningún ataque especial. Vuelve atras e intentalo de nuevo.</div>", "Error"); die(); }
        if ($userrow["currentmp"] < $newspellrow["mp"]) { display("<div class='contenido2'>No tienes suficientes Puntos de Magia. Vuelve atras e intentalo de nuevo.</div>", "Error"); die(); }
        
        if ($newspellrow["type"] == 1) { // Curando.
            $newhp = $userrow["currenthp"] + $newspellrow["attribute"];
            if ($userrow["maxhp"] < $newhp) { $newspellrow["attribute"] = $userrow["maxhp"] - $userrow["currenthp"]; $newhp = $userrow["currenthp"] + $newspellrow["attribute"]; }
            $userrow["currenthp"] = $newhp;
            $userrow["currentmp"] -= $newspellrow["mp"];
            $pagearray["yourturn"] = "Usas: ".$newspellrow["name"]." y recuperas ".$newspellrow["attribute"]." Puntos de Vida.<br /><br />";
        } elseif ($newspellrow["type"] == 2) { // Dañando.
            if ($userrow["currentmonsterimmune"] == 0) {
                $monsterdamage = rand((($newspellrow["attribute"]/6)*5), $newspellrow["attribute"]);
                $userrow["currentmonsterhp"] -= $monsterdamage;
                $pagearray["yourturn"] = "Usas: ".$newspellrow["name"]." y atacas al monstruo. El monstruo pierde: $monsterdamage Puntos de Vida.<br /><br />";
            } else {
	                $pagearray["yourturn"] = "Usas: ".$newspellrow["name"]." pero el monstruo es immune a ese ataque.<br /><br />";
            }
            $userrow["currentmp"] -= $newspellrow["mp"];
        } elseif ($newspellrow["type"] == 3) { // Durmiendo.
            if ($userrow["currentmonsterimmune"] != 2) {
                $userrow["currentmonstersleep"] = $newspellrow["attribute"];
                $pagearray["yourturn"] = "Usas: ".$newspellrow["name"].". El monstruo está dormido.<br /><br />";
            } else {
                $pagearray["yourturn"] = "Usas: ".$newspellrow["name"]." pero el monstruo es immune a el.<br /><br />";
            }
            $userrow["currentmp"] -= $newspellrow["mp"];
        } elseif ($newspellrow["type"] == 4) { // +Aura A.
            $userrow["currentuberdamage"] = $newspellrow["attribute"];
            $userrow["currentmp"] -= $newspellrow["mp"];
            $pagearray["yourturn"] = "Usas: ".$newspellrow["name"]." y ganas ".$newspellrow["attribute"]."% de ataque hasta el final de la pelea.<br /><br />";
        } elseif ($newspellrow["type"] == 5) { // +Aura D.
            $userrow["currentuberdefense"] = $newspellrow["attribute"];
            $userrow["currentmp"] -= $newspellrow["mp"];
            $pagearray["yourturn"] = "Usas: ".$newspellrow["name"]." y ganas ".$newspellrow["attribute"]."% de defensa hasta el final de la pelea.<br /><br />";            
        }
            
        $pagearray["monsterhp"] = "PV del Monstruo: " . $userrow["currentmonsterhp"] . "<br /><br />";
        if ($userrow["currentmonsterhp"] <= 0) {
            $updatequery = doquery("UPDATE {{table}} SET currentmonsterhp='0',currenthp='".$userrow["currenthp"]."',currentmp='".$userrow["currentmp"]."' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
            header("Location: index.php?do=victoria");
            die();
        }
        
        // Turno del monstruo.
        $pagearray["monsterturn"] = "";
        if ($userrow["currentmonstersleep"] != 0) { // Cuando se despertará.
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $pagearray["monsterturn"] .= "El monstruo se despertó.<br />";
            } else {
                $pagearray["monsterturn"] .= "El monstruo continua dormido.<br />";
            }
        }
        if ($userrow["currentmonstersleep"] == 0) { // Solo hace esto si el monstruo sigue durmiendo.
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; $pagearray["monsterturn"] .= "Esquivas el ataque del monstruo. No recibes daño.<br />";
                $persondamage = 0;
            } else {
                if ($tohit <= $toblock) { $tohit = $toblock + 1; }
                $persondamage = $tohit - $toblock;
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $pagearray["monsterturn"] .= "El monstruo te atacó. Pierdes: $persondamage Puntos de Vida.<br /><br />";
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En la ciudad',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
                $playerisdead = 1;
            }
        }
    
    // Primer turno del monstruo!
    } elseif ( $chancetoswingfirst == 0 ) {
        $pagearray["yourturn"] = "El monstruo te atacó antes de que estes preparado.!<br /><br />";
        $pagearray["monsterhp"] = "PV del Monstruo: " . $userrow["currentmonsterhp"] . "<br /><br />";
        $pagearray["monsterturn"] = "";
        if ($userrow["currentmonstersleep"] != 0) { // Cuando se despertará.
            $chancetowake = rand(1,15);
            if ($chancetowake > $userrow["currentmonstersleep"]) {
                $userrow["currentmonstersleep"] = 0;
                $pagearray["monsterturn"] .= "El monstruo se despertó.<br />";
            } else {
                $pagearray["monsterturn"] .= "El monstruo continua dormido.<br />";
            }
        }
        if ($userrow["currentmonstersleep"] == 0) { // Solo hace esto si el monstruo sigue durmiendo.
            $tohit = ceil(rand($monsterrow["maxdam"]*.5,$monsterrow["maxdam"]));
            if ($userrow["difficulty"] == 2) { $tohit = ceil($tohit * $controlrow["diff2mod"]); }
            if ($userrow["difficulty"] == 3) { $tohit = ceil($tohit * $controlrow["diff3mod"]); }
            $toblock = ceil(rand($userrow["defensepower"]*.75,$userrow["defensepower"])/4);
            $tododge = rand(1,150);
            if ($tododge <= sqrt($userrow["dexterity"])) {
                $tohit = 0; $pagearray["monsterturn"] .= "Esquivas el ataque del monstruo. No recibes daño.<br />";
                $persondamage = 0;
            } else {
                $persondamage = $tohit - $toblock;
                if ($persondamage < 1) { $persondamage = 1; }
                if ($userrow["currentuberdefense"] != 0) {
                    $persondamage -= ceil($persondamage * ($userrow["currentuberdefense"]/100));
                }
                if ($persondamage < 1) { $persondamage = 1; }
            }
            $pagearray["monsterturn"] .= "El monstruo te atacó. Pierdes: $persondamage Puntos de Vida.<br /><br />";
            $userrow["currenthp"] -= $persondamage;
            if ($userrow["currenthp"] <= 0) {
                $newgold = ceil($userrow["gold"]/2);
                $newhp = ceil($userrow["maxhp"]/4);
                $updatequery = doquery("UPDATE {{table}} SET currenthp='$newhp',currentaction='En la ciudad',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentfight='0',latitude='0',longitude='0',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
                $playerisdead = 1;
            }
        }

    } else {
        $pagearray["yourturn"] = "";
        $pagearray["monsterhp"] = "PV del Monstruo: " . $userrow["currentmonsterhp"] . "<br /><br />";
        $pagearray["monsterturn"] = "";
    }
    
    $newmonster = $userrow["currentmonster"];

    $newmonsterhp = $userrow["currentmonsterhp"];
    $newmonstersleep = $userrow["currentmonstersleep"];
    $newmonsterimmune = $userrow["currentmonsterimmune"];
    $newuberdamage = $userrow["currentuberdamage"];
    $newuberdefense = $userrow["currentuberdefense"];
    $newfight = $userrow["currentfight"] + 1;
    $newhp = $userrow["currenthp"];
    $newmp = $userrow["currentmp"];    
    
if ($playerisdead != 1) { 
$pagearray["command"] = <<<END
¿ Que quieres hacer ?<br /><br />
<form action="index.php?do=pelear" method="post">
<input type="submit" name="fight" value="Atacar" /><br /><br />
<select name="userspell"><option value="0">Elija uno:</option>$magiclist</select> <input type="submit" name="spell" value="Usar Magia" /><br /><br />
<input type="submit" name="run" value="Correr" /><br /><br />
</form>
END;
    $updatequery = doquery("UPDATE {{table}} SET currentaction='Peleando',currenthp='$newhp',currentmp='$newmp',currentfight='$newfight',currentmonster='$newmonster',currentmonsterhp='$newmonsterhp',currentmonstersleep='$newmonstersleep',currentmonsterimmune='$newmonsterimmune',currentuberdamage='$newuberdamage',currentuberdefense='$newuberdefense' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
} else {
    $pagearray["command"] = "<b>Has muerto.</b><br />También has perdido la mitad de tu oro. Ahora tienes que volver a descanzar para sentirte mejor y continuar con tu viaje.<br /><br />Vuelve a <a href=\"index.php\">La ciudad</a>, y cuidate para la próxima vez.";
}
    
    // Finalización.
	$pagearray["monsterimg"] = "<img src=\"estilo/imagenes/monstruos/".$userrow["currentmonster"].".jpg\" />";
    $template = gettemplate("pelea");
    $page = parsetemplate($template,$pagearray);
    
    display($page, "Peleando");
    
}

function victory() {
    
    global $userrow, $controlrow;
    
    if ($userrow["currentmonsterhp"] != 0) { header("Location: index.php?do=pelear"); die(); }
    if ($userrow["currentfight"] == 0) { header("Location: index.php"); die(); }
    
    $monsterquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["currentmonster"]."' LIMIT 1", "monstruos");
    $monsterrow = mysql_fetch_array($monsterquery);
    
    $exp = rand((($monsterrow["maxexp"]/6)*5),$monsterrow["maxexp"]);
    if ($exp < 1) { $exp = 1; }
    if ($userrow["difficulty"] == 2) { $exp = ceil($exp * $controlrow["diff2mod"]); }
    if ($userrow["difficulty"] == 3) { $exp = ceil($exp * $controlrow["diff3mod"]); }
    if ($userrow["expbonus"] != 0) { $exp += ceil(($userrow["expbonus"]/100)*$exp); }
    $gold = rand((($monsterrow["maxgold"]/6)*5),$monsterrow["maxgold"]);
    if ($gold < 1) { $gold = 1; }
    if ($userrow["difficulty"] == 2) { $gold = ceil($gold * $controlrow["diff2mod"]); }
    if ($userrow["difficulty"] == 3) { $gold = ceil($gold * $controlrow["diff3mod"]); }
    if ($userrow["goldbonus"] != 0) { $gold += ceil(($userrow["goldbonus"]/100)*$exp); }
    if ($userrow["experience"] + $exp < 16777215) { $newexp = $userrow["experience"] + $exp; $warnexp = ""; } else { $newexp = $userrow["experience"]; $exp = 0; $warnexp = "Has máximizado tus puntos de experiencia."; }
    if ($userrow["gold"] + $gold < 16777215) { $newgold = $userrow["gold"] + $gold; $warngold = ""; } else { $newgold = $userrow["gold"]; $gold = 0; $warngold = "Has máximizado tus puntos de experiencia."; }
    
    $levelquery = doquery("SELECT * FROM {{table}} WHERE id='".($userrow["nivel"]+1)."' LIMIT 1", "niveles");
    if (mysql_num_rows($levelquery) == 1) { $levelrow = mysql_fetch_array($levelquery); }
    
    if ($userrow["nivel"] < 100) {
        if ($newexp >= $levelrow[$userrow["charclass"]."_exp"]) {
            $newhp = $userrow["maxhp"] + $levelrow[$userrow["charclass"]."_hp"];
            $newmp = $userrow["maxmp"] + $levelrow[$userrow["charclass"]."_mp"];
            $newtp = $userrow["maxtp"] + $levelrow[$userrow["charclass"]."_tp"];
            $newstrength = $userrow["strength"] + $levelrow[$userrow["charclass"]."_strength"];
            $newdexterity = $userrow["dexterity"] + $levelrow[$userrow["charclass"]."_dexterity"];
            $newattack = $userrow["attackpower"] + $levelrow[$userrow["charclass"]."_strength"];
            $newdefense = $userrow["defensepower"] + $levelrow[$userrow["charclass"]."_dexterity"];
            $newlevel = $levelrow["id"];
            
            if ($levelrow[$userrow["charclass"]."_spells"] != 0) {
                $userspells = $userrow["spells"] . ",".$levelrow[$userrow["charclass"]."_spells"];
                $newspell = "spells='$userspells',";
                $spelltext = "Has aprendido un nuevo ataque.<br />";
            } else { $spelltext = ""; $newspell=""; }
            
            $page = "<div class='titulo'>Victoria</div><div class='contenido2'>Felicitaciones. Has derrotado a un ".$monsterrow["name"].".<br />Ganas $exp puntos de experiencia. $warnexp <br />Ganas $gold Piezas de Oro. $warngold <br /><br /><b>Has pasado de nivel!</b><br /><br />Ganas ".$levelrow[$userrow["charclass"]."_hp"]." Puntos de Vida.<br />Ganas ".$levelrow[$userrow["charclass"]."_mp"]." Puntos de Magia.<br />Ganas ".$levelrow[$userrow["charclass"]."_tp"]." Puntos de Recorrido.<br />Ganas ".$levelrow[$userrow["charclass"]."_strength"]." de Fuerza.<br />Ganas ".$levelrow[$userrow["charclass"]."_dexterity"]." de Destreza.<br />$spelltext<br />Puedes continuar <a href=\"index.php\">explorando</a>.</div>";
            $title = "Caballero, El valor y el ingenio te han servido!";
            $dropcode = "";
        } else {
            $newhp = $userrow["maxhp"];
            $newmp = $userrow["maxmp"];
            $newtp = $userrow["maxtp"];
            $newstrength = $userrow["strength"];
            $newdexterity = $userrow["dexterity"];
            $newattack = $userrow["attackpower"];
            $newdefense = $userrow["defensepower"];
            $newlevel = $userrow["nivel"];
            $newspell = "";
            $page = "<div class='titulo'>Victoria</div><div class='contenido2'>Has derrotado a un ".$monsterrow["name"].".<br />Ganas $exp puntos de experiencia. $warnexp <br />Ganas $gold Piezas de Oro. $warngold <center><img src='estilo/imagenes/default/victoria.png' border=\"0\" alt=\"Victoria\" /></a></center><br /><br />";
            
            if (rand(1,30) == 1) {
                $dropquery = doquery("SELECT * FROM {{table}} WHERE mnivel <= '".$monsterrow["nivel"]."' ORDER BY RAND() LIMIT 1", "drops");
                $droprow = mysql_fetch_array($dropquery);
                $dropcode = "dropcode='".$droprow["id"]."',";
                $page .= "Este monstruo ha dejado un item. <br><a href=\"index.php?do=soltar\">Intentar agarrarlo</a><br> Continuar <a href=\"index.php\">explorando</a>.</div>";
            } else { 
                $dropcode = "";
                $page .= "Ahora puedes continuar <a href=\"index.php\">explorando</a>.</div>";
            }

            $title = "Victoria!";
        }
    }

    $updatequery = doquery("UPDATE {{table}} SET currentaction='Explorando',nivel='$newlevel',maxhp='$newhp',maxmp='$newmp',maxtp='$newtp',strength='$newstrength',dexterity='$newdexterity',attackpower='$newattack',defensepower='$newdefense', $newspell currentfight='0',currentmonster='0',currentmonsterhp='0',currentmonstersleep='0',currentmonsterimmune='0',currentuberdamage='0',currentuberdefense='0',$dropcode experience='$newexp',gold='$newgold' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
    

    display($page, $title);
    
}

function drop() {
    
    global $userrow;
    
    if ($userrow["dropcode"] == 0) { header("Location: index.php"); die(); }
    
    $dropquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["dropcode"]."' LIMIT 1", "drops");
    $droprow = mysql_fetch_array($dropquery);
    
    if (isset($_POST["submit"])) {
        
        $slot = $_POST["slot"];
        
        if ($slot == 0) { display("Por favor, vuelve y selecciona un espacio vacio en el inventario.","Error"); }
        
        if ($userrow["slot".$slot."id"] != 0) {
            
            $slotquery = doquery("SELECT * FROM {{table}} WHERE id='".$userrow["slot".$slot."id"]."' LIMIT 1", "drops");
            $slotrow = mysql_fetch_array($slotquery);
            
            $old1 = explode(",",$slotrow["attribute1"]);
            if ($slotrow["attribute2"] != "X") { $old2 = explode(",",$slotrow["attribute2"]); } else { $old2 = array(0=>"maxhp",1=>0); }
            $new1 = explode(",",$droprow["attribute1"]);
            if ($droprow["attribute2"] != "X") { $new2 = explode(",",$droprow["attribute2"]); } else { $new2 = array(0=>"maxhp",1=>0); }
            
            $userrow[$old1[0]] -= $old1[1];
            $userrow[$old2[0]] -= $old2[1];
            if ($old1[0] == "strength") { $userrow["attackpower"] -= $old1[1]; }
            if ($old1[0] == "dexterity") { $userrow["defensepower"] -= $old1[1]; }
            if ($old2[0] == "strength") { $userrow["attackpower"] -= $old2[1]; }
            if ($old2[0] == "dexterity") { $userrow["defensepower"] -= $old2[1]; }
            
            $userrow[$new1[0]] += $new1[1];
            $userrow[$new2[0]] += $new2[1];
            if ($new1[0] == "strength") { $userrow["attackpower"] += $new1[1]; }
            if ($new1[0] == "dexterity") { $userrow["defensepower"] += $new1[1]; }
            if ($new2[0] == "strength") { $userrow["attackpower"] += $new2[1]; }
            if ($new2[0] == "dexterity") { $userrow["defensepower"] += $new2[1]; }
            
            if ($userrow["currenthp"] > $userrow["maxhp"]) { $userrow["currenthp"] = $userrow["maxhp"]; }
            if ($userrow["currentmp"] > $userrow["maxmp"]) { $userrow["currentmp"] = $userrow["maxmp"]; }
            if ($userrow["currenttp"] > $userrow["maxtp"]) { $userrow["currenttp"] = $userrow["maxtp"]; }
            
            $newname = addslashes($droprow["name"]);
            $query = doquery("UPDATE {{table}} SET slot".$_POST["slot"]."name='$newname',slot".$_POST["slot"]."id='".$droprow["id"]."',$old1[0]='".$userrow[$old1[0]]."',$old2[0]='".$userrow[$old2[0]]."',$new1[0]='".$userrow[$new1[0]]."',$new2[0]='".$userrow[$new2[0]]."',attackpower='".$userrow["attackpower"]."',defensepower='".$userrow["defensepower"]."',currenthp='".$userrow["currenthp"]."',currentmp='".$userrow["currentmp"]."',currenttp='".$userrow["currenttp"]."',dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
            
        } else {
            
            $new1 = explode(",",$droprow["attribute1"]);
            if ($droprow["attribute2"] != "X") { $new2 = explode(",",$droprow["attribute2"]); } else { $new2 = array(0=>"maxhp",1=>0); }
            
            $userrow[$new1[0]] += $new1[1];
            $userrow[$new2[0]] += $new2[1];
            if ($new1[0] == "strength") { $userrow["attackpower"] += $new1[1]; }
            if ($new1[0] == "dexterity") { $userrow["defensepower"] += $new1[1]; }
            if ($new2[0] == "strength") { $userrow["attackpower"] += $new2[1]; }
            if ($new2[0] == "dexterity") { $userrow["defensepower"] += $new2[1]; }
            
            $newname = addslashes($droprow["name"]);
            $query = doquery("UPDATE {{table}} SET slot".$_POST["slot"]."name='$newname',slot".$_POST["slot"]."id='".$droprow["id"]."',$new1[0]='".$userrow[$new1[0]]."',$new2[0]='".$userrow[$new2[0]]."',attackpower='".$userrow["attackpower"]."',defensepower='".$userrow["defensepower"]."',dropcode='0' WHERE id='".$userrow["id"]."' LIMIT 1", "usuarios");
            
        }
        $page = "<div class='contenido2'>El item ha sido equipado. Puedes continuar <a href=\"index.php\">explorando</a>.</div>";
        display($page, "Item Caido");
        
    }
    
    $attributearray = array("maxhp"=>"PV Máxima",
                            "maxmp"=>"PM Máxima",
                            "maxtp"=>"PR Máxima",
                            "defensepower"=>"Poder de Defensa",
                            "attackpower"=>"Poder de Ataque",
                            "strength"=>"Fuerza",
                            "dexterity"=>"Destreza",
                            "expbonus"=>"Bonus de Exp",
                            "goldbonus"=>"Bonus de Oro");
    
    $page = "<div class='contenido2'>El monstruo dropeo el siguiente item: <b>".$droprow["name"]."</b><br /><br />";
    $page .= "El item tiene el/los siguiente(s) atributo(s):<br />";
    
    $attribute1 = explode(",",$droprow["attribute1"]);
    $page .= $attributearray[$attribute1[0]];
    if ($attribute1[1] > 0) { $page .= " +" . $attribute1[1] . "<br />"; } else { $page .= $attribute1[1] . "<br />"; }
    
    if ($droprow["attribute2"] != "X") { 
        $attribute2 = explode(",",$droprow["attribute2"]);
        $page .= $attributearray[$attribute2[0]];
        if ($attribute2[1] > 0) { $page .= " +" . $attribute2[1] . "<br />"; } else { $page .= $attribute2[1] . "<br />"; }
    }
    
    $page .= "<br />Selecciona un espacio en el inventario de la lista para equipar este item. Si el inventario está lleno, el antiguo item será descartado.";
    $page .= "<form action=\"index.php?do=soltar\" method=\"post\"><select name=\"slot\"><option value=\"0\">Elija uno:</option><option value=\"1\">Espacio 1: ".$userrow["slot1name"]."</option><option value=\"2\">Espacio 2: ".$userrow["slot2name"]."</option><option value=\"3\">Espacio 3: ".$userrow["slot3name"]."</option></select> <input type=\"submit\" name=\"submit\" value=\"Guardar Item\" /></form>";
    $page .= "Tambien puedes elegir continuar <a href=\"index.php\">explorando</a> y dejar este item.</div>";
    
    display($page, "Item Caido");
    
}
    

function dead() {
    
    $page = "<b>Has muerto!</b><br /><br />Como consecuencia has perdido parte de tu oro. Ahora debes volver a la ciudad y recuerda curarte en el hotel.<br /><br /><center><img src=\"imagenes/pelea/muerte.gif\" border=\"0\" alt=\"Has Muerto\" /></a></center><p>Vuelve a la<a href=\"index.php\">ciudad</a>, y ten cuidado la proxima vez.";
	
        
}



?>