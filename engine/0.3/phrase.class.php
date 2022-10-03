<?php

	include_once('encoder.class.php');

	class Phrase {
	
		private $rouletteBase = 6;
		private $text;
		private $replacements = array ('noun'=>'','subjnoun'=>'','verb'=>'','adj'=>'');
		private $id;
		private $roulette;
		
		public function __construct($text){
			$this->text = $text;
		}
		
		public function getUNIQ(){
			$uniq = Encoder::Encode(array($this->encodeRoulette(),$this->encodeReplacements()));

			return $uniq;
		}
		
		public function fromUNIQ($text){
			$uniq = $this->decodeUNIQ($text);
			$this->roulette = $uniq[0];
			$this->replacements['noun'] = $this->Replacements('{noun}','Noun',$uniq[1]);
			$this->replacements['subjnoun'] = $this->Replacements('{subjnoun}','SubjNoun',$uniq[2]);
			$this->replacements['verb'] = $this->Replacements('{verb}','Verb',$uniq[3]);
			$this->replacements['adj'] = $this->Replacements('{adj}','Adjective',$uniq[4]);
		}
		
		private function decodeUNIQ($text){
			$raw = Encoder::Decode($text);
			$uniq[0] = $this->decodeRoulette($raw);
			$this->Prepare();
			$i = ceil(Knowledge::RouletteCount()/$this->rouletteBase);
			foreach ($this->replacements as $rep){				
				$item = array();
				foreach ($rep as $r){
					$item[] = $raw[$i];
					$i++;
				}
				$uniq[] = $item;
			}
			return $uniq;
		}
		
		public function Prepare(){
			$this->replacements['noun'] = $this->Replacements('{noun}','Noun');			
			$this->replacements['subjnoun'] = $this->Replacements('{subjnoun}','SubjNoun');			
			$this->replacements['verb'] = $this->Replacements('{verb}','Verb');
			$this->replacements['adj'] = $this->Replacements('{adj}','Adjective');
		}
		
		private function Replacements($text,$function,$data=''){
			$count = substr_count($this->text,$text);
			
			$arr = array();
			for ($i=0;$i<$count;$i++){
				if (!empty($data))
					$arr[] = Knowledge::$function($data[$i]);
				else
					$arr[] = Knowledge::$function();
			}
			
			return $arr;
		}
		
		private function encodeReplacements(){
			$out = $this->replacements;
			foreach ($out as &$rep){
				foreach ($rep as &$item){
					unset($item[0]);
				}
			}
			
			return $out;
		}
		
		private function decodeRoulette($arr){
			$count = ceil(Knowledge::RouletteCount()/$this->rouletteBase);
			$out = '';
			for ($i=0;$i<$count;$i++){
				$num = base_convert($arr[$i],10,2);
				while (strlen($num) < $this->rouletteBase){
					$num = '0'.$num;
				}
				$out .= $num;
			}
			
			while (strlen($out)>Knowledge::RouletteCount()){
				$out = substr($out,1);
			}
			
			return $out;
		}
		
		private function encodeRoulette(){
			$roulette = $this->roulette;
			$count = ceil(Knowledge::RouletteCount()/$this->rouletteBase);
			while (strlen($roulette) < $count * $this->rouletteBase){
				$roulette = '0'.$roulette;
			}
			$out = array();
			for ($i=0;$i<$count;$i++){
				$out[] = base_convert(substr($roulette,$i*$this->rouletteBase,$this->rouletteBase),2,10);
			}			
			return $out;
		}
				
		private function ReplacementExists($type,$index){
			return !empty($this->replacements[trim($type,'{} ')][$index]);
		}
		
		private function Replacement($type,$index){
			return $this->replacements[trim($type,'{} ')][$index][0];
		}
		
		private function replace($text){
			$count = substr_count($this->text,$text);
			for ($i=0;$i<$count;$i++){
				if ($this->ReplacementExists($text,$i)){
@					$rep = $this->Replacement($text,$i);
					$this->text = substr_replace($this->text,$rep,strpos($this->text,$text),strlen($text));
				}
			}
		}
		
		public function replacePretexts(){
			$this->replace('{pre}');
		}
		
		public function replaceNouns(){
			$this->replace('{noun}');
		}
		
		public function replaceSubjNouns(){
			$this->replace('{subjnoun}');
		}
		
		public function replaceVerbs(){
			$this->replace('{verb}');
		}
		
		public function replaceAdjectives(){
			$this->replace('{adj}');
		}
		
		public function replaceSingularVerbs(){
			$count = substr_count($this->text,'{averb}');
			
			for ($i=0;$i<$count;$i++){
			
				$place = strpos($this->text,'{averb}');
				
				$nplace=$place;
			
				for ($j=$place-2;$this->text[$j]!=' ';$j--){
					$nplace=$j;
				}
				
				$noun = substr($this->text,$nplace,$place-$nplace);
				
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
				
				$this->text = substr_replace($this->text,$averb,strpos($this->text,'{averb}'),7);
			}
		}
		
		private function getRouletteArray(){
			$out = array();
			for ($i=0;$i<Knowledge::RouletteCount();$i++){
				$out[] = $this->roulette[$i];
			}
			
			return $out;
		}
		
		public function Roulette(){
			$count = substr_count($this->text,'[');
			$roule = array();
			if (empty($this->roulette)){
				for ($i=0;$i<$count;$i++){
					$roule[] = round(rand(0,1));
				}
				$this->roulette = implode('',$roule);
			} else {
				$roule = $this->getRouletteArray();
			}
						
			reset($roule);
			
			while (substr_count($this->text,'[')){
				for ($i=0;$i<$count;$i++){
					$j = current($roule);
					next($roule);
					$place = strpos($this->text,'[');
					$end = $this->findTheEnd($place);

					if ($j>0){
						$this->text = substr_replace($this->text,'',$place,$end-$place);
					} else {
						$this->text = substr_replace($this->text,substr($this->text,$place+1,$end-$place-2),$place,$end-$place);
					}
					
					$count = substr_count($this->text,'[');
				}
			}
		}
		
		private function findTheEnd($from){
			$end = $from+1;
			
			$l = $this->text[$end];
			
			$stack = 0;
			
			while ($end<strlen($this->text)-1&&($l!=']'||$stack>0)){
				if ($l=='[') $stack++;
				if ($stack>0) if ($l==']') $stack--;
				$end++;
				$l = $this->text[$end];
			}
			
			$end++;
			
			return $end;
		}
		
		private function Exclusions(){
			$this->text = trim($this->text);
			$this->text = str_replace('fallen a ','fallen ',$this->text);		
			$this->text = preg_replace('/ (a|an|the) ((a|an|the) )+/',' $1 ',$this->text);			
			$this->text = preg_replace('/^(a|an|the) (a|an|the) /','$1 ',$this->text);			
			$this->text = preg_replace('/^(a|an|the) ([a-zA-Z]+) (a|an|the) /','$1 $2 ',$this->text);
			$this->text = preg_replace('/ (a|an|the) ([a-zA-Z]+) (a|an|the) /',' $1 $2 ',$this->text);
			$this->text = preg_replace('/ (a|an|the) ([a-zA-Z]+) (a|an|the) ([a-zA-Z]+) (a|an|the) /',' $1 $2 $4 ',$this->text);
			$this->text = preg_replace('/ (a|an|the) ([a-zA-Z]+) ([a-zA-Z]+) (a|an|the) /',' $1 $2 $3 ',$this->text);
			$this->text = preg_replace('/ (are|is) (a|an) /',' $1 the ',$this->text);			
			$this->text = preg_replace('/ ([a-zA-Z]+)s is /',' $1s are ',$this->text);			
			$this->text = preg_replace('/ of ([a-zA-Z]+)s are /',' of $1s is ',$this->text);			
			$this->text = preg_replace('/ ([a-zA-Z]+)s ([a-zA-Z]+)s (?!are)/',' $1s $2 ',$this->text);			
			$this->text = preg_replace('/ (a|an) ([a-zA-Z]+) ([a-zA-Z]+[^s])s$/',' $2 $3s',$this->text);			
			$this->text = preg_replace('/ (a|an) ([a-zA-Z]+) ([a-zA-Z]+[^s])s /',' $2 $3s ',$this->text);			
			$this->text = preg_replace('/ (a|an|the) ([a-zA-Z]+) we /',' $2 we ',$this->text);			
			$this->text = preg_replace('/^(a|an) ([a-zA-Z]+) ([a-zA-Z]+)s /U','$2 $3s ',$this->text);			
			$this->text = preg_replace('/ (a|an|the) ([a-zA-Z]+) (a|an|the) /',' $1 $2 ',$this->text);
                        $this->text = preg_replace('/ another ([a-zA-Z]+[^s])s /',' other $1s ',$this->text);
                        $this->text = preg_replace('/ another ([a-zA-Z]+[^s])s$/',' other $1s',$this->text);
			$this->text = preg_replace('/ \{[a-z]+\} /',' ',$this->text);
			$this->Clearify();
			$this->text = preg_replace('/ of ([a-zA-Z]+) (a|an|the) /',' of $2 $1 ',$this->text);			
			$this->text = str_replace(' the another',' another',$this->text);		
			$this->text = str_replace('another a ','another ',$this->text);		
			$this->text = str_replace(' is lost ',' is the lost ',$this->text);		
			$this->text = str_replace('the us','us',$this->text);
                        $this->text = str_replace('lonely an','a lonely',$this->text);
                        $this->text = str_replace('another an','another',$this->text);
                        $this->text = preg_replace('/ (a)? fallen another /',' another fallen ',$this->text);
		}
		
		private function Clearify(){
			while (strstr($this->text,'  ')){
				$this->text = str_replace('  ',' ',$this->text);
			}		
		}
		
		public function Format(){
			$this->Clearify();
			
			$this->Exclusions();
			
			$this->text = trim($this->text); 
			$this->text = ucfirst($this->text);
		}
		
		public function Show(){
			echo $this->text;
		}
		
		public function JSON(){
			echo json_encode(array('text'=>$this->text,'uniq'=>$this->getUNIQ()));
		}
		
	}

?>