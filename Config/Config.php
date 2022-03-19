<?php
//definimos la url general en base al server
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define("BASE_URL", $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/lnh/estructuraMVC/");
} else {
    define("BASE_URL", $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . '/');
}

//Zona horaria
date_default_timezone_set('America/Lima');

//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "db_project";
const DB_USER = "db_leenh";
const DB_PASSWORD = "321321";
const DB_CHARSET = "charset=utf8";

//Deliminadores decimal y millar Ej. 24,1989.00
const SPD = ".";
const SPM = ",";

//Simbolo de moneda
const SMONEY = "S/ ";

//Otros datos
const NOMBRE_EMPRESA = "Leenhcraft";
