
//画路线
function drawMap(){
	var c=document.getElementById("canvas");
	var ctx=c.getContext("2d");
	var mapPic=document.getElementById("mapPic");
	ctx.drawImage(mapPic,0,0);
	for (var i=0;i<edges.length;i++)
	{
		var tov=edges[i][1],fromv=edges[i][0];
		console.log(fromv+"  "+tov+"\n");
		ctx.beginPath();
		ctx.moveTo(posX[fromv],posY[fromv]);
		ctx.lineTo(posX[tov],posY[tov]);
		ctx.stroke();
	}
}

//最短路之后重画红色路径
function reDrawRedLine(resArray){
	var c=document.getElementById("canvas");
	var ctx=c.getContext("2d");
	ctx.clearRect(0,0,c.width,c.height);
	var mapPic=document.getElementById("mapPic");
	ctx.drawImage(mapPic,0,0);
	
	var redEdge=[];
	for (var i=1;i<resArray.length-1;i++)
			redEdge.push(resArray[i]+"-"+resArray[i+1]);
	for (var i=0;i<redEdge.length;i++)
	{
		//console.log(read	);
	}
	for (var i=0;i<edges.length;i++)
	{
		var tov=edges[i][1],fromv=edges[i][0];
		ctx.beginPath();
		if (redEdge.includes(fromv+"-"+tov)||redEdge.includes(tov+"-"+fromv)){
			ctx.strokeStyle='rgba(255,102,89,0.4)';
			ctx.lineWidth="7";
		}
		else{
			ctx.strokeStyle='black';
			ctx.lineWidth='2';
		}
		ctx.moveTo(posX[fromv],posY[fromv]);
		ctx.lineTo(posX[tov],posY[tov]);
		ctx.stroke();
	}
	
}

function drawPos(){
	var posField=document.getElementById("posField");
	for (var index in posName)
	{
		var str;
		if (isHide[index]==0){
			str="<div class=\"position flexCenter infoFont\" style=\"top:"+(posY[index]-20)+"px;left:"+(posX[index]-40)+"px;\""+
			"onclick=\"changeShowPos(\'"+index+"\')\"><img src=\"image/location-sign.png\" style=\"float:left\"/>"+
			"<div style=\"float:left\">"+
			posName[index]+
			"</div>"+
			"</div>";
		}
		else{
			str="<div "+
				"class=\"cross\""+
				" onclick=\"changeShowPos(\'"+index+"\')\""+
				"style=\"width:10px;top:"+posY[index]+"px;left:"+posX[index]+"px;\""+
				"</div>";
		}
		posField.innerHTML+=str;
	}
}