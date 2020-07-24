<?php
$password = "";
$encodedpw = str_replace("=", "", base64_encode($password));
echo $encodedpw;
echo '<br>';
$encodedpw = substr_replace($encodedpw, "M", 2, 0);
$encodedpw = substr_replace($encodedpw, "W", 4, 0);
$encodedpw = substr_replace($encodedpw, "V", 6, 0);
echo $encodedpw;
echo '<br><br>';
$decodedpw = substr_replace($encodedpw, "", 6, 1);
$decodedpw = substr_replace($decodedpw, "", 4, 1);
$decodedpw = substr_replace($decodedpw, "", 2, 1);
$decodedpw = base64_decode($decodedpw);
echo $decodedpw;
?>