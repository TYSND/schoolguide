<?php
$spf=$_POST['shortpathfrom'];
$spt=$_POST['shortpathto'];
$mff=$_POST['maxflowfrom'];
$mft=$_POST['maxflowto'];
require 'dblogin.php';
if($spf!=""&&$spt!="")
{
	//echo "<script>document.getElementById('func1beg').value='{$spf}'</script>";
	//echo "<script>document.getElementById('func1end').value='{$spt}'</script>";
	
	$fidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$spf}'");
	$fidrow=mysqli_fetch_array($fidres);
	$fid=$fidrow['vertexid'];
	$tidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$spt}'");
	$tidrow=mysqli_fetch_array($tidres);
	$tid=$tidrow['vertexid'];
	
	$command = './schoolguide 0 '.$fid.' '.$tid;
	passthru($command);
	//print_r($result);
	$filename ="result.out";
	$handle  = fopen ($filename, "r");
	$res="";	
	while (!feof ($handle)) 
	{
		$res=$res.fgets($handle)."-";	
	}
	substr($res, 0, -1);
	echo $res;
	fclose ($handle);
	/*
	func1beg
	func1end
	func1out
	*/
}
else if($mff!=""&&$mft!="")
{
	$fidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$mff}'");
	$fidrow=mysqli_fetch_array($fidres);
	$fid=$fidrow['vertexid'];
	$tidres=mysqli_query($con,"select vertexid from vertexinfo where name='{$mft}'");
	$tidrow=mysqli_fetch_array($tidres);
	$tid=$tidrow['vertexid'];
	
	$command = './schoolguide 1 '.$fid.' '.$tid;
	passthru($command);
	//print_r($result);
	$filename ="result.out";
	$handle  = fopen ($filename, "r");
	while (!feof ($handle)) 
	{
		echo fgets($handle);
	}
	fclose ($handle);
}
else
{
	echo '<script>alert("起点和终点都要输入！");</script>';
}
/*
$command = './schoolguide 0 1 2';
passthru($command);
//print_r($result);

 
  $filename ="result.out";
  $handle  = fopen ($filename, "r");
  while (!feof ($handle)) 
  {
    echo fgets($handle)."<br/>";

    }
 fclose ($handle);
 */
?>