$(document).ready(function(){

	tweet();

	var footerheight = $('#thnx').css('height');
	$('#thnx').stop().animate({
		height: "2em"
	},100);
	
	$('footer').hover(function(){
		$('#thnx').stop().animate({
			height: footerheight
		},200);
	},function(){
		$('#thnx').stop().animate({
			height: "2em"
		},200);
	});
	
	$('#runbtn').click(function(e){
		e.preventDefault();
                
                var thephrase = $('#the-phrase');
                
                var tmpH = thephrase.height();
		
		thephrase.css('min-height',tmpH).empty().html('<img src="/ajax-loader.gif" />');
		
		$.getJSON('engine/ajax.0.3.php',function(data) { 
				html = data.text;
				window.history.replaceState({"uniq":data.uniq},'HOPE &mdash '+data.text,'/'+data.uniq);
				$('#the-phrase').html(html);
				$('meta[name=description]').text(html);
				$('#vk_share').html(VK.Share.button({url: "http://pst-rck.nw-lab.com/"+data.uniq,image: "http://cs309925.userapi.com/v309925164/138e/80-YdjSDi1w.jpg", title: html, description: "HOPE",noparse: true},{type: "button", text: "Поделиться"}));
				$('#twitter-wjs').remove();
				$('iframe.twitter-share-button').remove();
				$('#social').append('<a href="https://twitter.com/share" class="twitter-share-button" data-text="«'+html+'» by" data-lang="ru" data-hashtags="HOPE">Твитнуть</a>');
				tweet();
		});	
	});
});

function tweet(){
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
}