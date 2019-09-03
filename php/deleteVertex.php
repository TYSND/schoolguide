<?php
	require 'dblogin.php';
	$vname=$_GET['vertexname'];
	
	$vidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$vname}'");
	$vidrow=mysqli_fetch_array($vidres);
	$vid=$vidrow['vertexid'];
	
	if	(!mysqli_query($con,"delete from vertexinfo where vertexid='{$vid}';")){
		die(mysqli_error($con));
	}
	if	(!mysqli_query($con,"delete from edgeinfo where fromv={$vid} or tov={$vid};")){
		die(mysqli_error($con));
	}
		
	echo '<script>';
	echo 'alert("delete success!");parent.location.href="../";';
	echo '</script>';
?>