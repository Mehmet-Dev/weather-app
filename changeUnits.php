<?php 
session_start();

$_SESSION['viewInCelsius'] = !$_SESSION['viewInCelsius'];

header('Location: ' . $_SERVER['HTTP_REFERER']);