<?php
$_SESSION['mensagem'] = "Logoff realizado com sucesso!";
session_start();
session_unset();
session_destroy();
header('Location: index.php');
