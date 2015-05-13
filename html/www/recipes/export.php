<?php
	session_set_cookie_params('0', '/');
	session_start();

	require_once('includes/dbclient.php');
    require_once('includes/dbcalls.php');

    if(!isset($_SESSION[$client.'user'])) {
        //$page = curPageName();
        //header("Refresh:0 ; URL=index.php?timeout=yes&lastpage=".$page);
        header("Refresh:0 ; URL=index.php?timeout=yes");
        exit;
    }
    function curPageName() {
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }

    $user=$_SESSION[$client.'user'];
    $suser=$_SESSION[$client.'suser'];
    $uid=$_SESSION[$client.'uid'];
    $limit=$_SESSION[$client.'limit'];
    if(isset($_SESSION[$client.'rapp'])) {
         $rapp=$_SESSION[$client.'rapp'];
    }
    if(isset($_SESSION[$client.'datefmt'])) {
        $seldate = $_SESSION[$client.'datefmt'];
    }
    if(isset($_SESSION[$client.'admin'])) {
        $admin=$_SESSION[$client.'admin'];
    }
    if(isset($_SESSION[$client.'guest'])) {
        $guest=$_SESSION[$client.'guest'];
    }
    
    if($client=='wrm') {
        $oid=$_SESSION[$client.'oid'];
        $owner=$_SESSION[$client.'owner'];
        require_once('includes/dbvars.php');
    }

	$rdb = new PDO("$dbtype:host=$dbhost;dbname=$dbrecipes", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	if($user and $user!='') {
        if($client=='wrm') {
            $sql="$call query_owner_str(:user)";
            $crapp = $rdb->prepare($sql);
            $crapp->bindValue(':user', $user);
            $crapp->execute();
            $err=$rdb->errorInfo();
            $sendstr = $crapp->fetchColumn();
            $crapp->closeCursor();
            
            $sql="$call query_recipes_with_name_id_owner_visible(:oid)";
            $dbhidden = $rdb->prepare($sql);
            $dbhidden->bindValue(':oid', $oid);
            $dbhidden->execute();
            $err=$rdb->errorInfo();
            $hidden = $dbhidden->rowCount();
            $dbhidden->closeCursor();
            
            $sql = "$call query_user_number(:oid)";  //return all users from db
            $dbusers = $rdb->prepare($sql);
            $dbusers->bindValue(':oid', $oid);
            $dbusers->execute();
            $err=$rdb->errorInfo();
            $users = $dbusers->rowCount();
            $dbusers->closeCursor();
                                                     
        } else {
                        
            $sql="$call query_recipes_with_name_id_owner_visible()";
            $dbhidden = $rdb->prepare($sql);
            $dbhidden->execute();
            $err=$rdb->errorInfo();
            $hidden = $dbhidden->rowCount();
            $dbhidden->closeCursor();
            
            $sql = "$call query_user_number()";  //return all approved users from db
            $dbusers = $rdb->prepare($sql);
            $dbusers->execute();
            $err=$rdb->errorInfo();
            $users=$dbusers->rowCount();
            $dbusers->closeCursor();
            
            $sql = "$call query_unapp_user_number()";  //return all unapproved users from db
            $dbuausers = $rdb->prepare($sql);
            $dbuausers->execute();
            $err=$rdb->errorInfo();
            $uausers=$dbuausers->rowCount();
            $dbuausers->closeCursor();
        }
        
        
        
        $sql = "$call query_user_recipe_number(:uid)";  //return all recipes from db
        $dburecipe = $rdb->prepare($sql);
        $dburecipe->bindValue(':uid', $uid);
        $dburecipe->execute();
        $err=$rdb->errorInfo();
        $urecipes = $dburecipe->rowCount();
        $dburecipe->closeCursor();

        if($client=='wrm') {
            $sql="$call query_recipe_number(:oid)";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':oid', $oid);
            $dbrecipe->execute();
            $err=$rdb->errorInfo();
            $recipes = $dbrecipe->rowCount();
        } else {
            $sql="$call query_recipe_number()";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->execute();
            $err=$rdb->errorInfo();
            $recipes = $dbrecipe->rowCount();
        }
        if (isset($admin) && isset($rapp)) {
            $appct=0;
            while($row = $dbrecipe->fetch(PDO::FETCH_BOTH)) {
              $apprec=$row[1];
              if ($apprec) $appct++;
            }
            $unapprec = $recipes-$appct;
        }
        $dbrecipe->closeCursor();
    }
    if(isset($_POST['format'])) {
	    $recipe_format=$_POST['format'];
    }
    if(isset($_POST['export'])) {
	    $export=$_POST['export'];
    }
	if (isset($export) && $export == "Export") {
		if($_POST['related_recipe']){
            ini_set('max_execution_time', 600);
            $word_output = '';
            $mmf_output = '';
            $csv_output = '';
            $reccount=count($_POST['related_recipe']);
            $ct=0;
			while (list ($key, $val) = each ($_POST['related_recipe'])) {
				$ct++;
				unset($catarray);
				unset($ingarray);
				unset($relarray);
				unset($dietarray);
				unset($imgarray);
                unset($extraimages);
				unset($commarray);
				unset($commdatearray);
				unset($commownerarray);
				$id = $val;

				require('includes/getrecipe.php');
                
                if ($tried) {
                    $tried = TRUE;
                } else {
                    $tried = FALSE;
                }
                for ($lt = 0; $lt < $imgrows; $lt++) {
                       $imgarray[$lt]    = $rsimg[$lt][1];
                }
                for ($lt = 0; $lt < $srows; $lt++) {
                    $catarray[$lt][0] = $rscat[$lt][0];
                    $catarray[$lt][1] = $rscat[$lt][1];
                } 
                for ($lt = 0; $lt < $rrrows; $lt++) {
                    if ($id == $rsrel[$lt][0]) {
                        $relarray[$lt] = $rsrel[$lt][3];
                    }
                }
                for ($lt = 0; $lt < $drows; $lt++) {
                    $dietarray[$lt] = $rsdiet[$lt][0];
                }
                $sql="$call query_recipe_comments(:id)";
                $dbcomm = $rdb->prepare($sql);
                $dbcomm->bindValue(':id', $id);
                $dbcomm->execute();
                $err=$rdb->errorInfo();

                $commrows = $dbcomm->rowCount();
                $rscomm = $dbcomm->fetchAll(PDO::FETCH_BOTH);
                $dbcomm->closeCursor();
                
                for ($lt = 0; $lt < $commrows; $lt++) {
                       $comment=str_replace('"',"'",$rscomm[$lt][1]);
                       $commarray[$lt] = $comment;
                       $commentdate=str_replace('"',"'",$rscomm[$lt][2]);
                       $commdatearray[$lt] = $commentdate;
                       $commentowner=str_replace('"',"'",$rscomm[$lt][3]);
                       $commownerarray[$lt] = $commentowner;
                }

				if ($recipe_format == 'MS Word(.doc)') {
					$word_output .= "<div>";
                    $word_output .= "<h3 style='font-size:18px;'>$name</h3>";
                    if (isset($rating)) {
					    $word_output .="<img src='".$wrmpath."images/".$rating.".png'><br><br>";
                    }
                    if (isset($imgarray)) {
					   $word_output .="<img src='".$wrmpath."images/recipe/$imgarray[0]'>";
					}
					$word_output .= "<br><br><strong style='text-transform: uppercase;color: black;font-family: Tahoma,Geneva,sans-serif;font-size: 12px;'><u>Ingredients</u></strong><br><br>";
		
                    if ($irows>0) {
                        $word_output .= '<table>';
					    for ($lt = 0; $lt < $irows; $lt++) {
                            $word_output .= '<tr>';
						    $quantity = $rsing[$lt][0];
                            if (isset($quantity)) {
                                $word_output .= "<td>$quantity</td>";
                            } else {
                                $word_output .= "<td></td>";
                            }
						    $unit = $rsing[$lt][1];
                            $quantity2 = $rsing[$lt][5];
                            $eunit = $rsing[$lt][6];
                            if (isset($unit)) {
                                $word_output .= "<td>$unit";
                                if (isset($quantity2) && isset($eunit)) {
                                   $word_output .= "($quantity2 $eunit)"; 
                                } else if (isset($quantity2)) {
                                   $word_output .= "($quantity2)"; 
                                } else if (isset($eunit)) {
                                   $word_output .= "($quantity2)";
                                }
                                $word_output .= "</td>"; 
                            } else {
                                $word_output .= "<td></td>";
                            }
                            $ing = $rsing[$lt][2];
                            if (isset($ing)) {
                               $word_output .= "<td>$ing";
                               $pp = $rsing[$lt][3];
                                if ($pp) {
                                    $word_output .= ", $pp";
                                }
                                $pp = $rsing[$lt][4];
                                if ($pp) {
                                    $word_output .= ", $pp";
                                }
                                $word_output .= "</td>"; 
                            }  else {
                                $word_output .= "<td></td>";
                            }       
						    
						    $word_output .= "</tr>";
					    }
                        $word_output .= '</table>';
                    }
					$word_output .= "<hr>";
                    if (isset($note)) {
                        $note=nl2br(stripslashes($note));
                        $note=trim($note,"\n");
                        $word_output .= "<br><strong style='text-transform: uppercase;color: black;font-family: Tahoma,Geneva,sans-serif;font-size: 12px;'><u>Notes</u></strong><br><br>$note<br>";
                    }

                    if(isset($directions)) {
                        $directions=nl2br(stripslashes($directions));
                        $directions=trim($directions,"\n");
					    $word_output .= "<br><strong style='text-transform: uppercase;color: black;font-family: Tahoma,Geneva,sans-serif;font-size: 12px;'><u>Directions</u></strong><br><br>$directions<br>";
                    }
		
					if (isset($measure)) {
                        $word_output .= "<br><strong>Measurement System:</strong> $measure";
					}
                    if($tried) {
                        $tried='Yes';
                    } else {
                        $tried='No';
                    }
					$word_output .= "<br><strong>Tried:   </strong> $tried";
		
					if (isset($preptime)) {
                        $word_output .= "<br><strong>Preparation Time:</strong> $preptime";
					}
					if (isset($cooktime)) {
                        $word_output .= "<br><strong>Cooking Time:</strong> $cooktime";
					}
		
					if (isset($yield) && $yield!="") {
						      $word_output .= "<br><strong>Makes:</strong> $yield";
                              if(isset($yield_unit)) {
                                  $word_output .= " $yield_unit";
                              }
					}
		
					if (isset($cuisine)) {
                        $word_output .= "<br><strong>Cuisine:</strong> $cuisine";
					}
		
					if ($drows>0) {
					       $word_output .= "<br><strong>Diet:</strong>";
					       for ($lt = 0; $lt < $drows; $lt++) {
						      $diet = $rsdiet[$lt][0];
                              if ($lt > 0) {
							     $word_output .= ", $diet";
						      } else {
							     $word_output .= " $diet";
						      }
					       }
					}
		
					for ($lt = 0; $lt < $srows; $lt++) {
						      $cat = $rscat[$lt][0];
                              $subcat = $rscat[$lt][1];
                              if ($lt > 0) {
							     if ($subcat) {
								    $word_output .= ", $cat: $subcat";
							     } else {
								    $word_output .= ", $cat";
							     }
						      } else {
							     if ($subcat) {
                                     $word_output .= "<br><strong>Recipe Types & Categories:</strong>";
								     $word_output .= " $cat: $subcat";
							     } else {
                                     $word_output .= "<br><strong>Recipe Types:</strong>";
								     $word_output .= " $cat";
							     }
						      }
					}
					if (isset($source)) {
                        $word_output .= "<br><strong>Source:</strong> $source";
					}
                    if(isset($added)) {
                        if (isset($seldate)) {
                            if ($seldate==0) {
                                $added = date("d/m/Y", strtotime($added));
                            } else {
                                $added = date("m/d/Y", strtotime($added));
                            }
                        } else {
                            $added = date("m-d-Y", strtotime($added));
                        }
                        $word_output .= "<br><br><strong>Added:</strong> $added";
                    }
                    if(isset($addedby)) {
                        $word_output .= "<br><strong>Added by:</strong> $addedby";
                    }
                    if(isset($updated)) {
                        if (isset($seldate)) {
                            if ($seldate==0) {
                                $updated = date("d/m/Y", strtotime($updated));
                            } else {
                                $updated = date("m/d/Y", strtotime($updated));
                            }
                        } else {
                            $updated = date("m-d-Y", strtotime($updated));
                        }
                        $word_output .= "<br><strong>Last Modified:</strong> $updated";
                    }
					$extraimages=$imgrows-1;
					if ($extraimages>0) {
						$word_output .= "<br><br><table><tr>";
						for ($lt = 1; $lt < 4; $lt++) {
                             if (isset($imgarray[$lt])) {
							    $word_output .="<td><img src='".$wrmpath."images/recipe/$imgarray[$lt]'></td>";
                             }
						}
						$word_output .= "</tr></table>";
					}
					if ($extraimages>3) {
						$word_output .= "<br><br><table><tr>";
						for ($lt = 4; $lt < 7; $lt++) {
                            if (isset($imgarray[$lt])) {
							    $word_output .="<td><img src='".$wrmpath."images/recipe/$imgarray[$lt]'></td>";
                            }
						}
						$word_output .= "</tr></table>";
					}
					if ($extraimages>6) {
						$word_output .= "<br><br><table><tr>";
						for ($lt = 7; $lt < 10; $lt++) {
                            if (isset($imgarray[$lt])) {
							    $word_output .="<td><img src='".$wrmpath."images/recipe/$imgarray[$lt]'></td>";
                            }
						}
						$word_output .= "</tr></table>";
					}
                    $rt=0;
                    for ($lt = 0; $lt < $rrrows; $lt++) {
                           if ($id == $rsrel[$lt][0]) {
                              $relid = $rsrel[$lt][1];
                              $relname= $rsrel[$lt][3];
                           } 
                           if ($lt == 0) {
                               if ($rrrows>1) {
                                  $word_output .= "<hr><h3 style='font-size:18px;margin-top:10px;margin-bottom:10px;'>Related Recipes</h3>"; 
                               } else {
                                    $word_output .= "<hr><h3 style='font-size:18px;margin-top:10px;margin-bottom:10px;'>Related Recipe</h3>";
                               }
                           }
                           if ($relname) {
                              $word_output .= '<hr>';
                              $rt++;
                              require('includes/word_related.php');
                           }
                    }
					$word_output .= "</div>";
                    if($key<$reccount-1) {
                        $word_output .= "<br style='page-break-before: always;'>";
                    }
                    $word_xmlns = "xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'";
					$word_xml_settings = "<xml><w:WordDocument><w:View>Print</w:View><w:Zoom>100</w:Zoom></w:WordDocument></xml>";
					$content = '
					<html '.$word_xmlns.'>
					<head>'.$word_xml_settings.'<style type="text/css"> table,td {border:0px solid #FFFFFF;} </style>
					</head>
					<body>'.$word_output.'</body>
					</html>
					';

				} else if ($recipe_format == 'CSV(.csv)') {
                    if (strpos($name,',')>-1) {
					       $csv_output .= 'Name:,"'.$name.'"';
					} else {
					       $csv_output .= 'Name:,'.$name;
					}
					$csv_output .= "\n";
					if (isset($rating) && $rating>0) {
					       $csv_output .= 'Rating:,'.$rating;
					       $csv_output .= "\n";
					}
					if(isset($imgarray)) {
					       $csv_output .= 'Image:';
					       while (list ($key, $val) = each($imgarray)) {
						  $val = substr($val,strpos($val,"-")+1);
						  if (strpos($val,',')>-1) {
							 $csv_output .= ',"'.$val.'"';
						  } else {
							 $csv_output .= ','.$val;
						  }
					       }
					       $csv_output .= "\n";
					}
					if(isset($pdf)) {
					       if (strpos($pdf,',')>-1) {
						  $csv_output .= 'PDF:,"'.$pdf.'"';
					       } else {
						  $csv_output .= 'PDF:,'.$pdf;
					       }
					       $csv_output .= "\n";
					}
                    if(isset($video)) {
                           if (strpos($video,',')>-1) {
                          $csv_output .= 'video:,"'.$video.'"';
                           } else {
                          $csv_output .= 'video:,'.$video;
                           }
                           $csv_output .= "\n";
                    }
					if(isset($measure)) {
                        $csv_output .= 'Measure:,'.$measure;
					    $csv_output .= "\n";
					}
					if(isset($note)) {
                        $note = str_replace('\n','<br>',$note);
                        $note=stripslashes($note);
                        $note=trim($note,"<br>");                        
					    if (strpos($note,',')>-1) {
						  $csv_output .= 'Note:,"'.$note.'"';
					    } else {
						  $csv_output .= 'Note:,'.$note;
					    }
                        $csv_output .= "\n";
					}
					if($tried) {
					       $csv_output .= 'Tried:,'.$tried;
					       $csv_output .= "\n";
					}
					if(isset($preptime)) {
                        if (strpos($preptime,',')>-1) {
						    $csv_output .= 'Preptime:,"'.$preptime.'"';
					    } else {
						    $csv_output .= 'Preptime:,'.$preptime;
					    }
					    $csv_output .= "\n";
					}
					if(isset($cooktime)) {
                        if (strpos($cooktime,',')>-1) {
						  $csv_output .= 'Cooktime:,"'.$cooktime.'"';
					    } else {
						  $csv_output .= 'Cooktime:,'.$cooktime;
					    }
					    $csv_output .= "\n";
					}
					if(isset($yield) && $yield!='') {
					       $csv_output .= 'Yield:,'.$yield;
					       $csv_output .= "\n";
					}
					if(isset($yield_unit)) {
                        $csv_output .= 'Yield Unit:,'.$yield_unit;
					    $csv_output .= "\n";
					}
					if(isset($cuisine)) {
                        $csv_output .= 'Cuisine:,'.$cuisine;
					    $csv_output .= "\n";
					}
					if(isset($source)) {
                        if (strpos($source,',')>-1) {
						  $csv_output .= 'Source:,"'.$source.'"';
					    } else {
						  $csv_output .= 'Source:,'.$source;
					    }
					    $csv_output .= "\n";
					}
					if(isset($added)) {
					       $csv_output .= 'Added:,'.$added;
					       $csv_output .= "\n";
					}
					if(isset($addedby)) {
                        $csv_output .= 'Added By:,'.$addedby;
					    $csv_output .= "\n";
					}
					if(isset($updated)) {
					       $csv_output .= 'Last Modified:,'.$updated;
					       $csv_output .= "\n";
					}
					if (isset($directions)) {
                           $directions = str_replace(';',"",$directions);
					       $directions = str_replace(':',"",$directions);
                           $directions = str_replace('\n','<br>',$directions);
                           $directions=stripslashes($directions);
                           $directions=trim($directions,"<br>");
					       if (strpos($directions,',')>-1) {
						        $csv_output .= 'Directions:,"'.$directions.'"';
					       } else {
						        $csv_output .= 'Directions:,'.$directions;
					       }
					       $csv_output .= "\n";
					}
					if(isset($dietarray)) {
					       $csv_output .= 'Diet:';
					       while (list ($key, $val) = each ($dietarray)) {
                                if (strpos($val,',')>-1) {
							       $csv_output .= ',"'.$val.'"';
						        } else {
							       $csv_output .= ','.$val;
						        }
					       }
					       $csv_output .= "\n";
					}
					if(isset($commarray)) {
					       $csv_output .= 'Comments:';
					       while (list ($key, $val) = each ($commarray)) {
                              $val = $val.'|'.$commdatearray[$key].'|'.$commownerarray[$key];
						      $csv_output .= ',"'.$val.'"';
					       }
					       $csv_output .= "\n";
					}
					if(isset($relarray)) {
					       $csv_output .= 'Related Recipe:';
					       while (list ($key, $val) = each ($relarray)) {
                              if (strpos($val,',')>-1) {
							     $csv_output .= ',"'.$val.'"';
						      } else {
							     $csv_output .= ','.$val;
						      }
					       }
					       $csv_output .= "\n";
					}
					if(isset($catarray)) {
					    while (list ($key, $val) = each ($catarray)) {
						  $csv_output .= 'Category:';
						  foreach ($val as $ikey => $v2) {
                             if ($ikey == 0 and $v2) {
								if (strpos($v2,',')>-1) {
								       $csv_output .= ',"'.$v2.'"';
								} else {
								       $csv_output .= ','.$v2;
								}
							 }
							 if ($ikey == 1 and $v2) {
								if (strpos($v2,',')>-1) {
								       $csv_output .= ',"'.$v2.'"';
								} else {
								       $csv_output .= ','.$v2;
								}
							 }
						  }
						  $csv_output .= "\n";
					    }
					}
					$sql="$call query_recipe_ings_export(:id)";
                    $rsing = $rdb->prepare($sql);
                    $rsing->bindValue(':id', $id);
                    $rsing->execute();
                    $err=$rdb->errorInfo();

                    $ingarray= array();
                    while ($row = $rsing->fetch(PDO::FETCH_NUM)){
                        $ingarray[] = $row;
                    }
                    $rsing->closeCursor();
					if(isset($ingarray)) {
						 while (list ($key, $val) = each ($ingarray)) {
							 foreach ($val as $ikey => $v2) {
                                 if ($ikey==0) {
								     if (strpos($v2,',')>-1) {
									    $csv_output .= 'Ingredient:,"'.$v2.'"';
								     } else {
									    $csv_output .= 'Ingredient:,'.$v2;
								     }
								} else {
								     if (strpos($v2,',')>-1) {
									    $csv_output .= ',"'.$v2.'"';
								     } else {
									    $csv_output .= ','.$v2;
								     }
								}
							 }
							 $csv_output .= "\n";
						 }
					 }
					 $csv_output .= "Recipe End";
					 $csv_output .= "\n";
				} else if ($recipe_format == 'Meal Master(.mmf)') {
					$mmf_output .= '----- Meal-Master -----------------------';
					$mmf_output .= "\n\n";
                    $mmf_output .= 'Title: '.$name;
					$mmf_output .= "\n";
					if(isset($catarray)) {
						$mmf_output .= 'Categories: ';
						while (list ($key, $val) = each ($catarray)) {
							foreach ($val as $ikey => $v2) {
                                if ($ikey == 0 and $v2 and $key==0) {
								       $mmf_output .= $v2;
								} else if ($ikey == 0 and $v2) {
								       $mmf_output .= ','.$v2;
								}
								if ($ikey == 1 and $v2) {
								       $mmf_output .= ','.$v2;
								}
							}
						}
						$mmf_output .= "\n";
					}
					if(isset($yield) and isset($yield_unit)){
                        $mmf_output .= "Yield: ".$yield." ".$yield_unit;
					    $mmf_output .= "\n";
					} else if(isset($yield)) {
					    $mmf_output .= "Yield: ".$yield;
					    $mmf_output .= "\n";
					}
					if(isset($source)){
                        $mmf_output .= "Contributor: ".$source;
						$mmf_output .= "\n";
					}
					$mmf_output .= "\n";
					$sql="$call query_recipe_ings(:id)";
					$rsing = $rdb->prepare($sql);
                    $rsing->bindValue(':id', $id);
                    $rsing->execute();
                    $err=$rdb->errorInfo();

					$ingarray= array();
					while ($row = $rsing->fetch(PDO::FETCH_NUM)){
						$ingarray[] = $row;
					}
                    $rsing->closeCursor();
					if(isset($ingarray)) {
						while (list ($key, $val) = each ($ingarray)) {
							foreach ($val as $ikey => $v2) {
                                if ($ikey<5) {
									$ingpp='';
									unset($ingpp1);
									unset($ingpp2);
									if ($ikey==0) {
										$qtylen=strlen($v2);
										$qtyfiller=7-$qtylen;
										for ($lt = 0; $lt < $qtyfiller; $lt++) {
												$mmf_output .= " ";
										}
										$mmf_output .= $v2;
									} else if ($ikey==1) {
										$mmf_output .= " ";
										if (!$v2) {
											$mmf_output .= "  ";
										} else {
                                            $sql="SELECT unit, mmf from unit_base";
                                            $dbunit = $rdb->prepare($sql);
                                            $dbunit->execute();
                                            $err=$rdb->errorInfo();
                                            $unitarray = $dbunit->fetchAll(PDO::FETCH_BOTH);
                                            $dbunit->closeCursor();
                                            
                                            foreach ($unitarray as $unitval) {
                                                if ($v2==$unitval[0]) {
                                                       $v2=$unitval[1];
                                                       break;
                                                }
                                            }
										
										}
										if (strlen($v2)>2) {
												$v2=substr($v2,0,2);
										} 
                                        if(strlen($v2)==1) {
											$mmf_output .= $v2.'  ';
										} else {
											$mmf_output .= $v2.' ';
										}
									} else if ($ikey==2) {
										$ingpp=$v2;
									} else if ($ikey==3 and $v2) {
										$ingpp .= ";".$v2;
									} else if ($ikey==4 and $v2) {
										$ingpp .= ",".$v2;
									}
									if (isset($ingpp) && strlen($ingpp)>27) {
										$ingpp1 = substr($ingpp,0,27);
										$ingpp2 = "- ".substr($ingpp,27);
										$mmf_output .= " ".$ingpp1."\n"."           ".$ingpp2;
									} else if(isset($ingpp) && $v2){
										$mmf_output .= $ingpp;
									}
								}
							}
							$mmf_output .= "\n";
						}
					}
					$mmf_output .= "\n";
					if (isset($directions)) {
						//$directions = str_replace('"',"",$directions);
						$directions = str_replace(';',"",$directions);
					    $directions = str_replace(':',"",$directions);
                        $mmf_output .= $directions;
						$mmf_output .= "\n";
					}
					$mmf_output .= "-----";
					$mmf_output .= "\n";
				}
			}
			if ($recipe_format == 'CSV(.csv)') {
				// We'll be outputting an csv file
                header('Content-Encoding: UTF-8');
				header('Content-type: text/csv; charset=UTF-8');
    
				// It will be called exported-recipes.mmf
				header('Content-Disposition: attachment; filename="exported-recipes.csv"');
    
				echo utf8_decode($csv_output);
				exit();
			} elseif ($recipe_format == 'Meal Master(.mmf)') {
				// We'll be outputting an mmf file
				header('Content-type: text/mmf');

				// It will be called exported-recipes.mmf
				header('Content-Disposition: attachment; filename="exported-recipes.mmf"');

				echo utf8_decode($mmf_output);
				exit();
			} elseif ($recipe_format == 'MS Word(.doc)') {
				header('Content-Type: application/msword');
				header('Content-Length: '.strlen($content));
				header('Content-disposition: inline; filename="exported-recipes.doc"');
				echo utf8_decode($content);
				exit();
			}
		} else {
			$msg="No Recipes Selected";
		}
        $msg="Recipes Exported";
	} //end if export
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
        <!--<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic">-->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/slidebars.css" rel="stylesheet">
        <link href="css/slidebars-theme.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet" media="screen">
	    <script src="js/jquery-1.11.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slidebars.min.js"></script>
        <script src="js/jquery_cookie.js"></script>
	    <script src="js/my.messi.js"></script>
	    <script src="js/my.dropdown.js"></script>
	    <script src="js/my.scrolling.msgbox.js"></script>
	    <script src="js/my.font.size.js"></script>
        <meta content="summary" name="twitter:card">
        <meta content="yes" name="apple-mobile-web-app-capable">
        <meta content="black" name="apple-mobile-web-app-status-bar-style">
        <link href="images/16.png" type="image/png" rel="icon">
        <link sizes="32x32" href="images/32.png" type="image/png" rel="icon">
        <link sizes="48x48" href="images/48.png" type="image/png" rel="icon">
        <link sizes="64x64" href="images/64.png" type="image/png" rel="icon">
        <link sizes="120x120" href="images/152.png" rel="apple-touch-icon">
        <link sizes="152x152" href="images/120.png" rel="apple-touch-icon">
        <link sizes="76x76" href="images/76.png" rel="apple-touch-icon">
        <link sizes="114x114" href="images/114.png" rel="apple-touch-icon">
        <link sizes="57x57" href="images/57.png" rel="apple-touch-icon">
        <link sizes="144x144" href="images/144.png" rel="apple-touch-icon">
        <link sizes="72x72" href="images/72.png" rel="apple-touch-icon">
        <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" href="images/1096.png">
        <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" href="images/920.png">
        <link rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" href="images/460.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" href="images/2008.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" href="images/1496.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)" href="images/1004.png">
        <link rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)" href="images/748.png">
	    <title>Export Recipes</title>
	    <meta name="description" content="Export or backup recipes in csv, Meal Master or Word format">
	    <script src="js/my.export.js"></script>
	    <script src="js/jquery.selectboxes.pack.js"></script>
        <script src="js/my.back.from.info.js "></script>
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
		if ($client=='wrm' && isset($admin)) {
			$sql = "$call query_owner_recipes_with_name_id(:oid)";  //return all recipes from db
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':oid', $oid);
		} else if (isset($admin)) {
			$sql = "$call query_recipes_with_name_id()";
            $dbrecipe = $rdb->prepare($sql);
		} else {
            $sql = "$call query_user_recipes_with_name_id(:uid)";
            $dbrecipe = $rdb->prepare($sql);
            $dbrecipe->bindValue(':uid', $uid);
        }
        $dbrecipe->execute();
        $err=$rdb->errorInfo();

        $numr = $dbrecipe->rowCount();
        $rsrecipe = $dbrecipe->fetchAll(PDO::FETCH_BOTH);
        $dbrecipe->closeCursor();
  
		require_once('includes/banner.php');
		
        if (isset($status)) {
			if ($status=='suspended') {
				echo "<script type='text/javascript'>
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$susmsg');
                    $('.message_box').show();
                </script>";
			}
		}
		if (isset($msg)) {
            if($msg=="Recipes Exported") {
                 echo "<script type='text/javascript'>
                    $('.message_box').addClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                    $('.message_box').show();
                </script>";
            } else {
			    echo "<script type='text/javascript'>
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$msg');
                    $('.message_box').show();
                </script>";
            }
		}
        if(isset($_GET['indv'])) {
		    $id=$_COOKIE['rid'];
        }						
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				<h3><strong>export </strong>recipes</h3>
				<br>
				<form action="" name=form1 enctype="multipart/form-data" method="POST">
					<input type=submit class=btn name="export" value="Export" class=button><br><br>
					<strong><span id=msg></span></strong>
					<br><br>
					<div>
						<div class=dib>
							<strong>Format:</strong></td>
						</div>
						<div class=dib>
							<?php if (isset($_POST['format'])) {$selvalue=$_POST['format'];} //if item already selected trap value ?>
							<select class=form-control name="format">
								<option>CSV(.csv)</option>
								<option>Meal Master(.mmf)</option>
								<option>MS Word(.doc)</option>
							</select>	
						</div>        			
					</div>
                    <strong>If you are exporting in Mealmaster format, the abbreviations used can be seen </strong><a href=mm-abbrev.php>here</a>
					<br>
                    <br>
					<div>
						<div class=dib>
							<strong class=rheader>Recipes</strong>
							<br><br>
							<select class=form-control id=erecipelist name=recipe[] size=<?php echo $numr;?> multiple>
							<?PHP
								for ($lt = 0; $lt < $numr; $lt++) {
									$recipeid = $rsrecipe[$lt][0];
									$recipeval = str_replace('"',"'",$rsrecipe[$lt][1]);
									if ((isset($id) && $recipeid != $id) || !isset($id)) {
										print("<option VALUE=$recipeid>$recipeval</option>");
									}
								}
							?>
							</select>
						</div>
						<div id=centre class=dib>
							<div class=mdib><input id="add" type="button" class=btn value=">"></div>
							<div class=mdib><input id="addAll" type="button" class=btn value=">>"></div>
							<div class=mdib><input id="remove" type="button" class=btn value="<"></div>
							<div class=mdib><input id="removeAll"type="button" class=btn value="<<"></div>
						</div>
						<div class=dib>
							<strong class=rheader>Recipes To Export</strong>
							<br><br>
							<select class=form-control id=erelated_recipe name=related_recipe[] size=<?php echo $numr;?> multiple>
								<?PHP
									for ($lt = 0; $lt < $numr; $lt++) {
										$recipeid = $rsrecipe[$lt][0];
										$recipeval = str_replace('"',"'",$rsrecipe[$lt][1]);
										if (isset($id) && $recipeid == $id) {
											print("<option VALUE=$recipeid selected>$recipeval</option>");
										}
									}
								?> 
							</select>
						</div>
					</div>
					<br><br>
					<input type=submit class=btn name="export" value="Export" class=button>
				</form>
			</div>
                <?php
                        require_once('includes/bottom.php');
                ?>
                