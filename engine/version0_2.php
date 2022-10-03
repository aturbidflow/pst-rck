<?php

	include_once('generator.php');

	$hope = true;

	$gen = Generate(); 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">

	<title>HOPE</title>
	
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="icon" href="bigicon.png" sizes="32x32">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="<?php echo $gen; ?>" />
	<meta name="application-name" content="H.O.P.E.">
	<meta name="application-url" content="http://pst-rck.nw-lab.com">
	<meta name="google" content="notranslate">
	<meta name="document-state" content="Dynamic" />
	<meta name="generator" content="hands">
	<meta name="version" content="0.2.2">	
	
	<meta itemprop="name" content="H.O.P.E. Generator">
	<meta itemprop="description" content="Make you fell in hope">
	<meta itemprop="image" content="/images/logoprop.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	
	<link rel="canonical" href="http://pst-rck.nw-lab.com" />
	<link rel="stylesheet" href="style.css" type="text/css" media="screen">

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script src="main.js"></script>
	<!-- Put this script tag to the <head> of your page -->
	<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?52"></script>

	<script type="text/javascript">
	  VK.init({apiId: 3120619, onlyWidgets: true});
	</script>
	<!-- Put this script tag to the <head> of your page -->
	<script type="text/javascript" src="http://vk.com/js/api/share.js?11" charset="windows-1251"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34742304-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
	<div id="page">
		<div id="the-phrase">
			<?php echo $gen; ?>
		</div>
		<form method="post" action="<?php echo $action; ?>">
			<input type="hidden" name="generate" value="true" />
			<input id="runbtn" type="submit" value="HOPE" />
		</form>
		<div id="social">
			<!-- Put this div tag to the place, where the Like block will be -->
			<div id="vk_like"></div>
			<script type="text/javascript">
			VK.Widgets.Like("vk_like", {type: "button"});
			</script><br/>
			<!-- Put this script tag to the place, where the Share button will be -->
			<div id="vk_share"><script type="text/javascript"><!--
			document.write(VK.Share.button({image: "http://cs309925.userapi.com/v309925164/138e/80-YdjSDi1w.jpg", title: "<?php echo $gen; ?>", description: "HOPE",noparse: true},{type: "button", text: "Поделиться"}));
			--></script></div><br/>
			<a href="https://twitter.com/share" class="twitter-share-button" data-text="«<?php echo $gen; ?>» by" data-lang="ru" data-hashtags="HOPE">Твитнуть</a>
		</div>
	</div>
		<footer>
			<div id="thnx">
				<?php include_once('thnx.htm'); ?>
			</div>
			<span>&copy; 2012 <a href="http://necrowolf.nw-lab.com">Артем Вульф</a>.</span><br/><br/>
		</footer>
</body>
</html>