<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
	<div>
		<input type="text" name="s" id="s" value="Search" onfocus="document.forms['searchform'].s.value='';" onblur="if (document.forms['searchform'].s.value == '') document.forms['searchform'].s.value='Search';" />
		<input type="submit" id="searchsubmit" value="Search" />
	</div>
</form>
