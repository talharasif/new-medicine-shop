<?php

class mydb
{
    function openConn()
    {
        return new mysqli(
            "localhost",
            "root",
            "",
            "OnlineMedicineShop"
        );
    }

    function insertCustomer($name, $email, $password, $address, $role, $conn)
    {
        $sql = "INSERT INTO customer
                (name, email, password, address, role)
                VALUES
                ('$name', '$email', '$password', '$address', '$role')";

        return $conn->query($sql);
    }

    function checkLogin($email, $password, $conn)
    {
        $sql = "SELECT * FROM customer
                WHERE email='$email'
                AND password='$password'";

        return $conn->query($sql);
    }

    function getCustomerById($id, $conn)
    {
        $sql = "SELECT * FROM customer
                WHERE id='$id'";

        return $conn->query($sql);
    }

    function updateCustomer($id, $name, $email, $address, $conn)
    {
        $sql = "UPDATE customer
                SET name='$name',
                    email='$email',
                    address='$address'
                WHERE id='$id'";

        return $conn->query($sql);
    }

    function getCategories($conn)
    {
        $sql = "SELECT * FROM category";

        return $conn->query($sql);
    }

    function getAllMedicines($conn)
    {
        $sql = "SELECT medicine.*,
                       category.category_name
                FROM medicine
                INNER JOIN category
                ON medicine.category_id = category.id";

        return $conn->query($sql);
    }

    function searchMedicine($search, $category, $conn)
    {
        $sql = "SELECT medicine.*,
                       category.category_name
                FROM medicine
                INNER JOIN category
                ON medicine.category_id = category.id
                WHERE medicine.medicine_name
                LIKE '%$search%'";

        if ($category != "")
        {
            $sql .= " AND medicine.category_id='$category'";
        }

        return $conn->query($sql);
    }

    function getAllCustomers($conn)
    {
        $sql = "SELECT * FROM customer";

        return $conn->query($sql);
    }

    function deleteCustomer($id, $conn)
    {
        $sql = "DELETE FROM customer WHERE id='$id'";

        return $conn->query($sql);
    }
}

?>