<?php
		
		require "php/dblogin.php";
		echo '
				var posName=[];
				var posDis=[];
				var posX=[],posY=[];
				var edges=[];
				var isHide=[];
			';
			
		$result=mysqli_query($con,"select * from vertexinfo");
		
		while ($row=mysqli_fetch_array($result))
		{
			echo 'posName["'.$row['vertexid'].'"]="'.$row['name'].'";';
			echo 'posDis["'.$row['vertexid'].'"]="'.$row['descript'].'";';
			echo 'posX["'.$row['vertexid'].'"]="'.$row['x'].'";';
			echo 'posY["'.$row['vertexid'].'"]="'.$row['y'].'";';
			echo 'isHide["'.$row['vertexid'].'"]="'.$row['ishide'].'";';
		}
		
		$result=mysqli_query($con,"select fromv,tov from edgeinfo ");
		/*
			where fromv not in 
			(select vertexid from vertexinfo where ishide=1) and tov not in (select vertexid from vertexinfo where ishide=1)");
		*/
		while ($row=mysqli_fetch_array($result))
		{
			//echo $row['fromv'].$row['tov']."\n";
			echo 'edges.push(['.$row['fromv'].','.$row['tov'].']);';
			//echo 'edges["'.$row['fromv'].'"]="'.$row['tov'].'";';
		}
?>