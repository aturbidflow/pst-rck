<?php
function findTheEnd($template,$from){
	$end = $from+1;
	
	$l = $template[$end];
	
	$stack = 0;
	
	while ($end<strlen($template)-1&&($l!=']'||$stack>0)){
		if ($l=='[') $stack++;
		if ($stack>0) if ($l==']') $stack--;
		$end++;
		$l = $template[$end];
	}
	
	$end++;
	
	return $end;
}

function findVariations($template,$from,&$variations){
	$end = $from+1;

	echo "end=$end<br>\r\n";
	
	$l = $template[$end];

	$variations = array();
	
	while ($end<strlen($template)&&$l!=')'){

		$item = '';
		
		while ($end<strlen($template)&&$l!='|'&&$l!=')'){
			echo "$l ";
			if ($l=='(') $end = findVariations($template,$end,$item)-1;
			else {
				$item.=$l;
				$end++;
			}
			$l = $template[$end];
		}
		
		echo "\r\n";
		print_r($item);
		
		echo "\r\n";
		
		$variations[] = $item;

		if ($l!=')') $end++;
		$l = $template[$end];
	}
	
	return $end;
}

//generation script goes here

$hope = false;

	$adjectives = array('dark','static','last');
	
	$nouns = array('wind','sun','space','we','god','sky','skies','trees','star','stars','hope','end');
	$subjnouns = array('wind','sun','space','us','god','sky','skies','trees','star','stars','hope','end');
	
	$verbs = array('lost','fallen','gone');
	
	$verbswithpres = array('lost in','lost at','fallen to','gone with','lost','fallen in','lose');
	
	$pres = array ('to','at','in','by');
	
	$template = '[And] [so] [{adj}] {noun} [{averb}] {verbpre} [the] [{adj}] {subjnoun}';
	
	//pres
	$count = substr_count($template,'{pre}');
	
	for ($i=0;$i<$count;$i++){
		$j = floor(rand(0,count($pres)-1));
		$template = substr_replace($template,$pres[$j],strpos($template,'{pre}'),5);
	}
	
	//nouns
	$count = substr_count($template,'{noun}');
	
	for ($i=0;$i<$count;$i++){
		$j = floor(rand(0,count($nouns)-1));
		$template = substr_replace($template,$nouns[$j],strpos($template,'{noun}'),6);
	}
	
	//subjective nouns
	$count = substr_count($template,'{subjnoun}');
	
	for ($i=0;$i<$count;$i++){
		$j = floor(rand(0,count($subjnouns)-1));
		$template = substr_replace($template,$subjnouns[$j],strpos($template,'{subjnoun}'),10);
	}
	
	//verbs
	$count = substr_count($template,'{verb}');
	
	for ($i=0;$i<$count;$i++){
		$j = floor(rand(0,count($verbs)-1));
		$template = substr_replace($template,$verbs[$j],strpos($template,'{verb}'),6);
	}
		
	//verbs with pres
	$count = substr_count($template,'{verbpre}');
	
	for ($i=0;$i<$count;$i++){
		$j = floor(rand(0,count($verbswithpres)-1));
		$template = substr_replace($template,$verbswithpres[$j],strpos($template,'{verbpre}'),9);
	}
		
	//adjectives
	$count = substr_count($template,'{adj}');
	
	for ($i=0;$i<$count;$i++){
		$j = floor(rand(0,count($adjectives)-1));
		$template = substr_replace($template,$adjectives[$j],strpos($template,'{adj}'),5);
	}
	
	//unrequired
	$count = substr_count($template,'[');
	
	for ($i=0;$i<$count;$i++){
		$j = floor(rand(0,1));
		$place = strpos($template,'[');
		$end = findTheEnd($template,$place);

		if ($j>0){						
			$template = substr_replace($template,'',$place,$end-$place);
		} else {
			$template = substr_replace($template,substr($template,$place+1,$end-$place-2),$place,$end-$place);
		}
	}

	//averbs
	$count = substr_count($template,'{averb}');
	
	for ($i=0;$i<$count;$i++){
	
		$place = strpos($template,'{averb}');
		
		$nplace=$place;
	
		for ($j=$place-2;$template[$j]!=' ';$j--){
			$nplace=$j;
		}
		
		$noun = substr($template,$nplace,$place-$nplace);
		
		switch (trim($noun)){
			case 'we':
			case 'you':
			case 'they':
				$averb = 'are';
			break;
			case 'I':
				$averb = 'am';
			break;
			default:
				$averb = 'is';
			break;
		}
		
		if (substr($noun,-1)=='s') $averb = 'are';
		
		$template = substr_replace($template,$averb,strpos($template,'{averb}'),7);
	}
	
	$template = ucfirst(trim(str_replace('  ',' ',$template)));

	$hope = true;

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">

	<title>HOPE</title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<link rel="stylesheet" href="style.css" type="text/css" media="screen">

	<script src="jquery.min.js"></script>
	
</head>
<body>
	<div id="page">
		<div id="the-phrase">
			<?php if ($hope) echo $template; ?>
		</div>
		<form method="post" action="/">
			<input type="hidden" name="generate" value="true" />
			<input id="runbtn" type="submit" value="HOPE" />
		</form>
	</div>
		<footer>
			<span>&copy; 2012 <a href="http://necrowolf.nw-lab.com">Артем Вульф</a>.</span><br/><br/>
			<b>Спасибо за идею сообществу <a href="http://vk.com/typical_post_rocker">Типичный Пост-Рокир</a></b>,<br/>а именно: <a href="http://vk.com/iamthemorning">Buying Soul</a>, <a href="http://vk.com/id3789843">Николаю Корсуну</a>, <a href="http://vk.com/dethwyn">Дмитрию Сницаруку</a> и <a href="http://vk.com/tramvaev">Андрею Трамваему</a> (я не знаю, при чем он тут, но он попросил).
		</footer>
</body>
</html>