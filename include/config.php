<?php
    session_start();

    define('API_URL','api.kairos.com');
    define('API_ID','f41369c1');
    define('API_KEY','8dc369168d3827e8802f92c17170aa3e');

    function dbconnect(){
        $server = "localhost";
        $username = "arun_siddharth";
        $password = "3vXt73bGW7mEcGnI";
        $dbname = "attendo";
        return mysqli_connect($server, $username,$password, $dbname);
    }


?>