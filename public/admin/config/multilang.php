<?
$_SESSION['lang']="it";
if(str_contains($uri,"/en/")) $_SESSION['lang']="en"; 
if(str_contains($uri,"&lingua=en")) $_SESSION['lang']="en"; 
if(str_contains($uri,"/de/")) $_SESSION['lang']="de"; 
if(str_contains($uri,"&lingua=/de")) $_SESSION['lang']="de"; 
if(str_contains($uri,"/fr/")) $_SESSION['lang']="fr"; 
if(str_contains($uri,"&lingua=fr")) $_SESSION['lang']="fr"; 
if(str_contains($uri,"/es/")) $_SESSION['lang']="es"; 
if(str_contains($uri,"&lingua=es")) $_SESSION['lang']="es"; 
$lang = $lingua = $_SESSION['lang'];

include("config/traduci_parole.inc.php");
include("config/traduci_pagina.inc.php");
?>