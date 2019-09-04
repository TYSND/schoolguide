<?php
	require 'dblogin.php';
	$vname=$_POST['vertexname'];
	$vdesc=$_POST['vertexdescript'];
	$result=mysqli_query($con,"update vertexinfo set name='{$vname}',descript='{$vdesc}' where name='{$vname}'");
	

?>