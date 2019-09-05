<?php
$spf=$_POST['shortpathfrom'];
$spt=$_POST['shortpathto'];
$mff=$_POST['maxflowfrom'];
$mft=$_POST['maxflowto'];
require 'dblogin.php';
//echo 'get spf:'.$spf.'  get spt:'.$spt;
if($spf!=""&&$spt!="")
{
	//echo "<script>document.getElementById('func1beg').value='{$spf}'</script>";
	//echo "<script>document.getElementById('func1end').value='{$spt}'</script>";
	//echo 'get spf:'.$spf.'  get spt:'.$spt;
	
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
		$line = fgets($handle);
		//$line = trim($line);
		//获得当前平台换行符长度
		$changeLineLength = strlen(PHP_EOL);
		//当前数据长度
		$lineLength = strlen($line);
		//如果当前长度为0或者是空行则跳过
		if ($lineLength == 0 || $lineLength == $changeLineLength) {
			continue;
		}
		//裁剪字符串数据，去掉结尾换行符
		if (substr($line,-$changeLineLength) == PHP_EOL) {
			$line = substr($line,0,$lineLength-$changeLineLength);
		}
		//echo $line;
		$res=$res.$line."-";	
	}
	$res=substr($res, 0, -1);
	//$res=substr($res, 0, -1);
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
	$res="";	
	while (!feof ($handle)) 
	{
		$line = fgets($handle);
		//$line = trim($line);
		//获得当前平台换行符长度
		$changeLineLength = strlen(PHP_EOL);
		//当前数据长度
		$lineLength = strlen($line);
		//如果当前长度为0或者是空行则跳过
		if ($lineLength == 0 || $lineLength == $changeLineLength) {
			continue;
		}
		//裁剪字符串数据，去掉结尾换行符
		if (substr($line,-$changeLineLength) == PHP_EOL) {
			$line = substr($line,0,$lineLength-$changeLineLength);
		}
		//echo $line;
		$res=$res.$line."-";	
	}
	$res=substr($res, 0, -1);
	fclose ($handle);
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