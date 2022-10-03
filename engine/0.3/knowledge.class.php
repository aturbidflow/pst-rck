<?php

	class Knowledge {
		
		private static $template = '[[And]] [[[so,]]] [the] [{adj} ]{noun} {verb} [the] [{adj} ]{subjnoun}';
		
		private static $adjectives = array('a dark','a static','a last','a dying','a lonely','a sad','a sacred','a cold','a cruel','a poor','a bleak','a black','a mad','a frozen','a blind','a broken','a deaf','a shapeless','a','a silent','a roar of','a nasty','a long','a white','another','an infinite');
	
		private static $nouns = array('we','a wind','Sun','a space','God','sky','skies','trees','a star','stars','a hope','an end','a collapse','eternity','distance','a journey','a nebula','a desert','oblivion','remembrance','a twilight','horizons','a coma','everything','holes','a rain','hands','a winter','snow','a noise','a wisdom','a beast','a dust','time','a silence','a war','a mind','an autumn','tears','a truth','a guilt','a moon','a cloud','an explosion','a ghost','a pessimist','a sunrise','a rift','an orion','a snowfall','a loss','a collision','clouds','a scream','the evening','the morning');
		//$subjnouns[0] = 'us';
	
		private static $participles = array('away','apart','at last');
	
		private static $verbs = array('{averb} [the] a lost','got lost in','got lost at','{averb} a fallen','gone with','lost','falls into','falls to','lose','{averb} a lack of {adj}','fights with','fights against','fades to','fades out of','stays away from','{averb} losing','{averb} falling to','{averb} falling in','{averb} a fighting','{averb} fighting with','{averb} a fading','{averb} fading to','{averb} staying','{averb} staying with','{averb} staying away from','of a fallen','dives in','is diving in','drowns','is drowning','will dive in','ruins','escapes from','{averb} escaping from','wakes','bewares','talks to','{averb} talking to','calls','{averb} calling','sleeps in','{averb} retreating from','{averb} breathing to','eats','{averb} leaving');
	
		private static $pretexts = array ('to','at','in','by','below','above');
		
		public static function RouletteCount(){
			return substr_count(Knowledge::$template,'[');
		}
		
		public static function Template(){
			return Knowledge::$template;
		}
		
		private static function getRND($arr){
			$index = floor(rand(0,count($arr)-1));
			return array($arr[$index],$index);
		}
		
		private static function getKnown($arr,$key){
			return array($arr[$key],$key);
		}
		
		public static function Adjective($data=''){
			if ($data === '')
				return Knowledge::getRND(Knowledge::$adjectives);
			else
				return Knowledge::getKnown(Knowledge::$adjectives,$data);
		}
		
		public static function Pretext($data=''){
			if ($data === '')
				return Knowledge::getRND(Knowledge::$pretexts);
			else
				return Knowledge::getKnown(Knowledge::$pretexts,$data);
		}
		
		public static function Noun($data=''){
			if ($data === '')
				return Knowledge::getRND(Knowledge::$nouns);
			else
				return Knowledge::getKnown(Knowledge::$nouns,$data);
		}
		
		public static function SubjNoun($data=''){
			$subj = Knowledge::$nouns;
			$subj[0] = 'us';
			if ($data === '')
				return Knowledge::getRND($subj);
			else
				return Knowledge::getKnown($subj,$data);
		}
		
		public static function Verb($data=''){
			if ($data === '')
				return Knowledge::getRND(Knowledge::$verbs);
			else
				return Knowledge::getKnown(Knowledge::$verbs,$data);
		}
		
	}

?>