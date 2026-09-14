<?php
require_once '../model/db.php';

$db = new mydb();
$conn = $db->openConn();
$categories = $db->getCategories($conn);
$medicines = $db->getAllMedicines($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medicines</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<div class="navbar">
    <a href="home.php">Home</a>
    <a href="medicines.php">Medicines</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2>Medicines</h2>

    <div class="searchArea">
        <input type="text" id="searchInput" placeholder="Search medicine name...">
        <select id="categoryFilter">
            <option value="">All Categories</option>
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?php echo $cat['id']; ?>">
                    <?php echo $cat['category_name']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button onclick="searchMedicine()">Search</button>
    </div>

    <div id="result">
        <?php while ($med = $medicines->fetch_assoc()): ?>
            <div class="medicineBox">
                <h3><?php echo $med['medicine_name']; ?></h3>
                <p>Company: <?php echo $med['company']; ?></p>
                <p>Category: <?php echo $med['category_name']; ?></p>
                <p>Price: $<?php echo number_format($med['price'], 2); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="../ajax/myjs.js"></script>

<div class="footer">
    &copy; 2026 Online Medicine Shop
</div>

</body>
</html>
