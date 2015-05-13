<?php

    require_once('rdb.php');

	function extract_numbers($string){
	    preg_match_all('/([\d]+)/', $string, $match);
	    return $match[0];
	}
	function SureRemoveDir($dir) {
		if(!$dh = @opendir($dir)) return;
		while (false !== ($obj = readdir($dh))) {
			if($obj=='.' || $obj=='..') continue;
			if (!@unlink($dir.'/'.$obj)) SureRemoveDir($dir.'/'.$obj, true);
		}
	}

	for ($lt = 0; $lt < 4; $lt++){
		if(isset($_POST["cat$lt"])){
			$foundcat=1;
			break;
		}
	}
    if(isset($_POST['name'])) {
	    $name=$_POST['name'];
    }
	
	if (isset($name) and isset($foundcat)) {
        if(isset($_POST['added'])) {
            $added=$_POST['added'];
        }
        if (isset($_SESSION[$client.'admin'])) {
            $admin=$_SESSION[$client.'admin'];
        }
        if (isset($_SESSION[$client.'rapp'])) {
            $rapp=$_SESSION[$client.'rapp'];
        }
        
        if(isset($_POST['id'])) {
            $id=$_POST['id'];
        }
        
        if(isset($id)) {
            $oldrecipe='yes';
            $updated=date('c');
			$sql = "$call query_upd_recipe(:name,:id)";
            $db = $rdb->prepare($sql);
            $db->bindValue(':id', $id);
            $db->bindValue(':name', $name);
            require_once('get_recipe_owner.php');
		} else {
            unset($added);
			$sql = "$call query_add_recipe(:uid, :name)";
            $db = $rdb->prepare($sql);
            $db->bindValue(':uid', $uid);
            $db->bindValue(':name', $name);
		}
        if(!isset($rowner)) {
            $rowner=$uid;
        }
		
        if (!$db->execute()) {
			$err1 = $db->errorInfo();
            $db->closeCursor();
			$msgtxt = "0|Save Unsuccessful";
            $msgtxt .= "<br>- ".$err1;
            echo $msgtxt;
		} else {
            $db->closeCursor();
			if (!isset($id)) {
				$sql="$call query_new_recipe_id(:name,:uid)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':name', $name);
                $db->bindValue(':uid', $uid);
                $db->execute();
                $err=$rdb->errorInfo();
                $dbid = $db->fetch(PDO::FETCH_BOTH);
                $db->closeCursor();
				
				$id = $dbid[0];
                
				if (isset($admin) || !isset($rapp)) {
					$sql="$call query_approve(:id)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
				}
			}
            
		    if(isset($updated))  {
			    $sql = "$call query_add_updated_to_recipe(:updated,:id)";
			    $db = $rdb->prepare($sql);
                $db->bindValue(':updated', $updated);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
		    }

		    if(isset($_POST['preptime']))  {
			    $preptime = $_POST['preptime'];
			    $sql = "$call query_add_preptime_to_recipe(:preptime,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':preptime', $preptime);
                $db->bindValue(':id', $id);
		    } else {
			    $sql = "$call query_add_preptime_to_recipe(null,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
		    }
		    $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();

		    if(isset($_POST['cooktime']))  {
			    $cooktime = $_POST['cooktime'];
			    $sql = "$call query_add_cooktime_to_recipe(:cooktime,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':cooktime', $cooktime);
                $db->bindValue(':id', $id);
		    } else {
			    $sql = "$call query_add_cooktime_to_recipe(null,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
		    }
		    $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();

		    if(isset($_POST['addedby']))  {
			    $addedby = $_POST['addedby'];
			    $sql = "$call query_add_addedby_to_recipe(:addedby,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':addedby', $addedby);
                $db->bindValue(':id', $id);
		    } else {
			    $sql = "$call query_add_addedby_to_recipe(null,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
		    }
		    $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();

		    //set counter to keep track if there were any images or pdfs uploaded
		    $ict=0;
		    if (isset($_POST["newimage0"]) || isset($_POST["image0"])) {
			    $sql = "$call query_delete_recipe_images(:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			    
			    for ($lt = 0; $lt < 10; $lt++){
				    if(isset($_POST["newimage$lt"])) {
					    $image=$_POST["newimage$lt"];
				    } else if(isset($_POST["image$lt"])) {
					    $image=$_POST["image$lt"];
				    } else {
					    unset($image);
				    }
				    if (isset($image)) {
					    if (substr($image,0,strlen($user))!=$user) {
						    $newimage=$user."-".$image;
					    } else {
						    $newimage=$image;
					    }
					    $ict++;
					    if (!file_exists("../images/recipe/".$newimage)) {
							    $sourcedir = "../imagetmp/".$image;
							    $targetdir = "../images/recipe/".$newimage;
							    rename($sourcedir, $targetdir);
					    }
					    $sql = "$call query_image_exists(:newimage)";
					    $db = $rdb->prepare($sql);
                        $db->bindValue(':newimage', $newimage);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $ichkrows=$db->rowCount();
                        $db->closeCursor();
                        
					    if ($ichkrows==0) {
						    $sql = "$call query_add_image(:newimage)";
                            $db = $rdb->prepare($sql);
                            $db->bindValue(':newimage', $newimage);
                            $db->execute();
                            $err=$rdb->errorInfo();
                            $db->closeCursor();
					    }
					    $sql = "$call query_add_image_to_recipe(:newimage,:id)";
					    $db = $rdb->prepare($sql);
                        $db->bindValue(':newimage', $newimage);
                        $db->bindValue(':id', $id);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
				    }
			    }
		    }

		    if(isset($_POST['newpdf'])) {
			    $pdf=$_POST['newpdf'];
		    } else if(isset($_POST['pdf']) and !$oldrecipe) {
			    $pdf=$_POST['pdf'];
		    }
		    if (isset($pdf)) {
			    //if there was a new pdf uploaded
			    $ict++;
			    $withoutext = preg_replace("/\\.[^.\\s]{3,4}$/", "",$pdf);
			    $withoutext = str_replace(' ','_',$withoutext);
                $pdfjpg = $withoutext.'.jpg';

			    if (substr($pdf,0,strlen($user))!=$user) {
				    $newpdf=$user."-".$pdf;
			    } else {
				    $newpdf=$pdf;
			    }
			    if (!file_exists("../images/recipe/".$newpdf)) {
				    $sourcedir = "../imagetmp/".$pdf;
				    $targetdir = "../images/recipe/".$newpdf;
				    rename($sourcedir, $targetdir);
				    chmod($targetdir, 0604);
				    //upload all related jpgs (pdf may have been multipage)
				    //first the combined jpg for addform page
				    if (file_exists('../imagetmp/'.$withoutext.'-0.jpg')) {
                        foreach (glob('../imagetmp/'.$withoutext.'*.jpg') as $filename) {
                            $sourcedir = $filename;
                            $filename=substr($filename,12);
                            if (substr($filename,0,strlen($user))!=$user) {
                                $filename=$user."-".$filename;
                            }
                            $targetdir = "../images/recipe/".$filename;
                            rename($sourcedir, $targetdir);
                            chmod($targetdir, 0604); 
                        }
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
		    if(isset($_POST['newvideo'])) {
			    $video=$_POST['newvideo'];
		    } else if(isset($_POST['video']) and !isset($oldrecipe)) {
			    $video=$_POST['video'];
		    }
		    if (isset($video)) {
			    //if there was a new video uploaded
			    $ict++;
			    $video = str_replace(' ','_',$video);

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
		    //if there were any images or pdfs uploaded then clear imagetmp folder
		    if ($ict>0) {
			    $tempdir= "../imagetmp";
			    SureRemoveDir($tempdir);
		    }

		    if (isset($_POST['note'])) {
			    $note = trim($_POST['note']);
                $note=str_replace('"'," inch",$note);
			    $sql = "$call query_add_note_to_recipe(:note,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':note', $note);
		    } else {
			    $sql = "$call query_add_note_to_recipe(null,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
		    }
		    $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();
            
            if (isset($_POST['directions'])) {
                $directions = trim($_POST['directions']);
                $directions=str_replace('"'," inch",$directions);
            }
            if(isset($directions) && $directions!="") {   
                $sql = "$call query_add_directions_to_recipe(:directions,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':directions', $directions);
            } else {
                $sql = "$call query_add_directions_to_recipe(null,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
            }                                                             
            $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();

		    if (isset($added)) {
			    $sql = "$call query_add_added_to_recipe(:added,:id)";
			    $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':added', $added);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
		    }

		    if (isset($_POST['yield'])) {
			    $yield = $_POST['yield'];
			    $sql = "$call query_add_yield_to_recipe(:yield,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->bindValue(':yield', $yield);
		    } else {
			    $sql = "$call query_add_yield_to_recipe(null,:id)";
                $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
		    }
		    $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();

		    $idarray = array();
		    $vars = array("source","cuisine","yield_unit","measure");
            if(isset($_POST['source'])) {
                $source=$_POST['source'];
            } else {
                $source=NULL;
            }
            if(isset($_POST['cuisine'])) {
                $cuisine=$_POST['cuisine'];
            } else {
                $cuisine=NULL;
            }
            if(isset($_POST['yield_unit'])) {
                $yield_unit=$_POST['yield_unit'];
            } else {
                $yield_unit=NULL;
            }
            if(isset($_POST['measure'])) {
                $measure=$_POST['measure'];
            } else {
                $measure=NULL;
            }
		    $vals = array($source,$cuisine,$yield_unit,$measure);
		    foreach ($vars as $key => $var){
			    list($v[0],$v[1],$v[2],$v[3])=$vals;
			    $val = $v[$key];
			    if (isset($val)) {
				    require('updateselecttables.php');
				    $sql = "$call query_add_".$var."_to_recipe(:rid,:id)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
                    $db->bindValue(':rid', $rid);
                    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor(); 
			    } else {
				    $sql = "$call query_add_".$var."_to_recipe(null,:id)";
                    $db = $rdb->prepare($sql);
                    $db->bindValue(':id', $id);
				    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
			    }
		    }
            
            if (isset($_POST['rating'])){
                $rating=$_POST['rating'];
                if (isset($oldrecipe)) {
                    include_once('calc_rating.php');
                } else {
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
                }
            }
            
		    if ($_POST['tried']=='on') { $tried="TRUE";} else { $tried="FALSE";}
		    $sql = "$call query_add_tried_to_recipe(:tried,:id)";
		    $db = $rdb->prepare($sql);
            $db->bindValue(':tried', $tried);
            $db->bindValue(':id', $id);
            $db->execute();
            $err=$rdb->errorInfo();
            $db->closeCursor();

			if (isset($oldrecipe)) {
			    $sql="$call query_clear_recipe_combos(:id)";
			    $db = $rdb->prepare($sql);
                $db->bindValue(':id', $id);
                $db->execute();
                $err=$rdb->errorInfo();
                $db->closeCursor();
			}
			if(isset($_POST['diet'])){
			    $var="diet";
			    $dietarray = explode(",",$_POST['diet']);
			    while (list ($key, $val) = each ($dietarray)) {
                    $val=trim($val);
                    if ($val!='') {
				        require('updateselecttables.php');
				        $sql="$call query_add_recipe_diet(:id,:rid)";
				        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':rid', $rid);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
                    }
			    }
			}
			if(isset($_POST['related_recipe'])){
			    $relarray = explode(",",$_POST['related_recipe']);
			    while (list ($key, $val) = each ($relarray)) {
                    $val=trim($val);
                    if ($val!='') {
				        $sql = "$call query_new_recipe_id(:val, :uid)";
				        $db = $rdb->prepare($sql);
                        $db->bindValue(':val', $val);
                        $db->bindValue(':uid', $uid);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $dbid = $db->fetch(PDO::FETCH_BOTH);
                        $db->closeCursor();
                        
				        $relrecid = $dbid[0];
                        
				        $sql="$call query_add_related_recipe(:id, :relrecid)";
				        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':relrecid', $relrecid);
                        $db->execute();
                        $err=$rdb->errorInfo();
                        $db->closeCursor();
                    }
			    }
			}
			for ($lt = 0; $lt < 4; $lt++){
			    unset($hascat); unset($hassubcat);
			    if(isset($_POST["cat$lt"])){
				    $val= $_POST["cat$lt"];
                    $hascat=1;
				    $var="category";
				    require('updateselecttables.php');
				    $catid=$rid;
			    }
			    if(isset($_POST["scat$lt"])){
				    $val= $_POST["scat$lt"];
                    $hassubcat=1;
				    $var="subcategory";
				    require('updateselecttables.php');
				    $subcatid = $rid;
			    }
			    if (isset($hascat)) {
				    if (isset($hassubcat)) {
					    $sql="$call query_add_recipe_cat_subcat(:id, :catid, :subcatid)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':catid', $catid);
                        $db->bindValue(':subcatid', $subcatid);
				    } else {
					    $sql="$call query_add_recipe_cat(:id , :catid)";
                        $db = $rdb->prepare($sql);
                        $db->bindValue(':id', $id);
                        $db->bindValue(':catid', $catid);
				    }
				    $db->execute();
                    $err=$rdb->errorInfo();
                    $db->closeCursor();
			    }
			}

			for ($lt = 0; $lt < 45; $lt++){
			    unset($hasqty); unset($hasunit); unset($hasqty2); unset($hasunit2); unset($hasing); unset($haspp1); unset($haspp2);
			    if (isset($_POST["qty$lt"])) {
				    $hasqty=1;
				    $qty = $_POST["qty$lt"];
                    $qty = str_replace('Â¼','1/4',$qty);
                    $qty = str_replace('Â½','1/2',$qty);
                    $qty = str_replace('Â¾','3/4',$qty);
				    $qty = str_replace('¼','1/4',$qty);
				    $qty = str_replace('½','1/2',$qty);
				    $qty = str_replace('¾','3/4',$qty);
				    $dash=strchr($qty,'-');
				    $to=strchr($qty,'to');
				    $or=strchr($qty,'or');
				    if ( $dash>-1 || $to>-1 || $or>-1) { //we may have a range in the quantity
					     if ($dash>-1) {
						     $dashspot=strpos($qty,'-'); //find the first occurence of the dash
					     } else if ($to>-1) {
						     $dashspot=strpos($qty,'to'); //find the first occurence of the to
					     } else if ($or>-1) {
						     $dashspot=strpos($qty,'or'); //find the first occurence of the or
					     }
					     $qty=substr($qty,0,$dashspot);
				    }
				    if (strchr($qty,'/')>-1) { //we have a fraction or mixed number
					    $match = extract_numbers($qty);
					    if (count($match)==2) { //we have a fraction
						    $qtydec=$match[0]/$qtydec=$match[1];
					    } else if (count($match)>2) { //the qty is a mixed number
					        $qtydec=$match[0] + ($match[1] / $match[2]);
					    }
				    } else if (strchr($qty,',')>-1) { //we have a european format number
					    $qtydec = str_replace('.','',$qty);
					    $qtydec = str_replace(',','.',$qty);
				    } else {
				        $qtydec=$qty;
				    }
			    }
			    if (isset($_POST["unit$lt"])) {
				    $hasunit=1;
				    $val=$_POST["unit$lt"];
				    $var="unit";
				    require('updateselecttables.php');
				    $unitid = $rid;
			    }
			    if (isset($_POST["eqty$lt"])) {
				    $hasqty2=1;
				    $qty2 = $_POST["eqty$lt"];
                    $qty2 = str_replace('Â¼','1/4',$qty2);
                    $qty2 = str_replace('Â½','1/2',$qty2);
                    $qty2 = str_replace('Â¾','3/4',$qty2);
                    $qty2 = str_replace('¼','1/4',$qty2);
                    $qty2 = str_replace('½','1/2',$qty2);
                    $qty2 = str_replace('¾','3/4',$qty2);
			    }
			    if (isset($_POST["eunit$lt"])) {
				    $hasunit2=1;
				    $val=$_POST["eunit$lt"];
				    $var="unit";
				    require('updateselecttables.php');
				    $unit2id = $rid;
			    }
			    if (isset($_POST["ing$lt"])) {
				    $hasing=1;
			    }
			    if (isset($_POST["pp1$lt"])) {
				    $val = $_POST["pp1$lt"];
				    $val=str_replace('"',' inch',$val);
				    $val = str_replace('<','less than ',$val);
				    $val = str_replace('&','and',$val);
				    $haspp1=1;
				    $var="preprep";
				    require('updateselecttables.php');
				    $pp1id = $rid;
			    }
			    if (isset($_POST["pp2$lt"])) {
				    $val = $_POST["pp2$lt"];
				    $val=str_replace('"',' inch',$val);
				    $val = str_replace('<','less than ',$val);
				    $val = str_replace('&','and',$val);
				    $haspp2=1;
				    $var="preprep";
				    require('updateselecttables.php');
				    $pp2id = $rid;
			    }

			    if (isset($hasing)) {
			        $val = $_POST["ing$lt"];
                    $val=str_replace('"',' inch',$val);
			        $val = str_replace('<','less than ',$val);
			        $val = str_replace('&','and',$val);
			        if (!isset($hasqty) and !isset($hasunit) and !isset($hasqty2) and !isset($hasunit2) and !isset($haspp1) and !isset($haspp2)) {
				    $val = strtoupper($val);
			        }
			        $var="ingredient";
			        require('updateselecttables.php');
			        $ingid = $rid;
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
                    $dbid = $db->fetch(PDO::FETCH_BOTH);
                    $db->closeCursor();
                    
			        $riid = $dbid[0];
	        
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
			}
            echo $id."|Recipe Saved|".$rowner;
        }
	} else {
        $msgtxt = "0|Save Unsuccessful";
		if (!isset($name)) {
			$msgtxt .= "<br><br>Name required";
		}
		if (!isset($foundcat)) {
			$msgtxt .= "<br><br>At least one category is required";
		}
        echo $msgtxt;
	}
?>