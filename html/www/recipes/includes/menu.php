<?php

	

	if (isset($unapproved)) {
        if($client=='wrm') {
		    $sql = "$call query_unapproved_menu_cats(:oid)";
            $dbcatmenu = $rdb->prepare($sql);
            $dbcatmenu->bindValue(':oid', $oid);
            $dbcatmenu->execute();
            $err=$rdb->errorInfo();
        } else {
            $sql = "$call query_unapproved_menu_cats()";
            $dbcatmenu = $rdb->prepare($sql);
            $dbcatmenu->execute();
            $err=$rdb->errorInfo();
        }
	} else {
		$sql = "$call query_owner_favourites(:uid)";
        $dbfavs = $rdb->prepare($sql);
        $dbfavs->bindValue(':uid', $uid);
        $dbfavs->execute();
        $err=$rdb->errorInfo();
        $favrows=$dbfavs->rowCount();
        $rsfavs = $dbfavs->fetchAll(PDO::FETCH_BOTH);
        $dbfavs->closeCursor();
        
        if($client=='wrm') {
		    $sql = "$call query_owner_menu_cats(:oid)";
            $dbcatmenu = $rdb->prepare($sql);
            $dbcatmenu->bindValue(':oid', $oid);
            $dbcatmenu->execute();
            $err=$rdb->errorInfo();
        } else {
            $sql = "$call query_owner_menu_cats()";
            $dbcatmenu = $rdb->prepare($sql);
            $dbcatmenu->execute();
            $err=$rdb->errorInfo();
        }
	}
    $catrows=$dbcatmenu->rowCount();
    $rscatmenu = $dbcatmenu->fetchALL(PDO::FETCH_BOTH);
    $dbcatmenu->closeCursor();
    
    $response = array();
    $response["menu"]="";
    
	if ($catrows>0 || (isset($favrows) && $favrows>0)) {
		if (isset($unapproved)) {
			echo '<h3 class="p10 noprint"><strong>unapproved recipes</strong></h3>';
		} else {
			echo '<h3 class="p10 noprint"><strong>recipes</strong></h3>';
		}		
		
		$response["menu"] .= '<nav id=recnav><ul class="sb-menu ">';

		if (!isset($unapproved)) {
			//populate the category list with the database items returned
			if ($favrows>0) {
				$response["menu"] .= "<li id=favs><a class='sb-toggle-submenu'  >Favorites<span class='sb-caret'></span></a>";
				$response["menu"] .= '<ul class="sb-submenu">';
				$ct=0;
				for ($lt = 0; $lt < $favrows; $lt++){
					$ct++;
					$favid = $rsfavs[$lt][0];
					$recipe = stripslashes($rsfavs[$lt][1]);
					$response["menu"] .= "<li><a class='rlink o$uid' id=i$favid>$recipe</a></li>";
				}
				$response["menu"] .= '</ul></li>';
			}
		}
		$cct=0;
		for ($lt = 0; $lt < $catrows; $lt++){
			$cct++;
			$catmenu = $rscatmenu[$lt][0];
			$catid = $rscatmenu[$lt][1];

			$response["menu"] .= "<li class=cat id='$catmenu'><a class='sb-toggle-submenu'  >$catmenu<span class='sb-caret'></span></a>";
			$response["menu"] .= '<ul class="sb-submenu ">';

			if (isset($unapproved)) {
                if($client=='wrm') {
                    $sql = "$call query_unapproved_menu_subcats(:catid,:oid)";
                    $dbsubcatmenu = $rdb->prepare($sql);
                    $dbsubcatmenu->bindValue(':catid', $catid);
                    $dbsubcatmenu->bindValue(':oid', $oid);
                    $dbsubcatmenu->execute();
$err=$rdb->errorInfo();
                } else {
				    $sql = "$call query_unapproved_menu_subcats(:catid)";
                    $dbsubcatmenu = $rdb->prepare($sql);
                    $dbsubcatmenu->bindValue(':catid', $catid);
                    $dbsubcatmenu->execute();
$err=$rdb->errorInfo();
                }
			} else {
                if($client=='wrm') {
				    $sql = "$call query_owner_menu_subcats(:catid, :oid)";
                    $dbsubcatmenu = $rdb->prepare($sql);
                    $dbsubcatmenu->bindValue(':catid', $catid);
                    $dbsubcatmenu->bindValue(':oid', $oid);
                    $dbsubcatmenu->execute();
                    $err=$rdb->errorInfo();
                } else {
                    $sql = "$call query_owner_menu_subcats(:catid)";
                    $dbsubcatmenu = $rdb->prepare($sql);
                    $dbsubcatmenu->bindValue(':catid', $catid);
                    $dbsubcatmenu->execute();
                    $err=$rdb->errorInfo();
                }
			}
            $subcatrows = $dbsubcatmenu->rowCount();
            $rssubcatmenu = $dbsubcatmenu->fetchAll(PDO::FETCH_BOTH);
            $dbsubcatmenu->closeCursor();

			if (isset($unapproved)) {
                if($client=='wrm') {
				    $sql = "$call query_unapproved_menu_recipes_no_subcats(:catid,:oid)";
                    $dbrecipe = $rdb->prepare($sql);
                    $dbrecipe->bindValue(':catid', $catid);
                    $dbrecipe->bindValue(':oid', $oid);
                    $dbrecipe->execute();
$err=$rdb->errorInfo();
                } else {
                    $sql = "$call query_unapproved_menu_recipes_no_subcats(:catid)";
                    $dbrecipe = $rdb->prepare($sql);
                    $dbrecipe->bindValue(':catid', $catid);
                    $dbrecipe->execute();
$err=$rdb->errorInfo();
                }
			} else {
                if($client=='wrm') {
				    $sql = "$call query_owner_menu_recipes_no_subcats(:catid,:oid)";
                    $dbrecipe = $rdb->prepare($sql);
                    $dbrecipe->bindValue(':catid', $catid);
                    $dbrecipe->bindValue(':oid', $oid);
                    $dbrecipe->execute();
                    $err=$rdb->errorInfo();
                } else {
                    $sql = "$call query_owner_menu_recipes_no_subcats(:catid)";
                    $dbrecipe = $rdb->prepare($sql);
                    $dbrecipe->bindValue(':catid', $catid);
                    $dbrecipe->execute();
                    $err=$rdb->errorInfo();
                }
			}
			$dbrecrows=$dbrecipe->rowCount();
            $rsrecipe = $dbrecipe->fetchAll(PDO::FETCH_BOTH);
            $dbrecipe->closeCursor();

			if ($rssubcatmenu){
				$scct=0;
				for ($lt1 = 0; $lt1 < $subcatrows; $lt1++){
					$scct++;
					$subcatmenu = $rssubcatmenu[$lt1][0];
					$subcatid = $rssubcatmenu[$lt1][1];
					$response["menu"] .= "<li class=subcat id='$catmenu-$subcatmenu'><a class='sb-toggle-submenu' class='sb-toggle-submenu'  >$subcatmenu<span class='sb-caret'></span></a>";
					$response["menu"] .= '<ul class="sb-submenu">';

					if (isset($unapproved)) {
                        if($client=='wrm') {
						    $sql = "$call query_unapproved_menu_recipes(:catid,:subcatid,:oid)";
                            $dbscrecipe = $rdb->prepare($sql);
                            $dbscrecipe->bindValue(':catid', $catid);
                            $dbscrecipe->bindValue(':subcatid', $subcatid);
                            $dbscrecipe->bindValue(':oid', $oid);
                            $dbscrecipe->execute();
$err=$rdb->errorInfo();
                        } else {
                            $sql = "$call query_unapproved_menu_recipes(:catid,:subcatid)";
                            $dbscrecipe = $rdb->prepare($sql);
                            $dbscrecipe->bindValue(':catid', $catid);
                            $dbscrecipe->bindValue(':subcatid', $subcatid);
                            $dbscrecipe->execute();
$err=$rdb->errorInfo();
                        }
					} else {
                        if($client=='wrm') {
						    $sql = "$call query_owner_menu_recipes(:catid,:subcatid,:oid)";
                            $dbscrecipe = $rdb->prepare($sql);
                            $dbscrecipe->bindValue(':catid', $catid);
                            $dbscrecipe->bindValue(':subcatid', $subcatid);
                            $dbscrecipe->bindValue(':oid', $oid);
                            $dbscrecipe->execute();
                            $err=$rdb->errorInfo();
                        } else {
                            $sql = "$call query_owner_menu_recipes(:catid,:subcatid)";
                            $dbscrecipe = $rdb->prepare($sql);
                            $dbscrecipe->bindValue(':catid', $catid);
                            $dbscrecipe->bindValue(':subcatid', $subcatid);
                            $dbscrecipe->execute();
                            $err=$rdb->errorInfo();
                        }
					}
					$dbscrecrows=$dbscrecipe->rowCount();
                    $rsscrecipe = $dbscrecipe->fetchAll(PDO::FETCH_BOTH);
                    $dbscrecipe->closeCursor();

					if ($rsscrecipe) {
						$ct=0;
						for ($lt2 = 0; $lt2 < $dbscrecrows; $lt2++){
							$ct++;
							$recipeid = $rsscrecipe[$lt2][1];
                            require('get_menu_recipe_owner.php');
							$recipe = stripslashes($rsscrecipe[$lt2][0]);

							if (isset($unapproved)) {
                                $response["menu"] .= "<li><a href='javascript:void(0);' class='rlink o$rmowner hassubcat i$recipeid' >$recipe</a></li>";
                            } else {
                                $response["menu"] .= "<li><a href='javascript:void(0);' class='rlink o$rmowner hassubcat i$recipeid' >$recipe</a></li>";
                            }
						}
					}
					$response["menu"] .= '</ul></li>';
				}
			}

			if ($rsrecipe) {
				$ct=0;
				for ($lt3 = 0; $lt3 < $dbrecrows; $lt3++){
					$ct++;
					$recipeid = $rsrecipe[$lt3][1];
                    require('get_menu_recipe_owner.php');
					$recipe = stripslashes($rsrecipe[$lt3][0]);
					if (isset($unapproved)) {
						$response["menu"] .= "<li><a href='javascript:void(0);' class='rlink i$recipeid' >$recipe</a></li>";
					} else {
						$response["menu"] .= "<li><a href='javascript:void(0);' class='rlink o$rmowner i$recipeid' >$recipe</a></li>";
					}
				}
			}
			$response["menu"] .= '</ul></li>';
		}
		$response["menu"] .= '</ul></nav>';
	}
	echo $response['menu'];
?>
