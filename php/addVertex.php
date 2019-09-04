<?php
	$vname=$_POST['vertexname'];
	$vdesc=$_POST['vertexdescript'];
	$x=$_POST['x'];
	$y=$_POST['y'];
	$edges=$_POST['edges'];
	require 'dblogin.php';
	//查询点id
	$vidres=mysqli_query($con,"
		select max(vertexid) as vid from vertexinfo
	;");
	$vidrow=mysqli_fetch_array($vidres);
	if($vid=="")	$vid=0;
	$vid=$vidrow['vid']+1;
	//插入点信息
	$insertvres=mysqli_query($con,"
		insert into vertexinfo
		values
		({$vid},'{$vname}','{$vdesc}',0,{$x},{$y})
	;");
	//插入边信息
	foreach ($edges as $newedge)
	{
		
		//$purl=$_SERVER['HTTP_REFERER'];
		$edgeinfo=$newedge;
		$edgeinfo=explode("-",$edgeinfo);
		$tovname=$edgeinfo[0];
		$dist=$edgeinfo[1];
		$cap=$edgeinfo[2];
		
		$tovidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$tovname}'");
		$tovidrow=mysqli_fetch_array($tovidres);
		$tovid=$tovidrow['vertexid'];
		
		if	(!mysqli_query($con,"insert into edgeinfo values ({$vid},{$tovid},{$dist},{$cap})")){
			die(mysqli_error($con));
		}
		if	(!mysqli_query($con,"insert into edgeinfo values ({$tovid},{$vid},{$dist},{$cap})")){
			die(mysqli_error($con));
		}
	}
	
?>