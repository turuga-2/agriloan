<?php
include "config/databaseconfig.php";

session_start();
session_unset();
session_destroy();

header('location:farmerlogin.php');
?>