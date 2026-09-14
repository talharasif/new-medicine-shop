<?php

session_start();

//include "../model/order_model.php";
include "../model/db.php";

include "../model/order_model.php";

include "../model/cart_model.php";


if(!isset($_SESSION['user_id']))
{
    header("location:../view/login.php");
    exit();
}


$db = new order_model();

$result = $db->getOrders($_SESSION['user_id']);


if(isset($_GET['id']))
{

    $orderid=$_GET['id'];


    $db = new order_model();


    $order = $db->getOrderDetails(
        $orderid,
        $_SESSION['user_id']
    );


    $items = $db->getOrderItems($orderid);


}


if(isset($_GET['cancel']))
{

    $orderid=$_GET['cancel'];


    $db=new order_model();


    if($db->cancelOrder(
        $orderid,
        $_SESSION['user_id']
    ))
    {

        header("location:../view/order_history.php");

    }
    else
    {

        echo "Order cannot be cancelled";

    }


}
?>

<?php

if(isset($_GET['reorder']))
{

    $orderid=$_GET['reorder'];



    $orderModel=new order_model();

    $cartModel=new cart_model();



    $items=$orderModel->getOrderItemsForReorder($orderid);



    while($item=$items->fetch_assoc())

    {


        $stock=$orderModel->checkStock(
            $item['medicine_id']
        );


        $stockData=$stock->fetch_assoc();



        if($stockData['availability'] >= $item['quantity'])
        {


            $cartModel->addCart(

                $_SESSION['user_id'],

                $item['medicine_id'],

                $item['quantity']

            );


        }

        else if($stockData['availability'] > 0)

        {


            $cartModel->addCart(

                $_SESSION['user_id'],

                $item['medicine_id'],

                $stockData['availability']

            );


        }


    }



    echo "Items added to cart";


}



if(isset($_GET['invoice']))
{

    $orderid=$_GET['invoice'];


    $db=new order_model();


    $invoiceOrder=$db->getOrderDetails(
        $orderid,
        $_SESSION['user_id']
    );


    $invoiceItems=$db->getOrderItems($orderid);


    $payment=$db->getPayment($orderid);


}

?>


