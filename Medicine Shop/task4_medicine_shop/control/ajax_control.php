<?php

session_start();

include "../model/db.php";

include "../model/order_model.php";


header("Content-Type: application/json");


$db=new order_model();



if(isset($_GET['search']))
{


    $text=$_GET['search'];


    $result=$db->searchOrders(
        $_SESSION['user_id'],
        $text
    );


    $orders=[];



    while($row=$result->fetch_assoc())
    {


        $orders[]=[

            "id"=>$row['id'],

            "date"=>$row['order_date'],

            "total"=>$row['total_amount'],

            "status"=>$row['status']

        ];


    }



    echo json_encode($orders);



}


?>