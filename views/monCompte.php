<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
      <title>Mon compte</title>
      </head>
   <body>
<?php
component("topMenu");
echo "<div class='reservations'>";
echo "<h1>Mon compte<br></h1>";
echo "<div class='reservation'>";
if(isset($editer)){
	?>
	<div class="login-page">
    <div class="form">
        <form class="login-form" action="/modifierprofil" method="post" >
        <input name="nom" type="text" placeholder="Nom" maxlength="32" <?php if(isset($_POST["nom"])) echo "value='".$_POST["nom"]."'";else{echo "value='".$client->nom_cl."'";}?> required/>
        <input name="prenom" type="text" placeholder="Prenom" maxlength="32" <?php if(isset($_POST["prenom"])) echo "value='".$_POST["prenom"]."'";else{echo "value='".$client->prenom_cl."'";}?>required/>
        <input name="groupe" type="text" placeholder="(Optionnel) Groupe" maxlength="32" <?php if(isset($_POST["groupe"])) echo "value='".$_POST["groupe"]."'";else{echo "value='".$client->nomEntreprise."'";}?>/>
        <input name="telephone" type="text" placeholder="Telephone" maxlength="32" <?php if(isset($_POST["telephone"])) echo "value='".$_POST["telephone"]."'";else{echo "value='".$client->telephone_cl."'";}?>required/>
        <input name="email" type="text" placeholder="Email" maxlength="32" <?php if(isset($_POST["email"])) echo "value='".$_POST["email"]."'";else{echo "value='".$client->mail_cl."'";}?>required/>
        <input name="password" type="password" placeholder="Mot de passe" <?php if(isset($_POST["password"])) echo "value='".$_POST["password"]."'";?>/>
        <input type="submit" value="Modifier">
		</form>
		<a href='/moncompte'>Retour</a>
        </div>
		</div>
<?php
}
else{
	echo "<h2>".$client->prenom_cl." ".$client->nom_cl."</h2><br>";
	if($client->nomEntreprise!=null) echo $client->nomEntreprise."<br>";
	echo "Pseudo : ".$client->pseudo."<br>";
	echo "Téléphone : ".$client->telephone_cl."<br>";
	echo "E-mail : ".$client->mail_cl."<br><br>";
	echo "<a href='/editer'>Editer profil</a>";
}


?>
</div>
</div>
</body>
</html>