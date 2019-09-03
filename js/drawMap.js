
//画路线
	function drawMap(){
		var c=document.getElementById("canvas");
		var ctx=c.getContext("2d");
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
