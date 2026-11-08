<?php
    // Protege a página: só entra quem estiver logado
    require_once __DIR__ . '/funcoes.php';
    if (!estaLogado()) {
        setMensagem('erro', 'Faça login para acessar esta página.');
        header("location:login.php");
        exit;
    }
