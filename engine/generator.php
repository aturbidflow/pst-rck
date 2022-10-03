<?php

include_once('knowledge.php');

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

function findRelations($template){
	preg_match_all('/\(\#([0-9]+)\=([^\)]+)\)/Uis',$template,$values);
	
	preg_match_all('/\?([0-9]+)/Uis',$template,$conds);
	
	$vals = array();
	
	if (!empty($values)){
		
		for($i=0;$i<count($values[0]);$i++){
			$vals[$values[1][$i]]=$values[2][$i];
			$template = str_replace($values[0][$i],'',$template);
		}
		
		for($i=0;$i<count($conds[0]);$i++){
			$template = str_replace($conds[0][$i],$vals[$conds[1][$i]],$template);
		}
		
	}
	
	return $template;
}

function Generate(){

		$template = '[And] [[[so]]] [{adj}] {noun} {verb} [the] [{adj}] {subjnoun}';
		
		global $adjectives;
		global $nouns;
		global $subjnouns;
		global $verbs;
		global $participle;
		global $verbswithpres;
		global $pres;
		
		//pres
		$count = substr_count($template,'{pre}');
		
		for ($i=0;$i<$count;$i++){
			$j = floor(rand(0,count($pres)-1));
			$template = substr_replace($template,$pres[$j],strpos($template,'{pre}'),5);
		}
		
		//echo "Pre: '$template'\r\n";
		
		//nouns
		$count = substr_count($template,'{noun}');
		
		for ($i=0;$i<$count;$i++){
			$j = floor(rand(0,count($nouns)-1));
			$template = substr_replace($template,$nouns[$j],strpos($template,'{noun}'),6);
		}
		
		//echo "Nouns: '$template'\r\n";
		
		//subjective nouns
		$count = substr_count($template,'{subjnoun}');
		
		for ($i=0;$i<$count;$i++){
			$j = floor(rand(0,count($subjnouns)-1));
			$template = substr_replace($template,$subjnouns[$j],strpos($template,'{subjnoun}'),10);
		}
		
		//echo "More nouns: '$template'\r\n";
		
		//verbs
		$count = substr_count($template,'{verb}');
		
		for ($i=0;$i<$count;$i++){
			$j = floor(rand(0,count($verbs)-1));
			$template = substr_replace($template,$verbs[$j],strpos($template,'{verb}'),6);
		}
		
		//echo "Verbs: '$template'\r\n";
			
		//adjectives
		$count = substr_count($template,'{adj}');
		
		for ($i=0;$i<$count;$i++){
			$j = floor(rand(0,count($adjectives)-1));
			$template = substr_replace($template,$adjectives[$j],strpos($template,'{adj}'),5);
		}
		
		//echo "Adjectives: '$template'\r\n";
		
		//unrequired
		$count = substr_count($template,'[');
		
		while (substr_count($template,'[')){
			for ($i=0;$i<$count;$i++){
				$j = floor(rand(0,1));
				$place = strpos($template,'[');
				$end = findTheEnd($template,$place);

				if ($j>0){
					$template = substr_replace($template,'',$place,$end-$place);
				} else {
					$template = substr_replace($template,substr($template,$place+1,$end-$place-2),$place,$end-$place);
				}
				
				$count = substr_count($template,'[');
			}
		}
			
		//echo "Need?: '$template'\r\n";

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
		
		//echo "Add: '$template'\r\n";
		
		//relations
		$template = findRelations($template);
		
		return ucfirst(trim(str_replace('  ',' ',$template)));
		
	}
?>