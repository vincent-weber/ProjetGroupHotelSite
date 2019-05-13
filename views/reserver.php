<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../css/style.css">
      <title>Réservation</title>
      </head>
   <body>
   <?php component("topMenu"); ?>
   <div class="login-page">
   
    <div class="form">
	<h1>Réservation</h1><br>
        <form class="login-form" action="/reservation" method="post" >
		<label>Type de chambre :</label>
		<select name="typeChambre">
		<?php
		foreach($typechambres as $typeChambre){
			if(isset($_POST["typeChambre"]) && $typeChambre->nom_t == $_POST["typeChambre"])
				echo "<option value='$typeChambre->nom_t' selected>$typeChambre->nom_t - $typeChambre->prix_t €</option>";
			else
				echo "<option value='$typeChambre->nom_t'>$typeChambre->nom_t - $typeChambre->prix_t €</option>";
      }
   ?>
		</select><br>
		<label>Nombre de personnes</label>
		<input type="number" name="nbPersonnes" width="50px" placeholder="Nombre de personnes" min="1" <?php if(isset($_POST["nbPersonnes"])) { echo "value='".$_POST["nbPersonnes"]."'"; }else{ echo "value='1'";} ?> required>
        <label>Nombre de chambres</label>
		<input type="number" name="nbChambres" width="50px" placeholder="Nombre de chambres" min="1" <?php if(isset($_POST["nbChambres"])) { echo "value='".$_POST["nbChambres"]."'"; }else{ echo "value='1'";} ?> required>
		<label>Date de d'arrivée</label>
		<input type="date" name="dateArriver" placeholder="Date d'arrivée" <?php echo "min='".date("Y-m-d")."'"; if(isset($_POST["dateArriver"])){echo "value = '".$_POST["dateArriver"]."'";}else{echo "value = '".date("Y-m-d")."'";} ?> required>
		<label>Date de départ</label>
		<input type="date" name="dateDepart" placeholder="Date de départ" <?php echo "min='".date("Y-m-d",strtotime('tomorrow'))."'"; if(isset($_POST["dateDepart"])){echo "value = '".$_POST["dateDepart"]."'";}else{echo "value = '".date("Y-m-d",strtotime('tomorrow'))."'";} ?> required>
		

        <?php

if(isset($error))
    echo "<p class='warningMessage'>$error</p>";
?>
        <input type="submit" value="Réserver">



	  
                </form>
        </div>
    </div>

</body>
</html>

