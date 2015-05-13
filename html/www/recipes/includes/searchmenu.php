<?php
        

        if(!isset($idlist)) {
            require_once('rdb.php');
            $idlist = $_POST['idlist'];
        }
	
        $response['menu']="<h3 class=p10><strong>search results</strong></h3><div class=p10><strong>Recipes will open in a new window</div>";
		$sql = "SELECT DISTINCT get_category(cat) as category, cat FROM recipe_cat_subcat where recipe in($idlist) ORDER BY category";
		$db = $rdb->prepare($sql); 
        $db->execute();
        $err=$rdb->errorInfo();
        $rows = $db->rowCount();
        $dbcatmenu = $db->fetchAll(PDO::FETCH_BOTH);
        $db->closeCursor();

		if ($rows>0) {
		$response["menu"] .= '<nav><ul class="sb-menu">';

		$cct=0;
		for ($lt = 0; $lt < $rows; $lt++){
			$cct++;
			$catmenu = $dbcatmenu[$lt][0];
			$catid = $dbcatmenu[$lt][1];

			$response["menu"] .= "<li><a href='javascript:void(0);' class='sb-toggle-submenu'  >$catmenu<span class='sb-caret'></span></a>";
			$response["menu"] .= '<ul class="sb-submenu">';

			$sql = "SELECT DISTINCT get_subcategory(subcat) as subcategory , subcat FROM recipe_cat_subcat
					WHERE cat = $catid and subcat > 0 and recipe in(".$idlist.") ORDER BY subcategory";
			
            $db = $rdb->prepare($sql);
            $db->execute();
            $err=$rdb->errorInfo();
            $scnum = $db->rowCount();
            $dbsubcatmenu = $db->fetchAll(PDO::FETCH_BOTH);
            $db->closeCursor();

			$sql = "SELECT DISTINCT get_recipename(recipe) as recipename, recipe FROM recipe_cat_subcat
					WHERE cat = $catid AND subcat is null and recipe in(".$idlist.") ORDER BY recipename";
            $db = $rdb->prepare($sql);
            $db->execute();
            $err=$rdb->errorInfo();
            $num = $db->rowCount();
            $dbrecipe = $db->fetchAll(PDO::FETCH_BOTH);
            $db->closeCursor();

			if (isset($dbsubcatmenu)){
				$scct=0;
				for ($lt1 = 0; $lt1 < $scnum; $lt1++){
					$scct++;
					$subcatmenu = $dbsubcatmenu[$lt1][0];
					$subcatid = $dbsubcatmenu[$lt1][1];
					$response["menu"] .= "<li><a href='javascript:void(0);' class='sb-toggle-submenu' class='sb-toggle-submenu'  >$subcatmenu<span class='sb-caret'></span></a>";
					$response["menu"] .= '<ul class="sb-submenu">';

					$sql = "SELECT DISTINCT get_recipename(recipe) as recipename, recipe FROM recipe_cat_subcat
						WHERE cat = $catid AND subcat = $subcatid and recipe in(".$idlist.") ORDER BY recipename";
                    $db = $rdb->prepare($sql);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $scrnum = $db->rowCount();
                    $dbscrecipe = $db->fetchAll(PDO::FETCH_BOTH);
                    $db->closeCursor();

					if (isset($dbscrecipe)) {
						$ct=0;
						for ($lt2 = 0; $lt2 < $scrnum; $lt2++){
							$ct++;
							$recipeid = $dbscrecipe[$lt2][1];
                            require('get_menu_recipe_owner.php');
							$recipe = stripslashes($dbscrecipe[$lt2][0]);

							$response["menu"] .= "<li><a target=_BLANK class='rlink o$rmowner hassubcat i$recipeid' href='display.php?search=yes'>$recipe</a></li>";
						}
					}
					$response["menu"] .= '</ul></li>';
				}
			}

			if (isset($dbrecipe)) {
				$ct=0;
				for ($lt3 = 0; $lt3 < $num; $lt3++){
					$ct++;
					$recipeid = $dbrecipe[$lt3][1];
					require('get_menu_recipe_owner.php');
                    $recipe = stripslashes($dbrecipe[$lt3][0]);
					$response["menu"] .= "<li><a href='javascript:void(0);' target=_BLANK class='rlink o$rmowner i$recipeid' href='display.php?search=yes' id=i$recipeid>$recipe</a></li>";
				}
			}
			$response["menu"] .= '</ul></li>';
		}
		$response["menu"] .= '</ul></nav>';
	}
	echo $response['menu'];
?>
