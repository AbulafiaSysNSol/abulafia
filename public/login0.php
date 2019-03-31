<?php

session_start(); //avvio della sessione: va fatto obbigatoriamente all'inizio e carica tutte le variabili di sessione, valide di pagina in pagina sino al logout

setlocale(LC_TIME, 'it_IT');//carica la versione italiana della data e dell'orario

$corpus = $_GET['corpus']; //acquisisce da get il valore della pagina ricercata

include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI

include 'testa-include.php'; //carica il file con l'header.

$include=include $corpus.'-centro-include.php';//carica la pagina cercata, la cui variabile è stata passata con il metodo get. L'errore standard è soppresso con @ per consentire il messaggio di errore personalizzato

if (!$include) { echo '<center><img src="images/pagenotfound.jpg"></center>';include 'sotto-include.php';exit();} //messaggio di errore qualora la pagina richiesta non esistesse


include 'sotto-include.php'; //carica il file con il footer.

?>

