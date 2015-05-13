<?php

    require_once('rdb.php');

    function extract_numbers($string){
        preg_match_all('/([\d]+)/', $string, $match);
        return $match[0];
    }
if (!empty($_FILES)) {
   ini_set('max_execution_time', 600);
   if (isset($_SESSION[$client.'admin'])) {
        $admin=$_SESSION[$client.'admin'];
   }
   if (isset($_SESSION[$client.'rapp'])) {
        $rapp=$_SESSION[$client.'rapp'];
   }
   if (isset($admin) || !isset($rapp)) {
        $approve='yes';
   }

   $file = $_FILES['file']['tmp_name'];
   $recipe_format = strtolower(strrchr($_FILES['file']['name'],'.'));
   $imported=0;
   // determine import format
   if ($recipe_format == '.csv') {
		$handle = fopen($file, 'r');
		while (!feof($handle)) {
			$data = utf8_encode(fgets($handle));
			if (current(explode(",",$data))=="Name:") { //This is the start of a new recipe
				unset($ingarray);
				unset($directions);
				unset($source);
				unset($cuisine);
				unset($yield);
				unset($yield_unit);
				unset($catarray);
				unset($unitid);
				unset($dietarray);
				unset($imgarray);
				unset($comarray);
				unset($preptime);
				unset($cooktime);
				unset($ct);
				unset($note);
				unset($added);
				unset($addedby);
				unset($updated);
				unset($pdf);
                unset($video);
                unset($err);
				$relarray=NULL;
                $invyield=0;
                
				$pos=strlen("Name:,");
				$name = trim(substr($data,$pos));
				//$name = str_replace("'","''",$name);
                $name = rtrim($name, ',');
                
				$sql="$call query_user_recipes_with_name(:name,:uid)";
				$dbr = $rdb->prepare($sql);
                $dbr->bindValue(':name', $name);;
                $dbr->bindValue(':uid', $uid);
                $dbr->execute();
                $err=$rdb->errorInfo();
                $irows = $dbr->rowCount();
                $db = $dbr->fetchAll(PDO::FETCH_BOTH);
                $dbr->closeCursor();
                
				if ($irows>0 and (isset($_POST['overwrite']) && $_POST['overwrite']=='yes')) {
					foreach($db as $row) {
						$oldid = $row[0];
						require('delrecipe.php');
					}
				}
				$sql = "$call query_add_recipe(:uid, :name)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':uid', $uid);
                $db->bindValue(':name', $name);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();

				$imported++;
				$sql="$call query_new_recipe_id(:name,:uid)";
                $dbi = $rdb->prepare($sql);
                $dbi->bindValue(':name', $name);
                $dbi->bindValue(':uid', $uid);
                $dbi->execute();
                $err=$rdb->errorInfo();
                $db = $dbi->fetch(PDO::FETCH_BOTH);
                $dbi->closeCursor();
                
                $id = $db[0];
                
				if ($approve=='yes') {
					$sql="$call query_approve(:id)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
				}
			} else if (current(explode(",",$data))=="Rating:") {
				$pos=strlen("Rating:,");
				$rating = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
                
				$sql = "$call query_add_rating_to_recipe(:current_rating, :total_ratings, :id)";
                $rsaddrt = $rdb->prepare($sql);
                $rsaddrt->bindValue(':current_rating', $rating);
                $rsaddrt->bindValue(':total_ratings', 1);
                $rsaddrt->bindValue(':id', $id);
                $rsaddrt->execute();
                $err=$rdb->errorInfo();
                $rsaddrt->closeCursor();
                
                $sql = "$call query_add_rating(:id,:rating,:uid)";
                $rsr = $rdb->prepare($sql);
                $rsr->bindValue(':id', $id);
                $rsr->bindValue(':rating', $rating);
                $rsr->bindValue(':uid', $uid);
                $rsr->execute();
                $err=$rdb->errorInfo();
                $rsr->closeCursor();
                
			} else if (current(explode(",",$data))=="Image:") {
				$pos=strlen("Image:,");
				$imgarray = explode(",",trim(substr($data,$pos)));
				while (list ($key, $val) = each ($imgarray)) {
					$image = $val;
					$sourcedir = "../imagetmp/$image";
					if (file_exists($sourcedir)) {
						if (substr($image,0,strlen($user))!=$user) {
							$image= $user."-".$image;
						}
						$target = "../images/recipe/$image";
                        list($width,$height) = getimagesize($sourcedir);
                        if ($width > 250) {$width = 250;}
                        if ($height > 250) {$height = 250;}
                        require('thumbnail_create.php');
                        $a = new Thumbnail($sourcedir,$width,$height,$target,80,'"bevel(0)"');
						
						$sql = "$call query_image_exists(:image)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':image', $image);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $ichkrows=$db->rowCount();
                        $db->closeCursor();
                        
                        if ($ichkrows==0) {
                            $sql = "$call query_add_image(:image)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':image', $image);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
                        $sql = "$call query_add_image_to_recipe(:image,:id)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':image', $image);
                        $db->bindValue(':id', $id);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
					}
				}
			} else if (current(explode(",",$data))=="Comments:") {
				$pos=strlen("Comments:,");
				$commarray = explode('","',trim(str_replace('"',"",substr($data,$pos))));
				while (list ($key, $val) = each ($commarray)) {
					$commentstuff=explode("|",$val);
					$comment = $commentstuff[0];
					//$comment = str_replace("'","''",$comment);
					$commdate = $commentstuff[1];
					$commentowner = $commentstuff[2];
                    
					$sql = "$call query_owner_ids(:commentowner)";
                    $dbid = $rdb->prepare($sql);
                    $dbid->bindValue(':commentowner', $commentowner);
                    $dbid->execute();
                    $err=$rdb->errorInfo();
                    $orows = $dbid->rowCount();
                    $db = $dbid->fetch(PDO::FETCH_BOTH);
                    $dbid->closeCursor();
                    
                    if ($approve=='yes') {
                        if ($orows>0) {
                            $commentoid=$db[0];
                            $sql = "$call query_add_admin_recipe_comments(:id, :commentoid, :comment, :commdate)";
                            $sendcomment = $rdb->prepare($sql);
                            $sendcomment->bindValue(':id', $id);
                            $sendcomment->bindValue(':commentoid', $commentoid);
                            $sendcomment->bindValue(':comment', $comment);
                            $sendcomment->bindValue(':commdate', $commdate);
                        } else {
                            $sql = "$call query_add_admin_recipe_comments(:id, null, :comment, :commdate)";
                            $sendcomment = $rdb->prepare($sql);
                            $sendcomment->bindValue(':id', $id);
                            $sendcomment->bindValue(':comment', $comment);
                            $sendcomment->bindValue(':commdate', $commdate);
                        }
                    } else {
                        if ($orows>0) {
                            $commentoid=$db[0];
                            $sql = "$call query_add_recipe_comments(:id, :commentoid, :comment, :commdate)";
                            $sendcomment = $rdb->prepare($sql);
                            $sendcomment->bindValue(':id', $id);
                            $sendcomment->bindValue(':commentoid', $commentoid);
                            $sendcomment->bindValue(':comment', $comment);
                            $sendcomment->bindValue(':commdate', $commdate);
                        } else {
                            $sql = "$call query_add_recipe_comments(:id, null, :comment, :commdate)";
                            $sendcomment = $rdb->prepare($sql);
                            $sendcomment->bindValue(':id', $id);
                            $sendcomment->bindValue(':comment', $comment);
                            $sendcomment->bindValue(':commdate', $commdate);
                        }
                    }
					$sendcomment->execute();
                    $err=$rdb->errorInfo();
                    $sendcomment->closeCursor();
				}
			} else if (current(explode(",",$data))=="PDF:") {
				$pos=strlen("PDF:,");
				$pdf = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
                if (file_exists("../imagetmp/$pdf")) {
                    $sourcedir = "../imagetmp/$pdf";
                } else {
                    $pdf = str_replace('_',' ',$pdf);
                }
				if (file_exists($sourcedir)) {
                    $targetdir = "../imagetmp/".str_replace(' ','_',$pdf);
					$withoutext = preg_replace("/\\.[^.\\s]{3,4}$/", "", str_replace(' ','_',$pdf));
                    $newjpg = '../imagetmp/'.$withoutext.'-%d.jpg';
                    $convert = $impath."convert $targetdir -quality 100% $newjpg";

                    exec($convert);

                    $imgs='';
                    $files = glob("../imagetmp/$withoutext*.jpg");
                    foreach ($files as &$value) {
                            $imgs .= ' '.$value;
                    }
                    $imgs=trim($imgs);
                    $newjpg = '../imagetmp/'.$withoutext.'.jpg';
                    $combine = $impath."convert $imgs -append  $newjpg";

                    exec($combine);
                    
                    $pdfjpg = $withoutext.'.jpg';

                    if (substr($pdf,0,strlen($user))!=$user) {
                        $newpdf=$user."-".$pdf;
                        $newpdfjpg = $user."-".$pdfjpg;
                    } else {
                        $newpdf=$pdf;
                        $newpdfjpg = $pdfjpg;
                    }
                    if (!file_exists("../images/recipe/".$newpdf)) {
                        $sourcedir = "../imagetmp/".$pdf;
                        $targetdir = "../images/recipe/".$newpdf;
                        rename($sourcedir, $targetdir);
                        chmod($targetdir, 0604);
                        //upload all related jpgs (pdf may have been multipage)
                        //first the combined jpg for addform page
                        if (file_exists('../imagetmp/'.$pdfjpg)) {
                            $sourcedir = '../imagetmp/'.$pdfjpg;
                            $targetdir = "../images/recipe/".$newpdfjpg;
                            rename($sourcedir, $targetdir);
                            chmod($targetdir, 0604);
                        }
                    }
                    $sql = "$call query_add_pdf_to_recipe(:newpdf,:id)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':newpdf', $newpdf);
                    $db->bindValue(':id', $id);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
				}
			} else if (current(explode(",",$data))=="video:") {
                $pos=strlen("video:,");
                $video = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
                if (file_exists("../imagetmp/$video")) {
                    $sourcedir = "../imagetmp/$video";
                } else {
                    $video = str_replace('_',' ',$video);
                } 
                if (file_exists($sourcedir)) {
                    $video=str_replace(' ','_',$video);
                    if (substr($video,0,strlen($user))!=$user) {
                        $newvideo=$user."-".$video;
                    } else {
                        $newvideo=$video;
                    }
                    if (!file_exists("../images/recipe/".$newvideo)) {
                        $sourcedir = "../imagetmp/".$video;
                        $targetdir = "../images/recipe/".$newvideo;
                        rename($sourcedir, $targetdir);
                        chmod($targetdir, 0604);
                    }
                    $sql = "$call query_add_video_to_recipe(:newvideo,:id)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':newvideo', $newvideo);
                    $db->bindValue(':id', $id);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
                }
            } else if (current(explode(",",$data))=="Measure:") {
				$pos=strlen("Measure:,");
				$val= trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
                $var='measure';
				require('updateselecttables.php');
				$sql = "$call query_add_".$var."_to_recipe(:rid,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':rid', $rid);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Note:") {
				$notefound=1;
                $pos=strlen("Note:,");
                $note = str_replace('"',"",substr($data,$pos));
			} else if (current(explode(",",$data))=="Tried:") {
				$pos=strlen("Tried:,");
				$tried = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
				$sql = "$call query_add_tried_to_recipe(:tried,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':tried', $tried);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Preptime:") {
				$pos=strlen("Preptime:,");
				$preptime = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
				$sql = "$call query_add_preptime_to_recipe(:preptime,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':preptime', $preptime);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			}  else if (current(explode(",",$data))=="Cooktime:") {
				$pos=strlen("cooktime:,");
				$cooktime = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
				$sql = "$call query_add_cooktime_to_recipe(:cooktime,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':cooktime', $cooktime);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Yield:") {
				$pos=strlen("Yield:,");
				$yield = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
				if (!is_numeric($yield)) {
						$invyield++;
						unset($yield);
						if ($invyield==1) {
							$msg3 = "The Following Recipes Have Invalid Yields:<br><br>";
						}
						$msg3 .= "<span style='color:#000000;font-size:12px;text-align:left;' >".$name."</span><br>";
				} else {
					$sql = "$call query_add_yield_to_recipe(:yield,:id)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
                    $db->bindValue(':yield', $yield);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
				}
			} else if (current(explode(",",$data))=="Yield Unit:") {
				$pos=strlen("Yield Unit:,");
				$val = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
                $var='yield_unit';
				require('updateselecttables.php');
                $sql = "$call query_add_".$var."_to_recipe(:rid,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':rid', $rid);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Cuisine:") {
				$pos=strlen("Cuisine:,");
				$val = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
                $var = 'cuisine';
				require('updateselecttables.php');
                $sql = "$call query_add_".$var."_to_recipe(:rid,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':rid', $rid);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Source:") {
				$pos=strlen("Source:,");
				$val = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
                $var = 'source';
				require('updateselecttables.php');
                $sql = "$call query_add_".$var."_to_recipe(:rid,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':rid', $rid);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Added By:") {
				$pos=strlen("Added By:,");
				$addedby = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
				$sql = "$call query_add_addedby_to_recipe(:addedby,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':addedby', $addedby);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Added:") {
				$pos=strlen("Added:,");
				$added = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
				$sql = "$call query_add_added_to_recipe(:added,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':added', $added);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Last Modified:") {
				$pos=strlen("Last Modified:,");
				$updated = trim(str_replace('"',"",current(explode(",",substr($data,$pos)))));
				$sql = "$call query_add_updated_to_recipe(:updated,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':updated', $updated);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			} else if (current(explode(",",$data))=="Directions:") {
                $dirfound=1;
                unset($notefound);
				$pos=strlen("Directions:,");
				$directions  = str_replace('"',"",substr($data,$pos));
			} else if (current(explode(",",$data))=="Diet:") {
				$pos=strlen("Diet:,");
				$dietarray = explode(",",trim(str_replace('"',"",substr($data,$pos))));
				$var="diet";
                while (list ($key, $val) = each ($dietarray)) {
                    require('updateselecttables.php');
                    $sql="$call query_add_recipe_diet(:id,:rid)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
                    $db->bindValue(':rid', $rid);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
                }
			} else if (current(explode(",",$data))=="Related Recipe:") {
				$pos=strlen("Related Recipe:,");
				$relarray = explode(",",trim(str_replace('"',"",substr($data,$pos))));
				while (list ($key, $val) = each ($relarray)) {
					$sql = "$call query_new_recipe_id(:val, :uid)";
                    $dbrr = $rdb->prepare($sql);
                    $dbrr->bindValue(':val', $val);
                    $dbrr->bindValue(':uid', $uid);
                    $dbrr->execute();
                    $err=$rdb->errorInfo();
                    $relrows = $dbrr->rowCount();
                    $db = $dbrr->fetch(PDO::FETCH_BOTH);
                    $dbrr->closeCursor();
                    
					if ($relrows>0) {
						$relid = $db[0];
                        if(isset($relid)) {
						    $sql="$call query_add_related_recipe(:id, :relid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':relid', $relid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
					}
				}
			} else if (current(explode(",",$data))=="Category:") {
				$pos=strlen("Category:,");
				$catarray = explode(",",trim(str_replace('"',"",substr($data,$pos))));
				while (list ($key, $val) = each ($catarray)) {
					if ($key==0 and $val) {
						$var="category";
                        require('updateselecttables.php');
                        $catid=$rid;
					}
					if ($key==1 and $val) {
						$var="subcategory";
                        require('updateselecttables.php');
                        $subcatid = $rid;
					}

				}
				if (isset($subcatid)) {
					$sql="$call query_add_recipe_cat_subcat(:id, :catid, :subcatid)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
                    $db->bindValue(':catid', $catid);
                    $db->bindValue(':subcatid', $subcatid);
				} else if (isset($catid)) {
					$sql="$call query_add_recipe_cat(:id , :catid)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
                    $db->bindValue(':catid', $catid);
				}
				$db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
				unset($catid);
				unset($subcatid);
			} else if (current(explode(",",$data))=="Ingredient:") {
				$data=str_replace('<','lt',$data);
				//$data=str_replace("'","''",$data);
                $data = str_replace('Â¼','1/4',$data);
                $data = str_replace('Â½','1/2',$data);
                $data = str_replace('Â¾','3/4',$data);
				$data = str_replace('¼','1/4',$data);
				$data = str_replace('½','1/2',$data);
				$data = str_replace('¾','3/4',$data);
				$pos=strlen("Ingredient:,");
				$ingarray = explode(",",trim(str_replace('"',"",substr($data,$pos))));
				unset($hasqty); unset($hasunit); unset($hasqty2); unset($hasunit2); unset($hasing); unset($haspp1); unset($haspp2);
				while (list ($key, $val) = each ($ingarray)) {

					if ($key==0 and $val) {
						$qty = $val;
						if (!preg_match('#[0-9]#',$qty)){
							$invqty++;
							unset($qty);
							if ($invqty==1) {
								$msg2 = "The Following Recipes Have Invalid Quantities:<br><br>";
							}
							$msg2 .= "<span style='color:#000000;font-size:12px;text-align:left;' >".$name."</span><br>";
						} else {
							$hasqty=1;
							if (strpos($qty,'-')>-1) { //we have a range
								$qty=(substr($qty,0,strpos($qty,'-')));
							}
							if (strchr($qty,'/')>-1) { //we have a fraction or mixed number
								$match = extract_numbers($qty);
								if (count($match)==2) { //we have a fraction
								$qtydec=$match[0]/$qtydec=$match[1];
								} else if (count($match)>2) { //the qty is a mixed number
								$qtydec=$match[0] + ($match[1] / $match[2]);
								}
							} else {
								$qtydec=$qty;
							}
						}
					}
					if ($key==1 and $val) {
						$hasunit=1;
						$var="unit";
                        require('updateselecttables.php');
                        $unitid = $rid;
					}
					if ($key==2 and $val) {
						$qty2 = $val;
						$hasqty2=1;
						if (strpos($qty2,'-')>-1) { //we have a range
							$qty2=(substr($qty,0,strpos($qty2,'-')));
						}
					}
					if ($key==3 and $val) {
						$hasunit2=1;
						$var="unit";
                        require('updateselecttables.php');
                        $unit2id = $rid;
					}
					if ($key==4 and $val) {
						$hasing=1;
						$val=str_replace('"','inch',$val);
						$val = str_replace('<','less than ',$val);
						$val = str_replace('&','and',$val);
						$var="ingredient";
                        require('updateselecttables.php');
                        $ingid = $rid;
					}
					if ($key==5 and $val) {
						$haspp1=1;
						$val=str_replace('"','inch',$val);
						$val = str_replace('<','less than ',$val);
						$val = str_replace('&','and',$val);
						$var="preprep";
                        require('updateselecttables.php');
                        $pp1id = $rid;
					}
					if ($key==6 and $val) {
						$haspp2=1;
						$val=str_replace('"','inch',$val);
						$val = str_replace('<','less than ',$val);
						$val = str_replace('&','and',$val);
						$var="preprep";
                        require('updateselecttables.php');
                        $pp2id = $rid;
					}

				}
                if (isset($hasing)) {
                        $sql = "$call query_add_recipe_ing(:id, :ingid)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':ingid', $ingid);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
                        //find id of recipe_ing added to cater for duplicated ingredients in recipe
                        $sql = "$call query_latest_recipe_ing(:id, :ingid)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':ingid', $ingid);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $dbi = $db->fetch(PDO::FETCH_BOTH);
                        $db->closeCursor();
                        $riid = $dbi[0];

                        if (isset($hasqty)) {
                            $sql = "$call query_add_quantity_to_ing(:qty, :id, :ingid, :riid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':qty', $qty);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':ingid', $ingid);
                            $db->bindValue(':riid', $riid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                            
                            $sql = "$call query_add_qtydec_to_ing(:qtydec, :id, :ingid, :riid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':qtydec', $qtydec);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':ingid', $ingid);
                            $db->bindValue(':riid', $riid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
                        if (isset($hasunit)) {
                            $sql = "$call query_add_unit_to_ing(:unitid, :id, :ingid, :riid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':unitid', $unitid);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':ingid', $ingid);
                            $db->bindValue(':riid', $riid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
						if (isset($hasqty2)) {
                            $sql = "$call query_add_quantity2_to_ing(:qty2, :id, :ingid, :riid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':qty2', $qty2);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':ingid', $ingid);
                            $db->bindValue(':riid', $riid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
                        if (isset($hasunit2)) {
                            $sql = "$call query_add_unit2_to_ing(:unit2id, :id, :ingid, :riid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':unit2id', $unit2id);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':ingid', $ingid);
                            $db->bindValue(':riid', $riid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
                        if (isset($haspp1)) {
                            $sql = "$call query_add_preprep1_to_ing(:pp1id, :id, :ingid, :riid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':pp1id', $pp1id);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':ingid', $ingid);
                            $db->bindValue(':riid', $riid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
                        if (isset($haspp2)) {
                            $sql = "$call query_add_preprep2_to_ing(:pp2id, :id, :ingid, :riid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':pp2id', $pp2id);
                            $db->bindValue(':id', $id);
                            $db->bindValue(':ingid', $ingid);
                            $db->bindValue(':riid', $riid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
                        }
                }
			} else {
				if (current(explode(",",$data))=="Recipe End") {
                    unset($dirfound);
					if (!isset($catarray))  {
						$sql="$call query_add_recipe_cat(:id , 20)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
					}
					if (!isset($addedby)) {
						$addedby=$user;
                        $sql = "$call query_add_addedby_to_recipe(:addedby,:id)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':addedby', $addedby);
                        $db->bindValue(':id', $id);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
					}
                    if (isset($note)) {
                        //$note = str_replace("'","''",$note);
                        $note = rtrim($note);
                        $note = rtrim($note,',');
                        $sql = "$call query_add_note_to_recipe(:note,:id)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':note', $note);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
                    }
                    if (isset($directions)) { 
                        $directions = rtrim($directions);
                        $directions = rtrim($directions,',');
                        $sql = "$call query_add_directions_to_recipe(:directions,:id)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':directions', $directions);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
                    }
				} else if (isset($notefound)) {
                    $note .= str_replace('"',"",$data);
                    
                } else if(isset($dirfound)) {
                    $directions .= str_replace('"',"",$data);
                }
			}
		}
		fclose($handle);
		//clear temporary image files folder
		function SureRemoveDir($dir) {
			if(!$dh = @opendir($dir)) return;
			while (false !== ($obj = readdir($dh))) {
				if($obj=='.' || $obj=='..') continue;
				if (!@unlink($dir.'/'.$obj) and is_file($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
			}
		}
		$tempdir= "../imagetmp";
		SureRemoveDir($tempdir);
		if (!isset($added)) {
			$added = date('c');
			$sql = "$call query_add_added_to_recipe(:added,:id)";
            $db = $rdb->prepare($sql);
            $db->bindValue(':id', $id);
            $db->bindValue(':added', $added);
            $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();
		}

	} else if ($recipe_format == '.mmf') {
        $invyield=0;
		$handle = fopen($file, 'r');
		while (!feof($handle)) {
			$data = utf8_encode(fgets($handle));
			//$data = str_replace("'","''",$data);
            if (strpos($data,'¼')>-1) {
                $data = str_replace('Â¼','1/4 ',$data);
                $data = str_replace('¼','1/4 ',$data);
                $data = substr($data,2);
            }
            if (strpos($data,'½')>-1) {
                $data = str_replace('Â½','1/2',$data);
                $data = str_replace('½','1/2 ',$data);;
                $data = substr($data,2);
            }
            if (strpos($data,'¾')>-1) {
                $data = str_replace('Â¾','3/4',$data);
                $data = str_replace('¾','3/4 ',$data);;
                $data = substr($data,2);
            }
            $data = preg_replace("/(\r\n|\r|\n)/", " ", $data); // Strip line breaks
            $checking=substr($data,0,7);
            $number = preg_replace("/[^0-9]/", '', $checking); // ditch anything that is not a number)
            if ($checking==' ' || $number!="") {
                $ingprob=1;
            } else {
                $ingprob=0;
            }
            if (substr($data,0,6)=='MMMMM-' || (substr($data,0,5)=='-----' and strpos($data, "Meal-Master")>0)) {
				unset($ingarray);
				$directions="";
				unset($source);
				unset($yield);
				unset($yield_unit);
				unset($catarray);
				unset($newcatarray);
				unset($preptime);
			} else if (preg_match('/^ *Title: .+/', $data)) {
				$hastitle=TRUE;
				$pos = strpos($data, "Title: ") + strlen("Title: ");
				$name = trim(substr($data, $pos));
				$sql = "$call query_owner_recipes_with_name(:name,:uid)";
                $rcr = $rdb->prepare($sql);
                $rcr->bindValue(':name', $name);
                $rcr->bindValue(':uid', $uid);
                $rcr->execute();
                $err=$rdb->errorInfo();
                $numrc = $rcr->rowCount();
                $rc = $rcr->fetchAll(PDO::FETCH_BOTH);
                $rcr->closeCursor();
				
				if ($numrc>0 and (isset($_POST['overwrite']) && $_POST['overwrite']=='yes')) {
					for ($lt = 0; $lt < $numrc; $lt++) {
						$oldid = $rc[$lt][0];
						require('delrecipe.php');
					}
				}
			} else if ((strpos($data, "Yield")>-1 || strpos($data, "Servings")>-1)) {
				$hasyield=TRUE;
				if (strpos($data, "Yield")>-1) {
					 $pos = strpos($data, "Yield: ") + strlen("Yield: ");
				} else {
					 $pos = strpos($data, "Servings: ") + strlen("Servings: ");
				}
				$yield = current(explode(" ",htmlspecialchars(trim(substr($data, $pos)), ENT_QUOTES)));
				if (strpos($yield,"-")>0) {
					$yield = current(explode("-",$yield));
				}
				if (str_word_count($data)>1) {
                    $yield_unit=htmlspecialchars(trim(substr($data, $pos)), ENT_QUOTES);
                    $yield_unitsplit=explode(" ",$yield_unit);
					$yield_unit = end($yield_unitsplit);
				} else {
					unset($yield_unit);
				}
				if ((isset($yield ) && $yield!="") && !is_numeric($yield)){
					$yield = end(explode(" ",htmlspecialchars(trim(substr($data, $pos)), ENT_QUOTES)));
					$yield_unit = current(explode(" ",htmlspecialchars(trim(substr($data, $pos)), ENT_QUOTES)));
					if (!is_numeric($yield)) {
						$invyield++;
						unset($yield);
						unset($yield_unit);
						if ($invyield==1) {
							$msg2 = "The Following Recipes Have Invalid Yields:<br><br>";
						}
						$msg2 .= "<span style='color:#000000;font-size:12px;text-align:left;' >".$name."</span><br>";
					}
				}
			} else if (preg_match('/^ *Categories: .+/', $data)) {
				$hascats=true;
				$pos = strpos($data, "Categories: ") + strlen("Categories: ");
				$catarray = explode(",",htmlspecialchars(trim(substr($data, $pos)), ENT_QUOTES));
			} else if (preg_match('/^ *Contributor: .+/', $data)) {
				$pos = strpos($data, "Contributor: ") + strlen("Contributor: ");
				$source = htmlspecialchars(trim(substr($data, $pos)), ENT_QUOTES);
			} else if (preg_match('/^ *Preparation Time: .+/', $data)) {
				$pos = strpos($data, "Preparation Time: ") + strlen("Preparation Time: ");
				$preptime = htmlspecialchars(trim(substr($data, $pos)), ENT_QUOTES);
			} else if ($ingprob==1 and isset($hastitle) and isset($hascats) and !isset($hasing) and !isset($hasdir)) {
				 //we're about to find the ingredients
				$hasing=TRUE;
				$pict=-1;
				$ict=0;
			} else if (isset($hasing) and $data != " ") {
				$data=str_replace('<','lt',$data);
				$data=str_replace('"','inch',$data);
				$data = str_replace('&','and',$data);
				if (substr($data,0,1)==' ') {
					if (preg_match('/^ *NYC .+/', $data)) {
					//Ignore nutrient info
					} else {
						if (substr($data,0,1)==' ') {
							unset($pparray);
							unset($newpparray);

							if (substr(trim($data),-1)==";") {
								$semicolonatend=1;
							} else if (substr(trim($data),0,1)!="-") {
								$semicolonatend=0;
							}
							$ingdata = current(explode(";",$data));

							$ingarray[$ict][0]=trim(substr($ingdata,0,7));
							$ingarray[$ict][1]=trim(substr($ingdata,8,2));
							$ingarray[$ict][2]=trim(substr($ingdata,11));

							if (substr_count($data, ";") > 0) { //if there are any preperation steps
								if (substr($ingarray[$ict][2],0,1)!='-' and substr(trim($data),-1)==',') {
									$ppend=1;
								} else if (!substr($ingarray[$ict][2],0,1)!='-') {
									$ppend=0;
								}
                                $ingsplit=explode(";",$data);
                                $ppsection=end($ingsplit);
								$pparray= explode(",",$ppsection);
								$ingarray[$ict][3]=htmlspecialchars(trim($pparray[0]), ENT_QUOTES);
                                if(isset($pparray[1])) {
								    $ingarray[$ict][4]=htmlspecialchars(trim($pparray[1]), ENT_QUOTES);
                                }
							}
							if (substr($ingarray[$ict][2],0,1)=='-') { //this is a carry over line so we need to add it to the prev one
								$ingarray[$ict][2] = preg_replace( '/^-*/', "", $ingarray[$ict][2]); //remove leading dash
								$nocommas=str_replace(","," ",$ingarray[$ict][2]);
								if (substr_count('$nocommas',';') > 0) {
									$ingdata = substr(current(explode(";",$ingarray[$ict][2])),1);
									$ingarray[$pict][2] .= " ".$ingdata;
									$newpparray= explode(",",end(explode(";",$ingarray[$ict][2])));
									if (!$ingarray[$pict][3]) {
										$ingarray[$pict][3]=trim($newpparray[0]);
										$ingarray[$pict][4]=trim($newpparray[1]);
									} else if (!$ingarray[$pict][4]) {
										  $ingarray[$pict][4]=trim($newpparray[0]);
									}
								} else {
									$newarray= explode(",",$ingarray[$ict][2]);
									if (!isset($ingarray[$pict][3])) {
										if ($semicolonatend==1) {
											$ingarray[$pict][3]=trim($newarray[0]);
											$ingarray[$pict][4]=trim($newarray[1]);
										} else {
											if (count($newarray)==3) {
												$ingarray[$pict][2] .= " ".$newarray[0];
												$ingarray[$pict][3]=trim($newarray[1]);
												$ingarray[$pict][4]=trim($newarray[2]);
											} else if (count($newarray)==2) {
												$ingarray[$pict][2] .= " ".$newarray[0];
												$ingarray[$pict][3]=trim($newarray[1]);
											} else if (count($newarray)==1) {
												$ingarray[$pict][2] .= " ".$newarray[0];
											}
										}
									} else if ($ingarray[$pict][3] and !$ingarray[$pict][4]) {
										if ($ppend==1) {
										   $ingarray[$pict][4] = $newarray[0].$newarray[1];
										} else {
										   $ingarray[$pict][3] .= " ".$newarray[0];
										   $ingarray[$pict][4] = trim($newarray[1]);
										}
									} else if ($ingarray[$pict][4]) {
										$ingarray[$pict][4] .= " ".$newarray[0]." ".$newarray[1];
									}
								}
								$ingarray[$ict]='';
								$arr=array_filter($ingarray);
								$arr=array_values($ingarray);
							}
						} else { //this is a header line
						    $data = preg_replace( '/^-*/', "", $data); //remove leading dashes
							$data = preg_replace( '/-*$/', "", trim($data)); ////remove trailing dashes
							$ingarray[$ict][2] = strtoupper($data); //place in ingredient field and convert to uppercase
						}
						$ict++;
						$pict++;
					}
				} else {
					if (substr($data,0,5)=='MMMMM' || substr($data,0,5)=='-----') {
						$directions = str_replace(";",",",$directions);
						$directions = str_replace(":",",",$directions);
						//$directions = str_replace("'",'"',$directions);
						$directions = rtrim($directions,"<br>");
						$directions = ltrim($directions,"<br>");

						$sql = "$call query_add_recipe(:uid, :name)";
						$rsing = $rdb->prepare($sql);
                        $rsing->bindValue(':uid', $uid);
                        $rsing->bindValue(':name', $name);

						if (!$rsing->execute()) {
							$problem = $rdb->errorInfo();
                            $rsing->closeCursor();
						} else {
                            $rsing->closeCursor();
							$imported++;
							$sql="$call query_new_recipe_id(:name,:uid)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':name', $name);
                            $db->bindValue(':uid', $uid);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $dbid = $db->fetch(PDO::FETCH_BOTH);
                            $db->closeCursor();
                            
                            $id = $dbid[0];
                            
							if ($approve=='yes') {
								$sql="$call query_approve(:id)";
                                $db = $rdb->prepare($sql);
                                $db->bindValue(':id', $id);
                                $db->execute();
                                $err=$rdb->errorInfo();
                                $db->closeCursor();
							}
							$addedby=$user;                    
							$sql = "$call query_add_addedby_to_recipe(:addedby,:id)";
							$rs = $rdb->prepare($sql);
                            $rs->bindValue(':addedby', $addedby);
                            $rs->bindValue(':id', $id);
                            $rs->execute();
                            $err=$rdb->errorInfo();
                            $rs->closeCursor();
  
							$added = date('c');
                            
							$sql = "$call query_add_added_to_recipe(:added,:id)";
							$rs = $rdb->prepare($sql);
                            $rs->bindValue(':added', $added);
                            $rs->bindValue(':id', $id);
                            $rs->execute();
                            $err=$rdb->errorInfo();
                            $rs->closeCursor();
                            
                            if (isset($directions)) {
                                $sql = "$call query_add_directions_to_recipe(:directions,:id)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':directions', $directions);
                                $rs->bindValue(':id', $id);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
                            }
                            
							if (isset($yield)) {
								$sql = "$call query_add_yield_to_recipe(:yield,:id)";
								$rs = $rdb->prepare($sql);
                                $rs->bindValue(':yield', $yield);
                                $rs->bindValue(':id', $id);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
							}

							if (isset($preptime)) {
								$sql = "$call query_add_preptime_to_recipe(:preptime,:id)";
								$rs = $rdb->prepare($sql);
                                $rs->bindValue(':preptime', $preptime);
                                $rs->bindValue(':id', $id);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
							}

							if (isset($source)) {
								$sql = "$call query_source_exists(:source)";
								$sourcedb = $rdb->prepare($sql);
                                $sourcedb->bindValue(':source', $source);
                                $sourcedb->execute();
                                $err=$rdb->errorInfo();
                                $srows=$sourcedb->rowCount();
                                $sourcers = $sourcedb->fetch(PDO::FETCH_BOTH);
                                $sourcedb->closeCursor();
                                
								if ($srows>0) {
									$sid = $sourcers[0];
									$sql = "$call query_source_owner_exists(:sid,:uid)";
									$sourceors = $rdb->prepare($sql);
                                    $sourceors->bindValue(':sid', $sid);
                                    $sourceors->bindValue(':uid', $uid);
                                    $sourceors->execute();
                                    $err=$rdb->errorInfo();
                                    $sorows=$sourceors->rowCount();
                                    $sourceors->closeCursor();
                                    
									if ($sorows==0) {
										$sql="$call query_add_owner_source(:sid,:uid)";
                                        $rs = $rdb->prepare($sql);
                                        $rs->bindValue(':sid', $sid);
                                        $rs->bindValue(':uid', $uid);
                                        $rs->execute();
                                        $err=$rdb->errorInfo();
                                        $rs->closeCursor();
									}
								} else {
									$sql="$call query_add_source(:source)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':source', $source);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
                                    
                                    $sql = "$call query_source_exists(:source)";
                                    $sourcedb = $rdb->prepare($sql);
                                    $sourcedb->bindValue(':source', $source);
                                    $sourcedb->execute();
                                    $err=$rdb->errorInfo();
                                    $sourcers = $sourcedb->fetch(PDO::FETCH_BOTH);
                                    $sourcedb->closeCursor();
                                    
									$sid = $sourcers[0];
                                    
									$sql="$call query_add_owner_source(:sid,:uid)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':sid', $sid);
                                    $rs->bindValue(':uid', $uid);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
								}
								$sql = "$call query_add_source_to_recipe(:sid,:id)";
								$rs = $rdb->prepare($sql);
                                $rs->bindValue(':sid', $sid);
                                $rs->bindValue(':id', $id);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
							}

							if (isset($yield_unit)) {
								$yield_unitsql = "$call query_yield_unit_exists(:yield_unit)";
                                $rs = $rdb->prepare($yield_unitsql);
                                $rs->bindValue(':yield_unit', $yield_unit);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $yrows=$rs->rowCount();
                                $yield_unitrs = $rs->fetch(PDO::FETCH_BOTH);
                                $rs->closeCursor();
                                
                                if ($yrows>0) {
                                    $yid = $yield_unitrs[0];
                                    $sql = "$call query_yield_unit_owner_exists(:yid,:uid)";
                                    $ors = $rdb->prepare($sql);
                                    $ors->bindValue(':yid', $yid);
                                    $ors->bindValue(':uid', $uid);
                                    $ors->execute();
                                    $err=$rdb->errorInfo();
                                    $sorows=$ors->rowCount();
                                    $ors->closeCursor();
                                    if ($sorows==0) {
                                        $sql="$call query_add_owner_yield_unit(:yid,:uid)";
                                        $rs = $rdb->prepare($sql);
                                        $rs->bindValue(':yid', $yid);
                                        $rs->bindValue(':uid', $uid);
                                        $rs->execute();
                                        $err=$rdb->errorInfo();
                                        $rs->closeCursor();
                                    }
                                } else {
                                    $sql="$call query_add_yield_unit(:yield_unit)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':yield_unit', $yield_unit);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
                                    
                                    $yield_unitsql = "$call query_yield_unit_exists(:yield_unit)";
                                    $rs = $rdb->prepare($yield_unitsql);
                                    $rs->bindValue(':yield_unit', $yield_unit);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $yield_unitrs = $rs->fetch(PDO::FETCH_BOTH);
                                    $rs->closeCursor();
                                    
                                    $yid = $yield_unitrs[0];
                                    $sql="$call query_add_owner_yield_unit(:yid,:uid)";
                                    $rs = $rdb->prepare($sql);
                                    $rs->bindValue(':yid', $yid);
                                    $rs->bindValue(':uid', $uid);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
                                }
                                $sql = "$call query_add_yield_unit_to_recipe(:yid,:id)";
                                $rs = $rdb->prepare($sql);
                                $rs->bindValue(':yid', $yid);
                                $rs->bindValue(':id', $id);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
							}

							foreach($catarray as $key => $value){
								if ($value) {
									$value= trim($value);
									$notmultiple = substr_replace($value,'',-1);
                                    
									$sql = "$call query_diet_or_diets_exists(:value,:notmultiple)";
									$rs = $rdb->prepare($sql);
                                    $rs->bindValue(':value', $value);
                                    $rs->bindValue(':notmultiple', $notmultiple);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $drows=$rs->rowCount();
                                    $rsdietchk = $rs->fetch(PDO::FETCH_BOTH);
                                    $rs->closeCursor();
                                    
									$sql = "$call query_cuisine_or_cuisines_exists(:value,:notmultiple)";
									$rs = $rdb->prepare($sql);
                                    $rs->bindValue(':value', $value);
                                    $rs->bindValue(':notmultiple', $notmultiple);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $crows=$rs->rowCount();
                                    $rscuisinechk = $rs->fetch(PDO::FETCH_BOTH);
                                    $rs->closeCursor();
                                    
									$sql = "$call query_category_or_categorys_exists(:value,:notmultiple)";
									$rs = $rdb->prepare($sql);
                                    $rs->bindValue(':value', $value);
                                    $rs->bindValue(':notmultiple', $notmultiple);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $catrows=$rs->rowCount();
                                    $rscatchk = $rs->fetch(PDO::FETCH_BOTH);
                                    $rs->closeCursor();
                                    
									$sql = "$call query_subcategory_or_subcategorys_exists(:value,:notmultiple)";
									$rs = $rdb->prepare($sql);
                                    $rs->bindValue(':value', $value);
                                    $rs->bindValue(':notmultiple', $notmultiple);
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $scatrows=$rs->rowCount();
                                    $rsscatchk = $rs->fetch(PDO::FETCH_BOTH);
                                    $rs->closeCursor();

									if ($catrows > 0) {
										if ($key >0 and $newcatarray[$prevkey][0]==20)  {
											$newcatarray[$prevkey][0] = $rscatchk[0];
										} else {
										  $newcatarray[$key][0]=$rscatchk[0];
										  $newcatarray[$key][1]= 32;
										  $prevkey=$key;
										}
									} else if ($scatrows > 0) {
										if ($key >0 and $newcatarray[$prevkey][1]==32)  {
											$newcatarray[$prevkey][1] = $rsscatchk[0];
										} else {
										  $newcatarray[$key][1]= $rsscatchk[0];
										  $newcatarray[$key][0]= 20;
										  $prevkey=$key;
										}
									} else if ($drows > 0) {
										$dietid =  $rsdietchk[0];
                                        
										$sql = "$call query_diet_owner_exists(:dietid,:uid)";
										$dietors = $rdb->prepare($sql);
                                        $dietors->bindValue(':dietid', $dietid);
                                        $dietors->bindValue(':uid', $uid);
                                        $dietors->execute();
                                        $err=$rdb->errorInfo();
                                        $dorows=$dietors->rowCount();
                                        $dietors->closeCursor();
										
                                        if ($dorows==0) {
											$sql="$call query_add_owner_diet(:dietid,:uid)";
                                            $ors = $rdb->prepare($sql);
                                            $ors->bindValue(':dietid', $dietid);
                                            $ors->bindValue(':uid', $uid);
                                            $ors->execute();
                                            $err=$rdb->errorInfo();
                                            $ors->closeCursor();
										}
										
                                        $sql = "$call query_add_recipe_diet(:id, :dietid)";
										$rs = $rdb->prepare($sql);
                                        $rs->bindValue(':dietid', $dietid);
                                        $rs->bindValue(':id', $id);
                                        $rs->execute();
                                        $err=$rdb->errorInfo();
                                        $rs->closeCursor();
                                        
									} else if ($crows > 0) {
										$cuisineid =  $rscuisinechk[0];
										$sql = "$call query_cuisine_owner_exists(:cuisineid,:uid)";
                                        $cuisineors = $rdb->prepare($sql);
                                        $cuisineors->bindValue(':cuisineid', $cuisineid);
                                        $cuisineors->bindValue(':uid', $uid);
                                        $cuisineors->execute();
                                        $err=$rdb->errorInfo();
                                        $corows=$cuisineors->rowCount();
                                        $cuisineors->closeCursor();
                                        
                                        if ($dorows==0) {
                                            $sql="$call query_add_owner_cuisine(:cuisineid,:uid)";
                                            $ors = $rdb->prepare($sql);
                                            $ors->bindValue(':cuisineid', $cuisineid);
                                            $ors->bindValue(':uid', $uid);
                                            $ors->execute();
                                            $err=$rdb->errorInfo();
                                            $ors->closeCursor();
                                        }
                                        
                                        $sql = "$call query_add_recipe_cuisine(:id, :cuisineid)";
                                        $rs = $rdb->prepare($sql);
                                        $rs->bindValue(':cuisineid', $cuisineid);
                                        $rs->bindValue(':id', $id);
                                        $rs->execute();
                                        $err=$rdb->errorInfo();
                                        $rs->closeCursor();
                                        
									}  else {
										$sql="$call query_add_category(:value)";
                                        $rs = $rdb->prepare($sql);
                                        $rs->bindValue(':value', $value);
                                        $rs->execute();
                                        $err=$rdb->errorInfo();
                                        $rs->closeCursor();
										
                                        $sql = "$call query_category_exists(:value)";
										$rs = $rdb->prepare($sql);
                                        $rs->bindValue(':value', $value);
                                        $rs->execute();
                                        $err=$rdb->errorInfo();
                                        $rsscatchk = $rs->fetch(PDO::FETCH_BOTH);
                                        $rs->closeCursor();
										
                                        $cat = $rsscatchk[0];
										
                                        $sql="$call query_add_owner_category(:cat,:uid)";
                                        $rs = $rdb->prepare($sql);
                                        $rs->bindValue(':cat', $cat);
                                        $rs->bindValue(':uid', $uid);
                                        $rs->execute();
                                        $err=$rdb->errorInfo();
                                        $rs->closeCursor();
                                        
										$newcatarray[$key][0]= $cat;
									}
								}
							}
							if ($newcatarray) {
								foreach($newcatarray as $key => $value){
									foreach($value as $ikey => $ival) {
										if ($ikey==0) {
											$catid=$ival;
										} else {
											$subcatid=$ival;
										}
									}
									if ($subcatid and $subcatid!=32) {
										$sql="$call query_add_recipe_cat_subcat(:id , :catid, :subcatid)";
                                        $rs = $rdb->prepare($sql);
                                        $rs->bindValue(':catid', $catid);
                                        $rs->bindValue(':id', $id);
                                        $rs->bindValue(':subcatid', $subcatid);
									} else {
										$sql="$call query_add_recipe_cat(:id , :catid)";
                                        $rs = $rdb->prepare($sql);
                                        $rs->bindValue(':catid', $catid);
                                        $rs->bindValue(':id', $id);
									}
									
                                    $rs->execute();
                                    $err=$rdb->errorInfo();
                                    $rs->closeCursor();
								}
							} else {
								$sql="$call query_add_recipe_cat(:id , 20)";
								$rs = $rdb->prepare($sql);
                                $rs->bindValue(':id', $id);
                                $rs->execute();
                                $err=$rdb->errorInfo();
                                $rs->closeCursor();
							}
							if ($ingarray) {
								foreach($ingarray as $valing) {
									if ($valing != "") {
										$hasqty=0; $hasunit=0; $hasing=0; $haspp1=0; $haspp2=0;
										foreach($valing as $ikey => $value){
											if ($ikey == 0 and $value) {
												$qty = $value;
												if (!preg_match('#[0-9]#',$qty)){
													$invqty++;
													unset($qty);
													if ($invqty==1) {
														$msg3 = "The Following Recipes Have Invalid Quantities:<br><br>";
													}
													$msg3 .= "<span style='color:#000000;font-size:12px;text-align:left;' >".$name."</span><br>";
												} else {
													$hasqty=1;
													if (strpos($qty,'-')>-1) { //we have a range
														$qty=(substr($qty,0,strpos($qty,'-')));
													}
													if (strchr($qty,'/')>-1) { //we have a fraction or mixed number
														$match = extract_numbers($qty);
														if (count($match)==2) { //we have a fraction
															$qtydec=$match[0]/$qtydec=$match[1];
														} else if (count($match)>2) { //the qty is a mixed number
															$qtydec=$match[0] + ($match[1] / $match[2]);
														}
													} else {
														$qtydec=$qty;
													}
												}
											}
											if ($ikey == 1 and $value) {
												$hasunit=1;
                                                $sql="SELECT DISTINCT mmf, base from unit_base";
                                                $dbunit = $rdb->prepare($sql);
                                                $dbunit->execute();
                                                $err=$rdb->errorInfo();
                                                $unitarray = $dbunit->fetchAll(PDO::FETCH_BOTH);
                                                $dbunit->closeCursor();
                                                
                                                foreach ($unitarray as $unitval) {
                                                    if ($value==$unitval[0]) {
                                                           $value=$unitval[1];
                                                           break;
                                                    }
                                                }
												
												$unitsql = "$call query_unit_exists(:unit)";
                                                $rs = $rdb->prepare($unitsql);
                                                $rs->bindValue(':unit', $value);
                                                $rs->execute();
                                                $err=$rdb->errorInfo();
                                                $urows=$rs->rowCount();
                                                $unitrs = $rs->fetch(PDO::FETCH_BOTH);
                                                $rs->closeCursor();
                                                
                                                if ($urows>0) {
                                                    $unitid = $unitrs[0];
                                                    $sql = "$call query_unit_owner_exists(:unitid,:uid)";
                                                    $unitors = $rdb->prepare($sql);
                                                    $unitors->bindValue(':unitid', $unitid);
                                                    $unitors->bindValue(':uid', $uid);
                                                    $unitors->execute();
                                                    $err=$rdb->errorInfo();
                                                    $sorows=$unitors->rowCount();
                                                    $unitors->closeCursor();
                                                    if ($sorows==0) {
                                                        $sql="$call query_add_owner_unit(:unitid,:uid)";
                                                        $rs = $rdb->prepare($sql);
                                                        $rs->bindValue(':unitid', $unitid);
                                                        $rs->bindValue(':uid', $uid);
                                                        $rs->execute();
                                                        $err=$rdb->errorInfo();
                                                        $rs->closeCursor();
                                                    }
                                                } else {
                                                    $sql="$call query_add_unit(:unit)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':unit', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                    
                                                    $unitsql = "$call query_unit_exists(:unit)";
                                                    $rs = $rdb->prepare($unitsql);
                                                    $rs->bindValue(':unit', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $unitrs = $rs->fetch(PDO::FETCH_BOTH);
                                                    $rs->closeCursor();
                                                    
                                                    $unitid = $unitrs[0];
                                                    $sql="$call query_add_owner_unit(:unitid,:uid)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':unitid', $unitid);
                                                    $rs->bindValue(':uid', $uid);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                }
											}
											if ($ikey == 2 and $value) {
												$hasing=1;
												$ingredientsql = "$call query_ingredient_exists(:ingredient)";
                                                $rs = $rdb->prepare($ingredientsql);
                                                $rs->bindValue(':ingredient', $value);
                                                $rs->execute();
                                                $err=$rdb->errorInfo();
                                                $yrows=$rs->rowCount();
                                                $ingredientrs = $rs->fetch(PDO::FETCH_BOTH);
                                                $rs->closeCursor();
                                                
                                                if ($yrows>0) {
                                                    $ingid = $ingredientrs[0];
                                                    $sql = "$call query_ingredient_owner_exists(:ingid,:uid)";
                                                    $ors = $rdb->prepare($sql);
                                                    $ors->bindValue(':ingid', $ingid);
                                                    $ors->bindValue(':uid', $uid);
                                                    $ors->execute();
                                                    $err=$rdb->errorInfo();
                                                    $sorows=$ors->rowCount();
                                                    $ors->closeCursor();
                                                    
                                                    if ($sorows==0) {
                                                        $sql="$call query_add_owner_ingredient(:ingid,:uid)";
                                                        $rs = $rdb->prepare($sql);
                                                        $rs->bindValue(':ingid', $ingid);
                                                        $rs->bindValue(':uid', $uid);
                                                        $rs->execute();
                                                        $err=$rdb->errorInfo();
                                                        $rs->closeCursor();
                                                    }
                                                } else {
                                                    $sql="$call query_add_ingredient(:ingredient)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':ingredient', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                    
                                                    $ingredientsql = "$call query_ingredient_exists(:ingredient)";
                                                    $rs = $rdb->prepare($ingredientsql);
                                                    $rs->bindValue(':ingredient', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $ingredientrs = $rs->fetch(PDO::FETCH_BOTH);
                                                    $rs->closeCursor();
                                                    
                                                    $ingid = $ingredientrs[0];
                                                    $sql="$call query_add_owner_ingredient(:ingid,:uid)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':ingid', $ingid);
                                                    $rs->bindValue(':uid', $uid);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                }
											}
											if ($ikey == 3 and $value) {
												$haspp1=1;
												$preprepsql = "$call query_preprep_exists(:preprep)";
                                                $rs = $rdb->prepare($preprepsql);
                                                $rs->bindValue(':preprep', $value);
                                                $rs->execute();
                                                $err=$rdb->errorInfo();
                                                $yrows=$rs->rowCount();
                                                $prepreprs = $rs->fetch(PDO::FETCH_BOTH);
                                                $preprepsql = "$call query_preprep_exists(:preprep)";
                                                
                                                if ($yrows>0) {
                                                    $pp1id = $prepreprs[0];
                                                    $sql = "$call query_preprep_owner_exists(:pp1id,:uid)";
                                                    $preprepors = $rdb->prepare($sql);
                                                    $preprepors->bindValue(':pp1id', $pp1id);
                                                    $preprepors->bindValue(':uid', $uid);
                                                    $preprepors->execute();
                                                    $err=$rdb->errorInfo();
                                                    $sorows=$preprepors->rowCount();
                                                    $preprepors->closeCursor();
                                                    if ($sorows==0) {
                                                        $sql="$call query_add_owner_preprep(:pp1id,:uid)";
                                                        $rs = $rdb->prepare($sql);
                                                        $rs->bindValue(':pp1id', $pp1id);
                                                        $rs->bindValue(':uid', $uid);
                                                        $rs->execute();
                                                        $err=$rdb->errorInfo();
                                                        $rs->closeCursor();
                                                    }
                                                } else {
                                                    $sql="$call query_add_preprep(:preprep)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':preprep', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                    
                                                    $preprepsql = "$call query_preprep_exists(:preprep)";
                                                    $rs = $rdb->prepare($preprepsql);
                                                    $rs->bindValue(':preprep', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $prepreprs = $rs->fetch(PDO::FETCH_BOTH);
                                                    $rs->closeCursor();
                                                    
                                                    $pp1id = $prepreprs[0];
                                                    $sql="$call query_add_owner_preprep(:pp1id,:uid)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':pp1id', $pp1id);
                                                    $rs->bindValue(':uid', $uid);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                }
											}
											if ($ikey == 4 and $value) {
												$haspp2=1;
												$preprepsql = "$call query_preprep_exists(:preprep)";
                                                $rs = $rdb->prepare($preprepsql);
                                                $rs->bindValue(':preprep', $value);
                                                $rs->execute();
                                                $err=$rdb->errorInfo();
                                                $yrows=$rs->rowCount();
                                                $prepreprs = $rs->fetch(PDO::FETCH_BOTH);
                                                $rs->closeCursor();
                                                
                                                if ($yrows>0) {
                                                    $pp2id = $prepreprs[0];
                                                    $sql = "$call query_preprep_owner_exists(:pp2id,:uid)";
                                                    $preprepors = $rdb->prepare($sql);
                                                    $preprepors->bindValue(':pp2id', $pp2id);
                                                    $preprepors->bindValue(':uid', $uid);
                                                    $preprepors->execute();
                                                    $err=$rdb->errorInfo();
                                                    $sorows=$preprepors->rowCount();
                                                    $preprepors->closeCursor();
                                                    if ($sorows==0) {
                                                        $sql="$call query_add_owner_preprep(:pp2id,:uid)";
                                                        $rs = $rdb->prepare($sql);
                                                        $rs->bindValue(':pp2id', $pp2id);
                                                        $rs->bindValue(':uid', $uid);
                                                        $rs->execute();
                                                        $err=$rdb->errorInfo();
                                                        $rs->closeCursor();
                                                    }
                                                } else {
                                                    $sql="$call query_add_preprep(:preprep)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':preprep', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                    
                                                    $preprepsql = "$call query_preprep_exists(:preprep)";
                                                    $rs = $rdb->prepare($preprepsql);
                                                    $rs->bindValue(':preprep', $value);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $prepreprs = $rs->fetch(PDO::FETCH_BOTH);
                                                    $rs->closeCursor();
                                                    
                                                    $pp2id = $prepreprs[0];
                                                    $sql="$call query_add_owner_preprep(:pp2id,:uid)";
                                                    $rs = $rdb->prepare($sql);
                                                    $rs->bindValue(':pp2id', $pp2id);
                                                    $rs->bindValue(':uid', $uid);
                                                    $rs->execute();
                                                    $err=$rdb->errorInfo();
                                                    $rs->closeCursor();
                                                }
											}

										}
										if ($hasing==1) {
											$sql = "$call query_add_recipe_ing(:id, :ingid)";
                                            $db = $rdb->prepare($sql);
                                            $db->bindValue(':id', $id);
                                            $db->bindValue(':ingid', $ingid);
                                            $db->execute();
                                            $err=$rdb->errorInfo();
                                            $db->closeCursor();
                                            
                                            //find id of recipe_ing added to cater for duplicated ingredients in recipe
                                            $sql = "$call query_latest_recipe_ing(:id, :ingid)";
                                            $db = $rdb->prepare($sql);
                                            $db->bindValue(':id', $id);
                                            $db->bindValue(':ingid', $ingid);
                                            $db->execute();
                                            $err=$rdb->errorInfo();
                                            $dbi = $db->fetch(PDO::FETCH_BOTH);
                                            $db->closeCursor();
                                            $riid = $dbi[0];

											if ($hasqty==1) {
                                                $sql = "$call query_add_quantity_to_ing(:qty, :id, :ingid, :riid)";
                                                $db = $rdb->prepare($sql);
                                                $db->bindValue(':qty', $qty);
                                                $db->bindValue(':id', $id);
                                                $db->bindValue(':ingid', $ingid);
                                                $db->bindValue(':riid', $riid);
                                                $db->execute();
                                                $err=$rdb->errorInfo();
                                                $db->closeCursor();
                                                
                                                $sql = "$call query_add_qtydec_to_ing(:qtydec, :id, :ingid, :riid)";
                                                $db = $rdb->prepare($sql);
                                                $db->bindValue(':qtydec', $qtydec);
                                                $db->bindValue(':id', $id);
                                                $db->bindValue(':ingid', $ingid);
                                                $db->bindValue(':riid', $riid);
                                                $db->execute();
                                                $err=$rdb->errorInfo();
                                                $db->closeCursor();
                                            }
                                            if ($hasunit==1) {
                                                $sql = "$call query_add_unit_to_ing(:unitid, :id, :ingid, :riid)";
                                                $db = $rdb->prepare($sql);
                                                $db->bindValue(':unitid', $unitid);
                                                $db->bindValue(':id', $id);
                                                $db->bindValue(':ingid', $ingid);
                                                $db->bindValue(':riid', $riid);
                                                $db->execute();
                                                $err=$rdb->errorInfo();
                                                $db->closeCursor();
                                            }
                                            if ($haspp1==1) {
                                                $sql = "$call query_add_preprep1_to_ing(:pp1id, :id, :ingid, :riid)";
                                                $db = $rdb->prepare($sql);
                                                $db->bindValue(':pp1id', $pp1id);
                                                $db->bindValue(':id', $id);
                                                $db->bindValue(':ingid', $ingid);
                                                $db->bindValue(':riid', $riid);
                                                $db->execute();
                                                $err=$rdb->errorInfo();
                                                $db->closeCursor();
                                            }
                                            if ($haspp2==1) {
                                                $sql = "$call query_add_preprep2_to_ing(:pp2id, :id, :ingid, :riid)";
                                                $db = $rdb->prepare($sql);
                                                $db->bindValue(':pp2id', $pp2id);
                                                $db->bindValue(':id', $id);
                                                $db->bindValue(':ingid', $ingid);
                                                $db->bindValue(':riid', $riid);
                                                $db->execute();
                                                $err=$rdb->errorInfo();
                                                $db->closeCursor();
                                            }
										}
									}
								}
							}
						}
					} else {
						$directions .= str_replace("\r",'',str_replace("\n","<br>",$data));
						if (isset($directions)) {
							 $hasdir=TRUE;
						}
					}
				}
			}
		}
		fclose($handle);
	}

	if (isset($msg2) || isset($msg3)) {
		if (isset($msg2)) {
			if (isset($stringData)) {
				$stringData .= '<br>'.$msg2;
			} else {
				$stringData = '<br><br>'.$msg2;
			}
		}
		if (isset($msg3)) {
			if (isset($stringData)) {
				$stringData .= '<br>'.$msg3;
			} else {
				$stringData = '<br><br>'.$msg3;
			}
		}
		echo $id.'|'.$uid.'|'.$stringData;
	} else {
		echo $id.'|'.$uid;
	}

}
?>
