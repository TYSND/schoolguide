<?php
	$vname=$_POST['vertexname'];
	$vdesc=$_POST['vertexdescript'];
	$x=$_POST['x'];
	$y=$_POST['y'];
	$edges=$_POST['edges'];
	$noname=$_POST['noName'];
	
	require 'dblogin.php';
	//查询点id
	$vidres=mysqli_query($con,"
		select max(vertexid) as vid from vertexinfo
	;");
	$vidrow=mysqli_fetch_array($vidres);
	if($vid=="")	$vid=0;
	$vid=$vidrow['vid']+1;
//是路口
if($noname=="on")
{
	$ishide=1;
	$vname="cross".$vid;
}
else
{
	$ishide=0;
}
	//插入点信息
	$sql="
		insert into vertexinfo
		values
		({$vid},'{$vname}','{$vdesc}',{$ishide},{$x},{$y})
	;";
	echo $sql;
	//exit();
	$insertvres=mysqli_query($con,"
		insert into vertexinfo
		values
		({$vid},'{$vname}','{$vdesc}',{$ishide},{$x},{$y})
	;");
	
	if(!$insertvres)
	{
		echo mysqli_error($con);
		exit();
	}
	
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