<?php


class medicine_model
{


    function getMedicine($id)
    {

        $db=new mydb();

        $conn=$db->openConn();


        $sql="SELECT medicines.*,
                     categories.name AS category_name,
                     categories.category_type

              FROM medicines

              LEFT JOIN categories

              ON medicines.category_id=categories.id

              WHERE medicines.id='$id'";


        return $conn->query($sql);


    }


}

?>