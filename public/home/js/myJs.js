$(function(){
	$(".lq").animate({opacity:1},1500,"linear",function(){
		$(".btn").addClass('on');
		$(".light").addClass('on').css("display","block");
		$(".btn").click(function() {
			$(".hidden1").css("display","block");
			$(".hidden").animate({top:0,opacity:1},600,function(){
				$(".inp1").focus();
			});
			$(this).removeClass('on');
		});
	});
	$(".word").animate({opacity:1},1500,"linear")
	$(".btn2").mouseenter(function(){
		$(".btn2 i").css("display","block").animate({left:"400px"},500,function(){
			$(".btn2 i").css({"display":"none","left":"-130px"});
		});
	});
	$("input").each(function(){
		$(this).focus(function(){
			$(this).removeClass('on');
		});
	});
	$("input").each(function(){
		$(this).blur(function(){
			$(this).addClass('on');
		});
	});
	
	$(".hidden1").click(function(){
		$(".hidden").animate({top:"1400",opacity:0.3},600,function(){
			$(".hidden1").css("display","none");
			$(".hidden").css("top","-1330px");
			$(".btn").addClass('on');
		});
	})
});