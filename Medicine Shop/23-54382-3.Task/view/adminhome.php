<!DOCTYPE html>
<?php
echo "<h1>Hello world PHP<h1>";
?>

<html>
<head>
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="../css/mycss.css">
</head>

<h1>Admin</h1>

<?php
echo $_SERVER['PHP_SELF'];
echo "<br>";
echo $_SERVER['SERVER_NAME'];
echo "<br>";
echo $_SERVER['HTTP_HOST'];
echo "<br>";
echo $_SERVER['HTTP_REFERER'];
echo "<br>";
echo $_SERVER['HTTP_USER_AGENT'];
echo "<br>";
echo $_SERVER['SCRIPT_NAME'];
?>


<img src="data:image/png;base64,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">

<h2>Welcome to the Admin Page</h2>

<button class="buttonshape button1 ">My Button 1</button>
<button class="buttonshape button2">My Button 2</button>

<p id="myp">Hiii</p>
<script>
document.getElementById("myp").innerHTML = "Hello World!";
console.log("I am console log");

document.write("I am document write");
    </script>

</html>

<?php
echo "<h1>Hello world PHP<h1>";
?>