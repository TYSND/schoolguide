<?php
	require 'dblogin.php';
	$vname=$_POST['vertexname'];
	
	if	(!mysqli_query($con,"delete from vertexinfo where name='{$vname}';")){
		die(mysqli_error($con));
	}
?>