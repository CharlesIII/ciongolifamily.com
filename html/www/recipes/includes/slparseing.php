<?php

    require_once('rdb.php');
    
    function extract_numbers($string){
        preg_match_all('/([\d]+)/', $string, $match);
        return $match[0];
    }
    
    $ing = $_POST['ing'];
    $ing = str_replace('*','',$ing);  
    $text = explode("\n",$ing); // This will make $text an array with x rows, where x is the number of lines in the textarea.
    $text = array_map('trim', $text);
        
    $skey = array_keys($text,"");
    
    foreach ($skey as $value) {
        unset($text[$value]); //remove any empty lines
    }
    $text = array_values($text);
    $ingsel=0;
    //counter to keep track of how many ingredients we have
    $count=count($text);
    require_once('arrays.php');
    foreach ($text as $key => $line) {
        $line = trim(preg_replace('/\s+/', ' ',$line)); //remove any multiple/leading spaces from the line
        if ($line != "") {
            $ingsel++; //increment ingredient counter
            //remove characters that will break the code
            $line = str_replace('<','lt ',$line);
            $line = str_replace('>','gt ',$line);
            $line = str_replace('"','in ',$line);
            //replace html formatted fractions with proper fractions
            $line = str_replace('Â¼','1/4',$line);
            $line = str_replace('Â½','1/2',$line);
            $line = str_replace('Â¾','3/4',$line);
            //replace word formatted fractions with proper fractions
            $line = str_replace('¼','1/4',$line);
            $line = str_replace('½','1/2',$line);
            $line = str_replace('¾','3/4',$line);
            if (preg_match("/[0-9]+/", $line)==0 and strpos($line,',')===false) { //this line contains no commas or numbers it may be a header
                 if (stripos($line,'decorat')===false
                    and stripos($line,'season')===false
                    and stripos($line,'optional')===false 
                    and stripos($line,'serv')===false  
                    and stripos($line,'garnish')===false 
                    and stripos($line,'extra')===false 
                    and stripos($line,'taste')===false
                    and stripos($line,'garlic powder')===false
                    and stripos($line,'salt')===false
                    and stripos($line,'egg')===false  
                    and stripos($line,'pepper')===false)  { //this line contains no numbers and nothing that resembles an ingredient, assume it's a header  
                    $storeing[$key]=trim($line);
                    $headers[]=$line; //keep headers to use for extra sets of directions
                }  else {
                    $extraarray=array('extra','for decoration','to decorate','add to taste','to taste','for garnish', 'to garnish','to serve','for serving', 'to season', 'for seasoning', 'for garnishing','optional','freshly ground','to bind');
                    if (stripos($line,'salt')!==false 
                                || stripos($line,'pepper')!==false
                                || stripos($line,'egg')!==false
                                || stripos($line,'garlic powder')!==false) {
                         foreach ($extraarray as $value) {
                             if (stripos($line,$value)!==false) {
                                 if (isset(${'pp1'.$key})) {
                                     $value=trim($value);
                                     if (isset(${'pp2'.$key})) {
                                          ${'pp2'.$key} .= ' '.$value;
                                     } else {
                                         ${'pp2'.$key} = $value;
                                     }
                                 } else {
                                    ${'pp1'.$key}=$value;
                                 }
                                 $line=str_ireplace($value,'',$line);
                             }
                         }
                         
                         $wc=-1;
                         foreach ($eingarray as $lword) {
                             if (stripos($line,$lword)!==false) {
                                 $wc++;
                                 if ($wc==0) {
                                     $storeing[$key]=trim($line);
                                 } else {
                                    $ingsel++;
                                    ${'ing'.$count}=ucwords(trim($line));
                                    ${'pp1'.$count}=${'pp1'.$key};
                                    $count++;
                                 }
                             }
                         }
                     } else if (stripos($line,'serv')!==false 
                                || stripos($line,'decorat')!==false
                                || stripos($line,'extra')!==false
                                || stripos($line,'optional')!==false  
                                || stripos($line,'taste')!==false
                                || stripos($line,'garnish')!==false) {
                        foreach ($extraarray as $value) {
                             if (stripos($line,$value)!==false) {
                                 $value=trim($value);
                                 if (isset(${'pp1'.$key})) {
                                     if (isset(${'pp2'.$key})) {
                                          ${'pp2'.$key} .= ' '.$value;
                                     } else {
                                         ${'pp2'.$key} = $value;
                                     }
                                 } else {
                                    ${'pp1'.$key}=$value;
                                 }
                                 $line=str_ireplace($value,'',$line);
                                 if ($line!='')  {
                                     require('findunit.php');
                                     $line=str_ireplace($value,'',$line);
                                     $line=str_ireplace('()','',$line); 
                                     $storeing[$key]=trim($line);
                                     //break;
                                 } else {
                                     unset(${'pp1'.$key});
                                     $storeing[$key]=trim($value);
                                     break;
                                 }
                             }
                         }
                     }
                }
                if ($line!='') {
                    require('findunit.php');
                }
            } else {
            //get any alternative qty - assumed to be in brackets.
            //need to find text between brackets containing numbers
                $mc=-1;
                unset($matches);
                unset($numfound);
                unset($altqty);
                unset($altqtykey);
                while (strpos($line,'(')>-1) {
                    $mc++;
                    $line=preg_replace('/\(/','[',$line,1);
                    $line=preg_replace('/\)/',']',$line,1);   
                    $do = preg_match('/\[.+\]/i', $line,$matches[$mc]); 
                    $line=str_replace($matches[$mc],'',$line);
                }
                if(isset($matches)) {
                    foreach ($matches as $mkey => $mvalue) {
                        foreach ($mvalue as $pkey => $value) {
                            $matchnum = extract_numbers($value);
                            if (count($matchnum)>0 and !isset($numfound)) {
                                $numfound=1;
                                $altqty=$mkey;
                                $altqtykey=$pkey; 
                            } else {
                                $nvalue=str_replace('[','',$value);
                                $nvalue=str_replace(']','',$nvalue);
                                if ($nvalue!='s' and $nvalue!='es')  {
                                    if (isset(${'pp1'.$key})) {
                                         if (isset(${'pp2'.$key})) {
                                              ${'pp2'.$key} .= ' '.$nvalue;
                                         } else {
                                             ${'pp2'.$key} = $nvalue;
                                         }
                                    } else {
                                        ${'pp1'.$key}=$nvalue;
                                    }
                                }
                                //$line=str_replace($value,'',$line);
                            }
                        }
                    }
                } 
                if (isset($altqty)) {  //we have an alt qty
                    $matches[$altqty][$altqtykey] = preg_replace('/,/',';',$matches[$altqty][$altqtykey],1);
                    if (substr_count($matches[$altqty][$altqtykey], ";", 0) > 0) { //we most likely have prepreps hidden in our alt quantity
                        unset($pparray);
                        $pparray = explode(",",end(explode(";", str_replace(']','',$matches[$altqty][$altqtykey])))); // This will create an array with all of the prepreparation methods separated by a comma after the ;.
                        foreach ($pparray as $pkey => $value) {
                            $value=trim($value);
                            if (isset(${'pp1'.$key})) {
                                 if (isset(${'pp2'.$key})) {
                                      ${'pp2'.$key} .= ' '.$value;
                                 } else {
                                     ${'pp2'.$key} = $value;
                                 }
                            } else {
                                ${'pp1'.$key}=$value;
                            }
                        }
                    }
                    $aqty=current(explode(";",substr($matches[$altqty][$altqtykey],1)));
                    $aqty=str_replace(']','',$aqty);
                    $findfirst = array();
                    foreach ($mwunitarray as $qvalue) {
                          if (stripos($aqty,$qvalue[0])!==false) {
                             $endpos=stripos($aqty,$qvalue[0])+strlen($qvalue[0]); 
                             array_push($findfirst,$endpos);
                          }
                     }
                     $bqty=explode(" ",current(explode(";",substr($matches[$altqty][$altqtykey],1))));
                     $bqty=str_replace(']','',$bqty);
                     foreach ($bqty as $word) {
                          if ($word=='t' || $word=='T') {
                             $wkey = array_search($word,$unitarray); 
                          } else {
                            $wkey = array_search(strtolower($word),$unitarray);
                          }
                          if ($wkey) {
                             $endpos=stripos($aqty,$word)+strlen($word)-1; 
                             array_push($findfirst,$endpos);
                          }
                     }
                     if (!isset($findfirst[0])) {
                          foreach ($unitarray as $qvalue) {
                              if (stripos($aqty,$qvalue[0])!==false) {
                                 $endpos=stripos($aqty,$qvalue[0])+strlen($qvalue[0]); 
                                 array_push($findfirst,$endpos);
                                 break;
                              }
                         }
                     }
                    sort($findfirst);
                    $extraqty=substr($aqty,$findfirst[0]+1);
                    if ($extraqty!=FALSE) {
                        $extraqtymsg="eqty ".$extraqty;
                        unset($extraqty);
                    }
                    $aqty=substr($aqty,0,$findfirst[0]+1);  
                    $matcha = extract_numbers($aqty);
                    $ct=-1;
                    if (count($matcha)>1) {  //we may have a fraction in the quantity
                        if (strchr($matches[$altqty][$altqtykey],'/')>-1) { //even more likely that we have a fraction
                            for ($i = 0; $i < 3; $i++)  {  //find position the first 3 numbers only as that's the max mixed numbers can have
                                if ($i==0) {
                                    $posnuma[$i]=strpos($matches[$altqty][$altqtykey],$matcha[$i]);
                                } else {
                                    $posnuma[$i]=strpos($matches[$altqty][$altqtykey],$matcha[$i],$posnuma[$ct]+1);
                                }
                                $ct++;
                            }
                            
                        }
                        if (count($matcha)>2) { //the qty is a mixed number
                            ${'eqty'.$key}=substr($matches[$altqty][$altqtykey] ,$posnuma[0],$posnuma[2]+strlen($matcha[2])-1); //extract the qty to the end pos of the mixed number
                        } else if (count($matcha)>1) {  //the qty is a fraction
                            ${'eqty'.$key}=substr($matches[$altqty][$altqtykey] ,$posnuma[0],$posnuma[1]+ strlen($matcha[1])-1); //extract the qty to the end pos of the fraction
                        }
                    }  else {                                       
                            ${'eqty'.$key}=$matcha[0] ;  //the qty is a number, so we just use that
                    }
                    ${eunit.$key}=trim(str_replace('[','',str_replace(']','',str_replace(${'eqty'.$key},'',$aqty)))); //remove quantity from the alt quantity to leave the unit
                    $matches[$altqty][$altqtykey] =str_replace(';',',',$matches[$altqty]);
                    $line=str_replace($matches[$altqty][$altqtykey] ,'',$line); //remove the alt quantity from the ingredient
                    
               }
               
               //change the first comma with a semicolon so we can find the beginning of any prepreps 
               $line = preg_replace('/,/',';',$line,1);
               $ingpart = current(explode(";",$line)); // This will the part of the ingredient before any comma. Text after comma is assumed to be prepreps.
               unset($posnum);
               unset($trunc);
               $dash=strpos($ingpart,'-');
               $to=strpos($ingpart,' to ');
               if ( $dash>0 || $to>0) { //we may have a range in the quantity
                    if ($dash>0) {
                          $trunc=substr($ingpart,0,$dash);
                    } else {
                        $trunc=substr($ingpart,0,$to);
                    }
                }
                if (isset($trunc)) {
                    $match = extract_numbers($trunc); //extract any number in ingredient up to any dash to find the first quantity
                    //extract any number in ingredient after any dash and get rid of it
                    if ($dash>0) {
                        $match_after =  extract_numbers(substr($ingpart,$dash+1));
                    } else {
                        $match_after =  extract_numbers(substr($ingpart,$to+1));
                    }
                    $last=$match_after[count($match_after)-1];
                    $lastpos=strpos($ingpart,$last);
                    $ingpart=$trunc.substr($ingpart,$lastpos+strlen($last));
                } else {
                    $match = extract_numbers($ingpart); //extract any number in ingredient
                }
               if (isset($match)and $match[0]) {  //we have a qty
                    $ct=-1;
                    if (count($match)>1) {  //we may have a fraction in the quantity
                        if (strchr($ingpart,'/')>-1) { //we definitely have a fraction
                            for ($i = 0; $i < 3; $i++)  {  //find position the first 3 numbers only as that's the max mixed numbers can have
                                if ($i==0) {
                                    $posnum[$i]=strpos($ingpart,$match[$i]);
                                } else {
                                    $posnum[$i]=strpos($ingpart,$match[$i],$posnum[$ct]+1);
                                }
                                $ct++;
                            }
                            
                            if (count($match)>2) { //the qty is a mixed number
                                ${'qty'.$key}=substr($ingpart,$posnum[0],$posnum[2]+strlen($match[2])); //extract the qty to the end pos of the mixed number
                            } else if (count($match)>1) {  //the qty is a fraction
                                ${'qty'.$key}=substr($ingpart,$posnum[0],$posnum[1]+ strlen($match[1])); //extract the qty to the end pos of the fraction
                            }
                        } else { // there's multiple numbers in the quantity we can only use the first
                            for ($i = 1; $i< count($match); $i++)  {  //find position the first 3 numbers only as that's the max mixed numbers can have
                                if ($i==0) {
                                    $extraqtymsg="QTY1 ".$match[$i];
                                } else {
                                    $extraqtymsg .=" ".$match[$i];
                                }
                                $ingpart=trim(str_replace($match[$i],'',$ingpart));
                                $ct++;
                            }
                            ${'qty'.$key}= $match[0];
                            //there may be an extra unit as well
                            $findunits = array();
                            //look for multi word units
                            foreach ($mwunitarray as $uvalue) {
                                  if (stripos($ingpart,$uvalue[0])!==false) {
                                      ${'unit'.$key}=$uvalue[0];
                                      array_push($findunits,$uvalue[0]);
                                      $ingpart=str_ireplace($uvalue[0],'',$ingpart);
                                      break;
                                  }
                            }
                            //look for other units
                             $ingarrayeu = explode(" ",trim($ingpart)); // This will create an array of ingredient details remaining
                             if (sizeof($ingarrayeu) > 1) {
                                foreach ($ingarrayeu as $wkey => $word) {
                                   foreach ($unitarray as $uvalue) {
                                      if (strtolower($word)==$uvalue[0]) {
                                         array_push($findunits,$word);
                                      }
                                   }
                                }
                            }
                            if (count($findunits)>1) {
                                 $extraqtymsg .= $findunits[0];
                                 $ingpart=str_ireplace($findunits[0],'',$ingpart);
                            }
                        }
                        
                    }  else {
                            ${'qty'.$key}=$match[0];  //the qty is a number, so we just use that
                    }
                    $ingpart=trim(str_replace(${'qty'.$key},'',$ingpart)); //remove the quantity from the ingredient
                }
                $findmunits = array();
                foreach ($mwunitarray as $uvalue) {
                      if (stripos($ingpart,$uvalue[0])!==false) {
                          ${'unit'.$key}=$uvalue[0];
                          array_push($findmunits,$uvalue[0]);
                          $ingpart=str_ireplace($uvalue[0],'',$ingpart);
                          break;
                      }
                 }
                 $ingarrayp = explode(" ",trim($ingpart)); // This will create an array of ingredient details remaining
                 if (sizeof($ingarrayp) > 1) {
                     if (!isset(${'unit'.$key})){
                         $findmunits = array();
                         foreach ($ingarrayp as $wkey => $word) {
                              foreach ($unitarray as $uvalue) {
                                  if (strtolower($word)==$uvalue[0]) {
                                     array_push($findmunits,$word);
                                     unset($ingarrayp[$wkey]);
                                  }
                             }
                         }
                     }
                     if (count($findmunits)>1) {
                             ${'unit'.$key}= $findmunits[0];
                             if(isset($extraqtymsg)) {
                                $extraqtymsg .= $findmunits[1]; 
                             } else {
                                $extraqtymsg = $findmunits[1];
                             }
                     }  else {
                          ${'unit'.$key}= $findmunits[0];
                     }
                     foreach ($ingarrayp as $wlkey =>  $wordsleft) {
                         if(isset(${'ing'.$key})) {
                            ${'ing'.$key} .=   $wordsleft.' '; 
                         } else {
                            ${'ing'.$key} =   $wordsleft.' '; 
                         }
                         
                     }
                     $storeing[$key]=trim(${'ing'.$key});
                 
                }  else {
                    $storeing[$key] = $ingarrayp[0];
                }
            
                if (substr_count($line, ";", 0) > 0 || isset($extraqtymsg)) { //we have prepreps
                    unset($pparray);
                    $preprepsplit=explode(";", $line);
                    $prepreps=end($preprepsplit); //prepreps part og ingredients
                    $prepreps=str_replace(" and ",",",$prepreps); //change and to comma
                    if (substr_count($line, ";", 0) > 0)  {
                        $pparray = explode(",",$prepreps); // This will create an array with all of the prepreparation methods separated by a comma after the ;.
                    }
                    if (isset($extraqtymsg)) {
                        $pparray[]=$extraqtymsg;
                        unset($extraqtymsg);
                    }
                    
                    foreach ($pparray as $pkey => $value) {
                        $value=trim($value);
                        if (isset(${'pp1'.$key})) {
                             if (isset(${'pp2'.$key})) {
                                  ${'pp2'.$key} .= ' '.$value;
                             } else {
                                 ${'pp2'.$key} = $value;
                             }
                         } else {
                            ${'pp1'.$key}=$value;
                         } 
                    }
                }
            }
        }
    }
    $count = count($text);
    $var="ingredient";
    $inglist='';
    for ($i = 0; $i < $count; $i++) {
        $val=$storeing[$i];
        require('updateslings.php');
        $inglist .= "$rid,";
    }
    $inglist=substr($inglist,0,strlen($inglist)-1);
    $sql = "select get_ing_aisle(ingredient,$uid) as aisle, get_ing_aisle_order(ingredient,$uid) as aisle_order, get_ingredient(ingredient) as ingredient from ingredient_owner where ingredient in($inglist) and owner=$uid ORDER BY aisle_order, aisle,ingredient";
    $sql = $rdb->prepare($sql);
    $sql->execute();
    $err=$rdb->errorInfo();
    $arows = $sql->rowCount();
    $asql = $sql->fetchAll(PDO::FETCH_BOTH);
    $sql->closeCursor();
    
    for ($i = 0; $i < $arows; $i++) {
        $aisle = $asql[$i][0];
        $aisle_order = $asql[$i][1];
        $ingname = $asql[$i][2];
        for ($j = 0; $j < $count; $j++) {
            $val=$storeing[$j];
            if($val==$ingname) {
                $item= $text[$j];
                break;
            }    
        }
        $ings[] = array( 'item' => $item, 'ing' => $ingname, 'aisle' => $aisle, 'aisle_order' => $aisle_order);
    }
    
    
    $response['ings'] = $ings;
    echo json_encode($response);
?>