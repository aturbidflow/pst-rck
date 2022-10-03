<?php
	include_once('phrase.3.4.class.php');
	
	include_once('knowledge.class.php');

	class pGenerator {
	
		private static $version = '0.3.6';
		
		public static function Version(){
			return pGenerator::$version;
		}
	
		public static function Generate($uniq=''){
			
			$phrase = new Phrase(Knowledge::Template());
			
			if (!empty($uniq)){

				$phrase->fromUNIQ($uniq);
			
			} else {
			
				$phrase->Prepare();
				
			}
				
			//pres
			$phrase->replacePretexts();
			
			//nouns
			$phrase->replaceNouns();
			
			//subjective nouns
			$phrase->replaceSubjNouns();
			
			//verbs
			$phrase->replaceVerbs();
				
			//adjectives
			$phrase->replaceAdjectives();
			
			//unrequired
			$phrase->Roulette();

			//averbs
			$phrase->replaceSingularVerbs();
			
			//relations
			//$template = findRelations($template);
			
			$phrase->Format();
			
			return $phrase;			
		}
	
	}

?>