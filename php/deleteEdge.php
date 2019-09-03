<?php
	$fname=$_POST['delfromname'];
	$tname=$_POST['deltoname'];
	$fidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$fname}'");
	$fidrow=mysqli_fetch_array($fidres);
	$fid=$fidrow['vertexid'];
	$tidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$tname}'");
	$tidrow=mysqli_fetch_array($tidres);
	$tid=$tidrow['vertexid'];
	
	if	(!mysqli_query($con,"delete from edgeinfo where ;")){
		die(mysqli_error($con));
	}
?>