<?php
$con = mysqli_connect("localhost","root","a46513");
if (!$con)
{
	die('Could not connect: ' . mysqli_error());
}
mysqli_select_db($con,"schoolguide");
mysqli_set_charset($con,"utf8");

?>