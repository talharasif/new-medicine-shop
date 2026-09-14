<?php
require_once '../model/db.php';

$db = new mydb();
$conn = $db->openConn();
$customers = $db->getAllCustomers($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div class="navbar">
    <a href="adminhome.php">Home</a>
    <a href="medicines.php">Medicines</a>
    <a href="customers.php">Customers</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2>Manage Customers</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $customers->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo ucfirst($row['role']); ?></td>
                <td>
                    <a href="../control/deleteCustomerControl.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Are you sure?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="footer">
    &copy; 2026 Online Medicine Shop
</div>

</body>
</html>
