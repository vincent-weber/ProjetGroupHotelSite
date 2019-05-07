<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
      <title>Inscription</title>
      </head>
   <body>
   <div class="login-page">
    <div class="form">
        <form class="login-form" action="/inscription" method="post" >
        <input name="nom" type="text" placeholder="Nom" maxlength="32" <?php if(isset($_POST["nom"])) echo "value='".$_POST["nom"]."'";?> required/>
        <input name="prenom" type="text" placeholder="Prenom" maxlength="32" <?php if(isset($_POST["prenom"])) echo "value='".$_POST["prenom"]."'";?>required/>
        <input name="groupe" type="text" placeholder="(Optionnel) Groupe" maxlength="32" <?php if(isset($_POST["groupe"])) echo "value='".$_POST["groupe"]."'";?>/>
        <input name="telephone" type="text" placeholder="Telephone" maxlength="32" <?php if(isset($_POST["telephone"])) echo "value='".$_POST["telephone"]."'";?>required/>
        <input name="email" type="text" placeholder="Email" maxlength="32" <?php if(isset($_POST["email"])) echo "value='".$_POST["email"]."'";?>required/>
        <input name="username" type="text" placeholder="Identifiant" minlength="6" maxlength="32" <?php if(isset($_POST["username"])) echo "value='".$_POST["username"]."'";?>required/>
        <input name="password" type="password" placeholder="Mot de passe" <?php if(isset($_POST["password"])) echo "value='".$_POST["password"]."'";?>required/>

        <?php

if(isset($error))
    echo "<p class='warningMessage'>$error</p>";
?>
        <input type="submit" value="S'inscire">
      <p class="message">Deja un compte ? <a href="/connexion">Se connecter</a></p>



	  
                </form>
        </div>
    </div>

</body>
</html>

