<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
      <title>Connexion</title>
      </head>
   <body>
   <div class="login-page">
   <div class="form">
        <form class="login-form" action="/connexion" method="post" >
        <input name="username" type="text" placeholder="Identifiant"/>
        <input name="password" type="password" placeholder="Mot de passe"/>
        <input type="submit" value="Connexion">
      <p class="message">Pas de compte ? <a href="/inscription">Créer un compte</a></p>
	  
                </form>
        </div>
    </div>
<?php

if(isset($error))
    echo $error;
?>
</body>
</html>

