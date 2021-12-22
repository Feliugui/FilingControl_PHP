<!--
    Aquest fitxer mostra el registre de fitxatge de l’usuari i permet al mateix enregistrar una entrada (si el darrer moviment va ser una sortida)
    o enregistrar una sortida (si el darrer moviment va ser una entrada).  També es permet a l’usuari tancar la seva sessió.

    Cal que es doni la benvinguda identificant a l’usuari loguinat, agafant com a nom d’usuari tota la cadena prèvia a la “@” en el correu utilitzat per a l’inici de sessió.
    És a dir, si l’email era anonim@educem.com, l’usuari serà “anonim”. A més a més, caldrà indicar quin rol posseix l’usuari en el sistema,
    d’acord a les dades de l’usuari (Veure credencials a controlUsuari.php).

    S’ha d’indicar quin és el darrer fitxatge, pintant-lo en verd en el cas de ser una entrada o en vermell en el cas de ser una sortida.
    A continuació s’ha de mostrar una taula HTML que contingui les dades de tots els fitxatges realitzats per l’usuari.
    Mostrant en verd les entrades i en vermell les sortides. Els registres de fitxatge es mostren ordenats de més antic a més recent.

    Per tal d’enregistrar els fitxatges s’utilitzarà un formulari que s’invocarà a si mateix (igual que a la pantalla de login).
    Aquest formulari únicament tindrà un botó que podrà ser “Entrada” en color verd per enregistrar una entrada o “Sortida” en color vermell per enregistrar una sortida.
    Les dades de la fitxada s’han de desar en format JSON dins d’una cookie vinculada a l’usuari.

    Per vincular la cookie a l’usuari el que farem serà anomenar-les totes amb el prefixe “marcatge” i concatenar-hi el valor resultant d’aplicar un hash de tipus SHA-512 al nom de l’usuari.
    D’aquesta forma tindrem cookies úniques i protegirem el nom de l’usuari al mateix temps.

    Addicionalment aquest fitxer php ha de verificar que s’ha accedir mitjançant una sessió d’usuari vàlida,
    ja que en cas contrari cal retornar l’usuari a la pàgina de login (“index.php”), de la mateixa manera,
    si existeix una sessió d’usuari però no les variables de sessió que pertoquen, caldrà forçar un logout a través d’una redirecció a la pàgina de logout (“logout.php”).

    Com a mesura de protecció extra, caldrà verificar que en el cas d’accedir via POST (cas de les fitxades) això s’ha fet realment a través del formulari web.
    Per fer-ho assignarem un valor aleatori a un camp input de tipus hidden al nostre formulari. Aquest valor s’haurà de verificar com a condició prèvia a realitzar la fitxada.
    Naturalment el valor aleatori s’ha de generar cada vegada que s’accedeix al fitxer php.
-->
<?php
session_start();
require_once "./lib/controlFitxatge.php";
if (!isset($_SESSION['nom'])) {
    header("Location: sessioLogin.php");
}
$user = $_SESSION['nom'];
$rol = $_SESSION['rol'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numAleatoriRecuperar = $_SESSION['inputAleatori'];
    // Comparo si el numAleatoriRecuperat del input es igual al del post.
    if ($_POST["fitxar"] == $numAleatoriRecuperar) {
        // Si no hi ha ninguna cookie del usuari es crea una nova.
        if (!isset($_COOKIE["marcatge" . hash("sha512", $user)])) {
            $marcatge[0] = array("Entrada", date('d/m/Y H:i:s'));
            fitxar("marcatge" . hash("sha512", $user), "Entrada", $marcatge, date('d/m/Y H:i:s'));
        } else {
        // Si ha una cookie del usuari es modificar per tenir una nova fitxada(entrada/sortida)
            $marcatge = json_decode($_COOKIE["marcatge" . hash("sha512", $user)], true);
            $tipusMoviment = getTipusMoviment(getDarrerFitxatge($marcatge));
            if (!($tipusMoviment == "Entrada")) {
                $marcatge[count($marcatge)] = array("Entrada", date('d/m/Y H:i:s'));
            } else {
                $marcatge[count($marcatge)] = array("Sortida", date('d/m/Y H:i:s'));
            }
            fitxar("marcatge" . hash("sha512", $user), $tipusMoviment, $marcatge, date('d/m/Y H:i:s'));
        }
    }
}
$numAleatori = random_int(1000, 100000);
// Al final he acabat fent una sessio per guardar el numAleatori per comparlo amb el post.
$_SESSION["inputAleatori"] = $numAleatori;
?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <title>Portal del treballador</title>
        <link rel="stylesheet" type="text/css" href="./css/main.css" />
        <link rel="icon" href="./img/icon.jpg" />
    </head>
    <body>
        <div id="pagewrapper">
            <h1>Portal del treballador</h1>
            <h2>Benvingut  <?php echo substr($user, 0, strrpos($user, '@')); ?> </h2>
            <h3><?php echo $rol ?></h3>
            <?php
            // Creacio de taula marcatges i ultim marcatge
            if (isset($_COOKIE["marcatge" . hash("sha512", $user)])) {
                if (!(isset($marcatge))) {
                    $marcatge = json_decode($_COOKIE["marcatge" . hash("sha512", $user)], true);
                }
                $tipusMoviment = getTipusMoviment(getDarrerFitxatge($marcatge));
            }
            //
            if (isset($marcatge)) {
                mostraDarrerFitxatge($marcatge);
                mostraTaulaHtmlFitxades($marcatge);
            }
            ?>
            <form  name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <?php
            // Rotacio de buto entrada / sortida
            if (isset($marcatge)) {
                $tipusMoviment = getTipusMoviment(getDarrerFitxatge($marcatge));
            }
            echo '<input name="fitxar" type="hidden" value=' . $numAleatori . '>';
            if (isset($marcatge)) {
                if ($tipusMoviment == "Sortida") {
                    echo '<button class="button entrada"><span>Entrada</span></button>';
                } else {
                    echo '<button class="button sortida"><span>Sortida</span></button>';
                }
            } else {
                echo '<button class="button entrada"><span>Entrada</span></button>';
            }
            ?>
            </form>
            <a href="logout.php"><button class="button logout"><span>Logout</span></button></a>
        </div>
    </body>
</html>