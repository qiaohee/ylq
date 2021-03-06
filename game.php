<?php
header("Content-type:text/html;charset=utf-8");
include 'public/coon.php';
session_start();
error_reporting(0);
if(($_SESSION["openid"])!= null){
	$openid = $_SESSION["openid"];
	$db = mysql_query("select * from ylq where openid = '{$openid}'");
	$res = mysql_fetch_assoc($db);
	if(!$res){
		$res = "insert into ylq(openid) values('{$openid}')";
		$re = mysql_query($res);
	}
}else
{
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>决战鸭梨君</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">

	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/animate.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/animate.js"></script>
	<script type="text/javascript">
    new function (){
       var _self = this;
       _self.width = 750;//设置默认最大宽度
       _self.fontSize = 100;//默认字体大小
       _self.widthProportion = function(){var p = (document.body&&document.body.clientWidth||document.getElementsByTagName("html")[0].offsetWidth)/_self.width;return p>1?1:p<0.32?0.32:p;};
       _self.changePage = function(){
           document.getElementsByTagName("html")[0].setAttribute("style","font-size:"+_self.widthProportion()*_self.fontSize+"px !important");
       }
       _self.changePage(); 
       window.addEventListener('resize',function(){_self.changePage();},false);
    };
	</script>
</head>
<body class="bg2">
	
	
	<div class="gameCon">
		<!-- 鸭梨头像 -->
		<div class="hd">
			<img src="images/yali.jpg" alt="">
			<h1>鸭梨君</h1>
		</div>
		<!-- 系统手势排列 -->
		<div class="array clearfix">
			<img src="images/q.png" alt="">
			<img src="images/w.png" alt="">
			<img src="images/e.png" alt="">
		</div>
		<!-- 系统出拳 -->
		<div class="hand-wrap">
			<img class="punches hand1 rot" src="images/1.png" alt="">
		</div>
		<!-- 用户出拳 -->
		<img class="punches hand2" src="images/2.png" alt="">
		<!-- 用户手势排列 -->
		<div class="array user-hand no-t-p clearfix">
			<img data-num="1" src="images/a.png" alt="">
			<img data-num="2" src="images/b.png" alt="">
			<img data-num="3" src="images/c.png" alt="">
		</div>
		<h2>选择你的手势</h2>
		<!-- 用户头像 -->
		<div class="hd user">
			<img src="<?php echo $res['head'];?>" alt="">
			<h1><?php echo $res['name'];?></h1>
		</div>
	</div>


	<!-- 弹出层 -->
	<div class="mask"></div>
	<!-- 中奖弹窗 -->
	<div class="prize-con success">
		<div class="prize-wrap ">
			<p>恭喜获得</p>
			<h1><span class="quan"></span>元优惠券</h1>
			<p>已放置"个人中心"</p>
			<img src="images/pri-img.jpg" alt="">
			<a href="personal.html" class="personal">个人中心</a>
			<a href="javascripr:;" class="next">继续挑战</a>
		</div>
	</div>
	
	<!-- 机会用完弹窗 -->
	<div class="prize-con over">
		<div class="prize-wrap">
			<p>5次机会已用完</br>请明日再来吧</p>
			<img src="images/fail.jpg" alt="">
			<a href="javascripr:;" class="next matop">知道了</a>
		</div>
	</div>

	<!-- 未中奖弹窗 -->
	<div class="prize-con fail">
		<div class="prize-wrap">
			<p>很遗憾!这次运气不佳呢！</p>
			<img src="images/fail.jpg" alt="">
			<a href="javascripr:;" class="next matop">继续挑战</a>
		</div>
	</div>
	<script>
		$(function(){

			function getRandom(min,max){
			    //x上限，y下限
			    var x = max;
			    var y = min;
			    if(x<y){
			        x=min;
			        y=max;
			    }
			    var rand = parseInt(Math.random() * (x - y + 1) + y);
			    return rand;
			}

			var flag= true;
			$('.user-hand img').click(function(event) {
				if(flag){
					var kk = false;
					$.ajax({
						url: 'ajax_num.php',
						type: 'post',
						async: false,
						data: {openid: '<?php echo $openid;?>'},
						success: function (data) {
							data = eval(data);
							if (data == 1) {
								kk = true;
							}
						}
					});
					if (!kk) {
						$('.over,.mask').show();
						return;
					}
					var num = getRandom(1, 3);//系统随机
					var index = $(this).attr('data-num');//用户选择

					//显示动画
					$('.hand1').attr('src', 'images/' + num + '.png');
					$('.hand-wrap').addClass('fadeInDown animated');
					$('.hand2').addClass('fadeInUp animated');
					$('.punches').css('opacity', '1');

					if (index == 1) {
						$('.hand2').attr('src', 'images/1.png');
					}
					if (index == 2) {
						$('.hand2').attr('src', 'images/2.png');
					}
					if (index == 3) {
						$('.hand2').attr('src', 'images/3.png');
					}
					setTimeout(function () {
						if ((num == 1 && index == 3) || (num == 2 && index == 1) || (num == 3 && index == 2)) {//PK赢了显示
							$.ajax({
								url: 'ajax_game.php',
								type: 'post',
								async: false,
								data: {openid: '<?php echo $openid;?>'},
								success: function (data) {
									data = eval(data);
									$('.quan').html(data);
									$('.success,.mask').show();
								}
							});
						} else {
							$('.fail,.mask').show()
						}

					}, 2000)
					flag = false;
				}
			});

			// 继续挑战开始
			$('.next').click(function(event) {
				flag = true;
				$('.mask,.prize-con').hide();
				$('.hand-wrap').removeClass('fadeInDown animated');
				$('.hand2').removeClass('fadeInUp animated');
				$('.punches').css('opacity','0');
			});

		})
	</script>
</body>
</html>