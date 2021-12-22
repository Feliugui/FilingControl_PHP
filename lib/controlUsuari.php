<?php
    //password_hash('1234',PASSWORD_DEFAULT);
    //password_hash('Fraud!',PASSWORD_DEFAULT); 
    //password_hash('KeepCalmJ03',PASSWORD_DEFAULT); 

    define('CREDENCIALS', array(
        'user'=>array('anonim@educem.com',
                        'trump@educem.com',
                        'biden@educem.com'),
        'pass'=>array(  '$2y$10$lIs8q5weNERTcLvnf2liDe/kv30eKZNXcEV26g21E5NlxGPrZZ6pG',
                        '$2y$10$g4im92dXDQLNexxfmHs0UO2Yn5/Y5/oyG9UTHz/pLF39ds5pq4HSS',
                        '$2y$10$WRSC9uVoMKwgWYVOp6v/muOp8/tWyIxAXWk/qZgihbU6iGhRr1TiO'),
        'rol' =>array(  'Usuari sense privilegis',
                        'Supervisor',
                        'Administrador'
        )
    ));
    
    //TODO: Verificar si l’usuari és vàlid o no, retornant en el cas de ser vàlid el seu nom i rol
    function verificaUsuari($nom, $clau){
        for ($i = 0; $i <= 2; $i++)
        {
            $correus = CREDENCIALS["user"][$i];
            $passwordsArxiu = CREDENCIALS["pass"][$i];
            $rol = CREDENCIALS["rol"][$i];
            if($nom==$correus && password_verify($clau,$passwordsArxiu) ){
                session_start();
                $_SESSION["nom"]=$nom;
                $_SESSION["rol"]=$rol;
                header("Location: mainPage.php?redirected=true");
            }
        }
    }