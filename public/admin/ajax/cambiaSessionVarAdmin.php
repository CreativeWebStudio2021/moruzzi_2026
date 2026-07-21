<?php 
session_start();

if(isset($_GET['nomeVar'])) $nomeVar = $_GET['nomeVar']; else $nomeVar="";
if(isset($_GET['valoreVar'])) $valoreVar = $_GET['valoreVar']; else $valoreVar="";
//echo $nomeVar.": ".$valoreVar;

$_SESSION[$nomeVar] = $valoreVar;
?>