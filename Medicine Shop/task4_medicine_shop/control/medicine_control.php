<?php

include "../model/db.php";

include "../model/medicine_model.php";


if(isset($_GET['id']))
{

    $id=$_GET['id'];


    $db=new medicine_model();


    $medicine=$db->getMedicine($id);

}

?>