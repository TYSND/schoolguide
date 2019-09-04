
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
		ctx.strokeStyle='rgba(0,0,0,0.1)';
		ctx.lineWidth="5";
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
			ctx.strokeStyle='rgba(0,0,0,0.1)';
			ctx.lineWidth="5";
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
			str="<div class=\"position flexCenter infoFont\" style=\"top:"+(posY[index]-16)+"px;left:"+(posX[index]-4)+"px;\""+
			"onclick=\"changeShowPos(\'"+index+"\')\"><img src=\"image/location-sign.png\" style=\"float:left\"/>"+
			"<div style=\"float:left\">"+
			posName[index]+
			"</div>"+
			"</div>";
		}
		else{
			var xx=Number(posX[index])+3,yy=Number(posY[index])+3;
			str="<div "+
				"class=\"cross\""+
				" onclick=\"changeShowPos(\'"+index+"\')\""+
				"style=\"width:10px;top:"+(yy)+"px;left:"+(xx)+"px;\">"+
				"</div>";
		}
		posField.innerHTML+=str;
	}
}

//为增加点页面提供，把所有点画成小的圆点并标出名称
function drawAllPosCross()
{
	var posField=document.getElementById("posField");
	for (var index in posName)
	{
		var str;
		var xx=Number(posX[index])+3,yy=Number(posY[index])+3;
		str="<div "+
			"class=\"cross infoFont\""+
			" onclick=\"changeShowPos(\'"+index+"\')\""+
			"style=\"width:10px;top:"+(yy)+"px;left:"+(xx)+"px;\">"+
			"</div>";
			
		posField.innerHTML+=str;
	}
	for (var index in posName)
	{
		var str;
		var xx=Number(posX[index])+3,yy=Number(posY[index])+3;
		str="<div class=\"infoFont\" style=\"position:absolute;top:"+(yy-3-3)+"px;left:"+(xx+7+3)+"px\">"+
			posName[index]+
			"</div>";
		posField.innerHTML+=str;
	}
	
}