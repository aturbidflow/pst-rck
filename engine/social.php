			<!-- Put this div tag to the place, where the Like block will be -->
			<div id="vk_like"></div>
			<script type="text/javascript">
			VK.Widgets.Like("vk_like", {type: "button"});
			</script><br/>
			<!-- Put this script tag to the place, where the Share button will be -->
			<div id="vk_share"><script type="text/javascript"><!--
			document.write(VK.Share.button({url: "http://pst-rck.nw-lab.com/new.php<?php if (!empty($_GET)) echo '?id='.$_GET['id']; ?>", image: "http://cs309925.userapi.com/v309925164/138e/80-YdjSDi1w.jpg", title: "<?php $gen->Show(); ?>", description: "HOPE",noparse: true},{type: "button", text: "Поделиться"}));
			--></script></div><br/>
			<a href="https://twitter.com/share" class="twitter-share-button" data-text="«<?php $gen->Show(); ?>» by" data-lang="ru" data-hashtags="HOPE">Твитнуть</a>
