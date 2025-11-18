<?php
// index.php
require_once "controlador.php";

$controlador = new TareasController();
$controlador->manejarSolicitud();
