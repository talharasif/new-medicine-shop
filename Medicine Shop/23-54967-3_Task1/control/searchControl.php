<?php

require_once '../model/db.php';

$search = "";

$category = "";

if (isset($_GET['search']))
{
    $search = $_GET['search'];
}

if (isset($_GET['category']))
{
    $category = $_GET['category'];
}




$db = new mydb();

$conn = $db->openConn();

$result = $db->searchMedicine($search, $category, $conn);

$data = array();

if ($result && $result->num_rows > 0)
{
    while ($row = $result->fetch_assoc())
    {
        $item = array();
        $item['medicine_name'] = $row['medicine_name'];
        $item['company'] = $row['company'];
        $item['price'] = $row['price'];
        $item['category_name'] = $row['category_name'];
        $data[] = $item;
    }
}

echo json_encode($data);

?>