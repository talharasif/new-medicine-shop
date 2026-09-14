<?php


class order_model
{

    //order_history.php
    function getOrders($userid)
    {

        $db = new mydb();

        $conn = $db->openConn();


        $sql = "SELECT * FROM orders 
                WHERE user_id='$userid'
                ORDER BY order_date DESC";


        return $conn->query($sql);

    }



    function getOrderDetails($orderid, $userid)
    {

        $db = new mydb();

        $conn = $db->openConn();


        $sql = "SELECT o.*, 
                       u.name,
                       u.email
                FROM orders o
                JOIN users u 
                ON o.user_id=u.id
                WHERE o.id='$orderid'
                AND o.user_id='$userid'";


        return $conn->query($sql);

    }



    function getOrderItems($orderid)
    {

        $db = new mydb();

        $conn = $db->openConn();


        $sql = "SELECT oi.*, 
                       m.name,
                       m.vendor_name
                FROM order_items oi
                JOIN medicines m
                ON oi.medicine_id=m.id
                WHERE oi.order_id='$orderid'";


        return $conn->query($sql);

    }


//update operation
    function cancelOrder($orderid,$userid)
    {

        $db = new mydb();

        $conn = $db->openConn();



        $sql = "SELECT * FROM orders 
                WHERE id='$orderid'
                AND user_id='$userid'
                AND status='pending'";


        $result=$conn->query($sql);



        if($result->num_rows>0)
        {

            $update="UPDATE orders
                     SET status='rejected'
                     WHERE id='$orderid'";


            return $conn->query($update);

        }


        return false;

    }



    function getOrderItemsForReorder($orderid)
    {

        $db = new mydb();

        $conn = $db->openConn();


        $sql = "SELECT * FROM order_items
                WHERE order_id='$orderid'";


        return $conn->query($sql);

    }




    function checkStock($medicineid)
    {

        $db = new mydb();

        $conn = $db->openConn();


        $sql = "SELECT availability
                FROM medicines
                WHERE id='$medicineid'";


        return $conn->query($sql);

    }




    function getPayment($orderid)
    {

        $db = new mydb();

        $conn = $db->openConn();


        $sql="SELECT * FROM payments
              WHERE order_id='$orderid'";


        return $conn->query($sql);

    }


function searchOrders($userid,$text)
{

    $db=new mydb();

    $conn=$db->openConn();


    $sql="SELECT * FROM orders

          WHERE user_id='$userid'

          AND id LIKE '%$text%'";


    return $conn->query($sql);

}


}


?>