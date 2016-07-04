<?php
header("Content-type:text/html;charset=utf-8");
include 'public/coon.php';
include 'public/Wechat.class.php';
include('public/jssdk.php');
$jssdk = new JSSDK('wx091f708185659476', '69f74ea8fb47c5585967073b537f262a');
$signPackage = $jssdk->GetSignPackage();
session_start();

if(($_SESSION["openid"])==null){
    if($_GET['code']==""){
        header("Location: login.php");
    }else{
        $wc = new Wechat();
        $re = $wc->get_access_token($_GET['code']);

        $access_token = $re['access_token'];
        $openid = $re['openid'];
        $re = $wc->get_user_info($access_token,$openid);
        $headimgurl = $re['headimgurl'];
        $nickname = $re['nickname'];
        //昵称
        $_SESSION["nickname"] = $nickname;
        //用户头像，openid
        $_SESSION["headimgurl"] = $headimgurl;
        $_SESSION["openid"] = $openid;
    }
}

if(($_SESSION["openid"])!= null){

    $openid = $_SESSION["openid"];
    $db = mysql_query("select * from ya_li where openid = '{$openid}'");
    $res = mysql_fetch_assoc($db);
    if(!$res){
        $res = "insert into ya_li(openid) values('{$openid}')";
        $re = mysql_query($res);
    }
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
<body class="bg1">
	
	<a href="javascripr:;" class="relu-btn">游戏规则</a>
	<img class="pulse animated1" src="images/p1.png" alt="">
	<div class="sy-btns">
		<a href="game.html"></a>
		<a href="personal.html"></a>
	</div>

	<!-- 规则弹窗 -->
	<div class="mask"></div>
	<div class="relu">
		<a href="javascripr:;" class="know"></a>
	</div>
	
	<script>
		$('.relu-btn').click(function(event) {
			$('.mask,.relu').show()
		});
		$('.know').click(function(event) {
			$('.mask,.relu').hide()
		});

	</script>

</body>
</html>