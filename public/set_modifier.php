<?php
    include("../include/config.php");
    include("../include/helpers.php");

    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $_SESSION['modifier'] = $_GET['modifier'];
        redirect('modifier.php');
    }
?>