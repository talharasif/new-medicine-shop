<?php



class cart_model
{


    function addCart($userid,$medicineid,$qty)
    {

        $db=new mydb();

        $conn=$db->openConn();


        $sql="INSERT INTO cart
        (user_id,medicine_id,quantity)

        VALUES

        ('$userid','$medicineid','$qty')";


        return $conn->query($sql);


    }


function getOrderItemsForReorder($orderid)
{

    $db=new mydb();

    $conn=$db->openConn();


    $sql="SELECT * FROM order_items
          WHERE order_id='$orderid'";


    return $conn->query($sql);


}



function checkStock($medicineid)
{

    $db=new mydb();

    $conn=$db->openConn();


    $sql="SELECT availability 
          FROM medicines
          WHERE id='$medicineid'";


    return $conn->query($sql);


}


}

?>