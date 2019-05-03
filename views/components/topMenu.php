<div id='topMenuBar'>

    <div id="topMenu">
        <span>Group Hotel</span>

        <?php
            if(Session::has("connectedClient"))
            {
                $client = Session::get("connectedClient");
                echo "<a href='/deconnexion'>Deconnexion</a>";
                echo "<a href='/moncompte'>".$client->nom_cl." ".$client->prenom_cl."</a>";

            }
            else{
                echo "<a href='/connexion'>Se connecter</a>";
                echo "<a href='/inscription'>S'inscire</a>";
            }


        ?>
        
    </div>
</div>

<?php
