<?php
		echo '
		<div id=actions class=p10>
			<span id=fontselect>
				<span>Text size: </span>
				<span id=small> A </span>
				<span id=med> A </span>
				<span id=large> A </span>
			</span>
		</div>';
		require_once('userinfo.php');
		if (curPageName()=='menuplanner.php') {
			require_once('menu.php');
		} else if (curPageName()=='display.php' ) {
			if (!isset($public)) {require_once('menu.php');}
		} else if (curPageName()=='search.php') {
            echo '<div id=results></div>';
		} else if (curPageName()=='shopping-list.php') {
			require_once('menu.php');
		}
?>
