
//画路线
	function drawMap(){
		var c=document.getElementById("canvas");
		var ctx=c.getContext("2d");
		for (var fromv in edges)
		{
			var tov=edges[fromv];
			ctx.moveTo(posX[fromv],posY[fromv]);
			ctx.lineTo(posX[tov],posY[tov]);
			ctx.stroke();
		}
	}
