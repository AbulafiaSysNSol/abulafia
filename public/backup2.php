<?php

    session_start();
    set_time_limit(0);

    if ($_SESSION['auth'] < 1 ) {
    	header("Location: index.php?s=1");
    	exit(); 
    }

    include 'class/Log.obj.inc';
    include '../db-connessione-include.php';

    $anno = $_POST['anno'];
    $inizio = $_POST['inizio'];
    $fine = $_POST['fine'];

    $zip_name = "Allegati_Protocollo_Anno_".$anno."_dal_".$inizio."_al_".$fine.".zip";

    $zip = new ZipArchive();

    $filename = $zip_name; 

    $ok = $zip->open($filename, ZipArchive::CREATE); 

    $dir_path = "lettere".$anno;

    if(!is_dir($dir_path)){ 
        throw new Exception('La cartella ' . $dir_path . ' non esiste'); 
    } 

    if(substr($dir_path, -1) != DIRECTORY_SEPARATOR){ 
        $dir_path.= DIRECTORY_SEPARATOR; 
    } 

    $dirStack = array($dir_path); 

    while(!empty($dirStack)){

        $currentDir = array_pop($dirStack); 
        $filesToAdd = array(); 

        $dir_folder = dir($currentDir); 
        while( false !== ($node = $dir_folder->read()) ){ 
            if( ($node == '..') || ($node == '.') || ($node == 'temp') || ($node == 'qrcode') ){ 
                continue; 
            } 
            if(is_dir($currentDir . $node) && ($node >= $inizio) && ($node <= $fine) ){ 
                array_push($dirStack, $currentDir . $node . '/'); 
            } 
            if(is_file($currentDir . $node)){ 
                $filesToAdd[] = $node; 
            }
       } 

        $localDir = $currentDir; 
        $zip->addEmptyDir($localDir); 

        foreach($filesToAdd as $file){ 
            $zip->addFile($currentDir . $file, $localDir . $file); 
        } 

    } 

    $zip->close();

    header('Content-type: application/zip');
    header('Content-disposition: attachment; filename="' . $zip_name . '"');
    header("Content-length: " . filesize($zip_name));
    ob_clean();
    flush();
    readfile($zip_name);
    unlink($zip_name);

?>