<?php
//TODO: Generar/Actualitzar la cookie amb els marcatges de l’usuari
    function fitxar($cookie, $tipus, $marcatges, $formatHora = "d/m/Y H:i:s"){
        $codificat = json_encode($marcatges);
        setcookie($cookie,$codificat,time()+3600*24*30);
    }

    //TODO: Donat un array de fitxades, retorna l’array corresponent a la última fitxada
    function getDarrerFitxatge($marcatges){
        return $marcatges[count($marcatges)-1];
    }

    //TODO: Donada una fitxada (array), retorna el seu tipus de moviment: Entrada/Sortida
    function getTipusMoviment($marcatge){
        return $marcatge[0];
    }

    //TODO: Donada una fitxada (array), retorna la data i hora del moviment
    function getHoraMoviment($marcatge){
        return $marcatge[1];
    }

    //TODO: Donat un array de fitxades, construeix el HTML per visualitzar el darrer marcatge
    function mostraDarrerFitxatge($marcatges){
        echo "<p>Últim marcatge realitzat</p>";
        if(getDarrerFitxatge($marcatges)[0]=="Entrada") echo "<p class='entrada'>".getHoraMoviment(getDarrerFitxatge($marcatges))."</p>";
        else echo "<p class='sortida'>".getHoraMoviment(getDarrerFitxatge($marcatges))."</p>";
    }

    //TODO: Donat un array de fitxades, construeix la taula HTML de fitxatges
    function mostraTaulaHtmlFitxades($marcatges){
        echo "<table><th>REGISTRE DE FITXATGE</th>";
        for($i=0;$i<count($marcatges);$i++)
        {
            if($marcatges[$i][0]=="Entrada") echo "<tr><td class='entrada'>".$marcatges[$i][1]."</td></tr>";
            else echo "<tr><td class='sortida'>".$marcatges[$i][1]."</td></tr>";
        }
        echo "</table>";
    }

    /* TODO: Opcional --> Genera formulari per fitxar
    function mostraFormFitxar($action, $valorFitxar, $tipus){

    }
    */