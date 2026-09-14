<?php

echo password_hash("12345678", PASSWORD_DEFAULT);

echo "<br><br>";

echo "Second Customer Password Hash:<br>";

echo password_hash("abcdefgh", PASSWORD_DEFAULT);

?>