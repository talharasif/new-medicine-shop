<?php

include "../model/db.php";
//database function use korar jonno db.php include korchi

$db=new mydb();
//mydb class er object create korchi

$conn=$db->openConn();
//database er sathe connection create korchi

$action=$_GET['action'];
//AJAX request theke action nicchi

$id=$_GET['id'];
//kon cart item update/delete hobe tar id nicchi

$response=array();
//AJAX er jonno JSON response prepare korchi


if($action=="increase"){

    //increase button click korle quantity 1 barabe
    $sql="SELECT quantity FROM cart WHERE id='$id'";

    $result=$conn->query($sql); //sql query database e execute

    $row=$result->fetch_assoc();  //databse theke rslt data arry akare ncche

    $newQuantity=$row['quantity']+1;


    $db->updateCartQuantity(
        $id,
        $newQuantity,
        $conn
    );

//json rspnse
    $response["status"]="success";

    $response["message"]="Quantity increased";

    $response["quantity"]=$newQuantity;


}

elseif($action=="decrease"){

    //decrease button click korle quantity 1 komabe
    $sql="SELECT quantity FROM cart WHERE id='$id'";

    $result=$conn->query($sql);//sql qurry dtbs e execute

    $row=$result->fetch_assoc();

    $newQuantity=$row['quantity']-1;


    if($newQuantity>0){

        $db->updateCartQuantity(
            $id,
            $newQuantity,
            $conn
        );


        $response["status"]="success";

        $response["message"]="Quantity decreased";

        $response["quantity"]=$newQuantity;


    }
    else{

        $response["status"]="error";

        $response["message"]="Quantity cannot be less than 1";

    }


}



elseif($action=="remove"){

    //remove button click korle cart item delete korbe

    $db->removeCartItem(
        $id,
        $conn
    );
    $response["status"]="success";

    $response["message"]="Item removed";


}

//AJAX er jonno JSON format e response pathacchi
echo json_encode($response);

?>