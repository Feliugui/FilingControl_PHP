<!-- TODO: CONTROL DE LOGIN PHP I ACABAR FORMULARI!!
    Aquest fitxer ha d'incloure un formulari web amb dos camps d’entrada un pel correu electrònic i un altre pel password.
    Ambdós camps són obligatoris. La validació del login s’ha de fer contra el mateix fitxer php, però fent ús de les funcions i constants definides a “controlUsuari.php”.
    Si la verificació de l’usuari és correcte, es crearan les variables de sessió necessàries per recollir el nom de l’usuari i el rol i es procedirà a redirigir el navegador a “mainPage.php”.
    Si la verificació de l’usuari és incorrecte, s’ha de mostrar un missatge d’error i presentar el formulari amb el nom d’usuari que anteriorment s’havia utilitzat.
-->
<?php 
require_once("./lib/controlUsuari.php");
$trobat = 0;
if($_SERVER["REQUEST_METHOD"] == "POST"){
$correuIntroduida  = ( $_POST["correu"]);
$PassIntroduida = ( $_POST["pass"]);
verificaUsuari($correuIntroduida,$PassIntroduida);
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <title>Portal Login del treballador</title>
        <link rel="stylesheet" type="text/css" href="./css/main.css" />
        <link rel="icon" href="./img/icon.jpg" />
    </head>
    <body>
        <div id="pagewrapper">
            <h1>Portal del treballador</h1>
            <!-- Formulari de Login -->
            <form  name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"  >
                <!-- Work In Progress -->
                <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    if( $trobat== 0){
                        echo "<p>Revisi l'usuari i la contrassenya</p>";
                    }
                }
                ?>
                <input name="correu"  class="correu" type="text" placeholder="Email"  autocomplete="off" required=""/>
                <input name="pass"  class="pw" type="password" placeholder="Contrasenya" autocomplete="off"  required=""/>
                <button class="button" type="submit"><span>Login</span></button>
            </form>
        </div>
    </body>
</html>
