<div id='topMenuBar'>

    <div id="topMenu">
        <span><a href='/'>Group Hotel</a></span>

        <?php
            if(Session::has("connectedClient"))
            {
                $client = Session::get("connectedClient");
                echo "<a href='/deconnexion'>Deconnexion</a>";
                echo "<a href='/moncompte'>".$client->nom_cl." ".$client->prenom_cl."</a>";
				echo "<a href='/mesreservations'>Mes réservations</a>";
            }
            else{
                echo "<a href='/connexion'>Se connecter</a>";
                echo "<a href='/inscription'>S'inscire</a>";
            }


        ?>
        
    </div>
</div>

<?php
