<?php

class mydb
{

    function openConn()
    {

        $conn = new mysqli(
            "localhost",
            "root",
            "",
            "medicine_shop"
        );


        if($conn->connect_error)
        {
            die("Connection Failed: " . $conn->connect_error);
        }


        return $conn;

    }

}

?>