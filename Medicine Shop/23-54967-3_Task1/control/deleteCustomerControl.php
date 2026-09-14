<?php

require_once '../model/db.php';

$id = "";

if (isset($_GET['id']))
{
    $id = $_GET['id'];
}

if (!empty($id))
{
    $db = new mydb();

    $conn = $db->openConn();

    $db->deleteCustomer($id, $conn);
}

header("Location: ../view/customers.php");

exit();

?>