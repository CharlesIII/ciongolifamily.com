String.prototype.splice = function( idx, rem, s ) {
    return (this.slice(0,idx) + s + this.slice(idx + Math.abs(rem)));
};
function cbuttonval(v) {
   document.form1.cbut_val.value=v;
}
function frac2dec(fraction) {
    /* assumes fraction is in the form 1-1/2 or 1 1/2 */
    /* doesn't work on negative numbers */
    var fractionParts = fraction.split('-');
    if (fractionParts.length === 1) {
        /* try space as divider */
        fractionParts = fraction.split(' ');
    }
    if (fractionParts.length > 1 && fraction.indexOf('/') !== -1) {
        var integer = parseInt(fractionParts[0]);
        var decimalParts = fractionParts[1].split('/');
        var decimal = parseInt(decimalParts[0]) / parseInt(decimalParts[1]);
        return integer + decimal;
    } else if (fraction.indexOf('/') !== -1) {
        var decimalParts = fraction.split('/');
        var decimal = parseInt(decimalParts[0]) / parseInt(decimalParts[1]);
        return decimal;
    } else {
        return parseInt(fraction);
    }
}
function fraction(decimal,roundTo) {
    var whole = String(decimal).split('.')[0];
    decimal = parseFloat("." + String(decimal).split('.')[1]);
    var num = "1";
    for (var z=0; z<String(decimal).length-2; z++){
        num += "0";
    }
    decimal = parseInt(decimal*num);
    num = parseInt(num);
    for (z=2; z<decimal+1; z++) {
        if (decimal%z==0 && num%z==0) {
            decimal = decimal/z;
            num = num/z;
            z = 2;
        }
    }
    var result = ((whole==0)?"" : whole+" ") + decimal + "/" + num;
    var d = num/roundTo;
    var n = Math.round(decimal/d);

    var HCF = 1;
    for (z=1; z<100; z++){
        if (n%z == 0 && roundTo%z == 0) {
            HCF = z;
        }
    }
    var simplified = (n/HCF +'/'+ roundTo/HCF);
    if (simplified == "1/1") {
        simplified = "";
        whole ++;
    } else if (simplified == "0/1") {
        simplified = "";
    }
    if (whole>0) {
        simplified=whole + ' ' + simplified;
    }
    return simplified.trim();
}
function checkLen(){
   var maxLen=300;
   if (document.getElementById("message").value.length+1 > maxLen) {
      var info = "A maximum of " + maxLen + " characters is allowed";
      new Messi(info, {
         title: 'Character Limit Reached',
         width: '350px'
      });
      document.getElementById("message").value=document.getElementById("message").value.slice(0,maxLen-1);
   }
}
function clearrecipe() {
        $('#demolinks').hide();
        $('#fblink').hide();
        $('#commentlink').hide();
        $('#revertmsg').hide();
        $('#convertmsg').hide();    
        $('#title').hide();
        $('#rnum').html('');
        $('.imagedisp').html("<br><a href='#' id=hideimg>Hide images</a><br><br><input type=hidden name='image0' value=''>");
        $('.image1').hide()
        $('#ingdisp').html('').hide();
        $('#video').html('').hide();
        $('#note').hide();
        $('#directions').hide();
        $('#pdf').html("<br><a href='#' class=hidepdf>Hide PDF Image</a><br><span style='display:none' id=showpdf><a href='#' >Show PDF Image</a></span><img class=pdf src=''><br><a href='#' class=hidepdf>Hide PDF Image</a><br><br><span><strong>Link to Original PDF Document:</strong><a href='' target=_BLANK></a></span><br><input type=hidden name='pdf' value=''><br>").hide();
        $('#yielddiv').hide();
        $('#measure').hide();
        $('#tried').hide();
        $('#preptime').hide();
        $('#cooktime').hide();
        $('#cuisine').hide();
        $('#diet').html('').hide();
        $('#cat').html('').hide();
        $('#source').hide();
        $('#addedby').hide();
        $('#added').hide();
        $('#updated').hide();
        $("[id^=image]").html('<br><br>').hide();
        $('#rrecipe').html("<hr><br><input type=hidden name='related' id=related value=''><h3><strong></strong></h3>").hide();
        $('.new').remove();
        $('.hasval').val('').removeClass('hasval');
        $('#currentcomments').html('<hr class="nofs noprint"><h3 class="nofs">Comments</h3><span id="ccnum"></span><br class="noprint"><br class="noprint"><div id="newcom"></div>').hide();
        $('#comments').hide();
}
function loadrelated(relid,r,rrrows) {
    var inData = "";
    var ct = 0;

    function appGET(data, str) {
        if (data && data != 'undefined') {
            data = encodeURIComponent(html_entity_decode(data));
            if (ct == 0) {
                inData += str + '=' + data;
            } else {
                inData += '&' + str + '=' + data;
            }
            ct++;
        }
    }
    appGET($('#other').val(), 'ing');
    appGET($('#seldate').val(), 'seldate');
    appGET(relid, 'relid');
    $.post("includes/ajaxgetrelated.php", inData, function(data) {
        if(data=="nodb"){
            $(".message_box").removeClass('ok');
            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
            return false;
        }
        data = JSON.parse(data);
        var rname = data.recipe[1].rname;
        var rdirections=data.recipe[1].rdirections;
        var rnote = data.recipe[1].rnote;
        var ryield = data.recipe[1].ryield;
        var ryield_unit = data.recipe[1].ryield_unit;            
        
        if(data.ings) {
            var irows = data.ings.length;
        }
        $('#rrecipe').append("<br class=noprint><h3>"+rname+"</h3><br><br>");
        
        if(irows) {
            var ihtml='<div class=ringdisp><strong class=rheader>Ingredients</strong><br><br><table class=ringtable>';    
            for (i in data.ings) {
                var rquantity = data.ings[i].quantity;
                var rqtydec=data.ings[i].qtydec;
                var runit = data.ings[i].unit;
                var rquantity2 = data.ings[i].quantity2;
                var reunit = data.ings[i].eunit;
                var ring = data.ings[i].ing;
                var rpp = data.ings[i].pp;
                var rpp1 = data.ings[i].pp1;
                ihtml +='<tr>'
                if (rquantity) {
                    if(runit) {
                        ihtml += '<td class=ingqty><span id=srqty'+i+'rr'+r+'>'+rquantity+'</span></td><td>'+runit;
                        ihtml += '<input type="hidden" value="'+rquantity+'" id=oldsrqty'+i+'rr'+r+'>';
                    } else {
                        ihtml += '<td class=ingqty><span id=srqty'+i+'rr'+r+'>'+rquantity+'</span></td><td>';
                        ihtml += '<input type="hidden" value="'+rquantity+'" id=oldsrqty'+i+'rr'+r+'>';
                    }
                } else {
                    ihtml += '<td></td><td>';
                }
                if (rquantity2 && reunit) {
                        ihtml += '(<span id=sreqty'+i+'rr'+r+'>'+rquantity2+'</span> '+reunit+')';
                        ihtml += '<input type="hidden" value="'+rquantity+'" id=oldsreqty'+i+'rr'+r+'>';
                } else if (rquantity2) {
                        ihtml += '(<span id=sreqty'+i+'rr'+r+'>'+rquantity2+'</span>)';
                        ihtml += '<input type="hidden" value="'+rquantity+'" id=oldsreqty'+i+'rr'+r+'>';
                } else if (reunit) {
                        ihtml += '('+reunit+')';
                }
                ihtml += '</td><td>';
                if (ring) {
                    ring = ring.replace("''","'");
                    ihtml += ' '+ring;
                }
                if (rpp) {
                        ihtml += ', '+rpp;
                }
                if (rpp1) {
                        ihtml += ', '+rpp1;
                }
                ihtml += '</td></tr>';
            }
            if(ryield) {
                ihtml += '<input type="hidden" value="'+ryield+'" class=ryspan>';
            }
            ihtml += '</table><br>';
            $('#rrecipe').append(ihtml);
        }
        $('#rrecipe').append('<br>');
        
        if(rnote) {
            $('#rrecipe').append('<strong class=rheader>Notes</strong><br><br>'+rnote+'<br><br>');
        }       
        if(rdirections) {
            $('#rrecipe').append('<strong class=rheader>Directions</strong><br><br>'+rdirections + '<br><br>').show();
        }
        if (ryield && ryield!="") {
            if(ryield_unit) {
                $('#rrecipe').append('<br><br><strong>Makes: </strong> <span id=yield'+r+'>'+ryield+'</span> '+ryield_unit);
            } else {
                $('#rrecipe').append('"<br><br><strong>Makes: </strong> '+ryield);
            }
        }
        rrecnum=parseInt(r)+1;
        if(rrecnum<rrrows) {
            $('#rrecipe').append("<br><hr>");
        }
                                    
    });
}
function loadrecipe(id,rowner) {
    if(!$('#unapproved').val()) {
        $('#demolinks').show();
        $('#fblink').show();
        $('#commentlink').show();
    }   
    $("input[name='id']").val(id).addClass('hasval');
    if(rowner) {
        $("input[name='rowner']").val(rowner).addClass('hasval');
    }
    
    var inData = "";
    var ct = 0;

    function appGET(data, str) {
        if (data && data != 'undefined') {
            data = encodeURIComponent(html_entity_decode(data));
            if (ct == 0) {
                inData += str + '=' + data;
            } else {
                inData += '&' + str + '=' + data;
            }
            ct++;
        }
    }
    appGET($('#other').val(), 'ing');
    appGET($('#seldate').val(), 'seldate');
    appGET(id, 'id');
    
    $.post("includes/ajaxgetrecipe.php", inData, function(data) {
        if(data=="nodb"){
            $(".message_box").removeClass('ok');
            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
            return false;
        }
            data = JSON.parse(data);
            var name = data.recipe[1].name;
            var directions=data.recipe[1].directions;
            var note = data.recipe[1].note;
            var source = data.recipe[1].source;
            var cuisine = data.recipe[1].cuisine;
            var rating = data.recipe[1].rating;
            var updated = data.recipe[1].updated;
            var udate = data.recipe[1].udate;
            var yield = data.recipe[1].yield;
            var tried = data.recipe[1].tried;
            var preptime = data.recipe[1].preptime;
            var yield_unit = data.recipe[1].yield_unit;
            var measure = data.recipe[1].measure;            
            var added = data.recipe[1].added;
            var adate = data.recipe[1].adate;
            var total_ratings = data.recipe[1].total_ratings;
            var addedby = data.recipe[1].addedby;
            var cooktime = data.recipe[1].cooktime;
            var video = data.recipe[1].video;
            var pdf = data.recipe[1].pdf;
            var rel = data.recipe[1].related;
            
            if(data.imgs) {
                var imgrows = data.imgs.length;
            }
            if(data.ings) {
                var irows = data.ings.length;
            }                       
            if(data.diets) {
                var drows = data.diets.length;
            }
            if(data.related) {
                var rrrows = data.related.length;
            }
            if(data.cats) {
                var srows = data.cats.length;
            }
            if(data.comments) {
                var crows = data.comments.length;
            }
            
            $('#title h3').html(name);
            $("input[name='name']").val(name).addClass('hasval');
            if(total_ratings>0) {
                if(total_ratings==1) {
                    $('#rnum').html(' Rated by 1 person');
                } else {
                    $('#rnum').html(' Rated by ' + $total_ratings +' people');
                }
            }
            if(rating>0) {
                $("input[name='rating']").val(rating).addClass('hasval');
                var rating = parseInt(rating)-1;
                $('.star:first').rating('select',rating);   
            } else {
                $('.rating-cancel').click();
            } 
            $('#title').show();
            
            if (imgrows) {
                if(imgrows>1) {
                    var imghtml = '<div class="galleria">';
                    for (i in data.imgs) {
                        var image=data.imgs[i].image;
                        if (i==0) {
                            $("input[name='image" +i+"']").val(image).addClass('hasval');
                        } else {
                            $('.imagedisp').append("<input type=hidden name='image"+i+"' value='"+image+"'>");
                        }
                        imghtml += '<img src="images/recipe/' + image + '">';
                    }
                    imghtml += '</div>';
                    $('.imagedisp').prepend(imghtml);
                    $('.imagedisp').show();
                    Galleria.loadTheme('galleria/themes/classic/galleria.classic.min.js');
                    Galleria.run('.galleria', {
                        imagePosition: 'top left'
                    });
                    Galleria.on('loadfinish', function(e) {
                        var width=e.imageTarget.width; // the currently active IMG element
                        var height=parseInt(e.imageTarget.height) + 44;
                        $('.galleria').attr('style','width:'+width+'px !important;height:'+height+'px !important;')
                        $('.galleria-container').attr('style','width:'+width+'px !important;height:'+height+'px !important;')
                    });
                    //var imgwidth=$(".galleria-image").width();
                    //var imgheight=$(".galleria-image").height();

                }  else {
                    var image=data.imgs[0].image;
                    $("input[name='image0']").val(image).addClass('hasval');
                    var imghtml = '<img src="images/recipe/' + image + '">';
                    $('.imagedisp').prepend(imghtml);
                    $('.imagedisp').show();
                }
            }
            
            if(irows) {
                var ihtml='<strong class=rheader>Ingredients</strong><br><br><table id=ingtable>';    
                for (i in data.ings) {
                    var quantity = data.ings[i].quantity;
                    var qtydec=data.ings[i].qtydec;
                    var unit = data.ings[i].unit;
                    var quantity2 = data.ings[i].quantity2;
                    var eunit = data.ings[i].eunit;
                    var ing = data.ings[i].ing;
                    var pp = data.ings[i].pp;
                    var pp1 = data.ings[i].pp1;
                    ihtml +='<tr>'
                    if (quantity) {
                        quantity=quantity.trim();
                        if(unit) {
                            ihtml += '<td class=ingqty><span id=sqty'+i+'>'+quantity+'</span></td><td><kbd id=sunit'+i+'>'+unit+'</kbd>';
                            ihtml += '<input type=hidden name = qty'+i+' value="'+quantity+'">';
                            ihtml += '<input type=hidden name = unit'+i+' value="'+unit+'">';
                            ihtml += '<input type=hidden name = oldqty'+i+' value="'+quantity+'">';
                            ihtml += '<input type=hidden name = oldunit'+i+' value="'+unit+'">';
                        } else {
                            ihtml += '<td class=ingqty><span id=sqty'+i+'>'+quantity+'</span></td><td>';
                            ihtml += '<input type=hidden name = qty'+i+' value="'+quantity+'">';
                            ihtml += '<input type=hidden name = oldqty'+i+' value="'+quantity+'">';
                        }
                    }  else {
                        ihtml +='<td></td><td>'
                    }
                    if (quantity2 && eunit) {
                        quantity2=quantity2.trim();
                        ihtml += '(<span id=seqty'+i+'>'+quantity2+'</span> <kbd id=seunit'+i+'>'+eunit+'</kbd>)';
                        ihtml += '<input type=hidden name = eqty'+i+' value="'+quantity2+'">';
                        ihtml += '<input type=hidden name = eunit'+i+' value="'+eunit+'">';
                        ihtml += '<input type=hidden name = oldeqty'+i+' value="'+quantity2+'">';
                        ihtml += '<input type=hidden name = oldeunit'+i+' value="'+eunit+'">';
                    } else if (quantity2) {
                            quantity2=quantity2.trim();
                            ihtml += '(<span id=seqty'+i+'>'+quantity2+'</span>)';
                            ihtml += '<input type=hidden name = eqty'+i+' value="'+quantity2+'">';
                            ihtml += '<input type=hidden name = oldeqty'+i+' value="'+quantity2+'">';
                    } else if (eunit) {
                            ihtml += '(<kbd id=seunit'+i+'>'+eunit+'</kbd>)';
                            ihtml += '<input type=hidden name = eunit'+i+' value="'+eunit+'">';
                            ihtml += '<input type=hidden name = oldeunit'+i+' value="'+eunit+'">';
                    }
                    ihtml += '</td><td>';
                    if (ing) {
                        ing = ing.replace("''","'");
                        ihtml += ' '+ing;
                        ihtml += '<input type=hidden name = ing'+i+' value="'+ing+'">';
                    }
                    if (pp) {
                            ihtml += ', '+pp;
                            ihtml += '<input type=hidden name = pp1'+i+' value="'+pp+'">';
                    }
                    if (pp1) {
                            ihtml += ', '+pp1;
                            ihtml += '<input type=hidden name = pp2'+i+' value="'+pp1+'">';
                    }
                    ihtml += '</td></tr>';
                }
                ihtml += '</table><br>';
                $('#ingdisp').html(ihtml).show();
            }
            if (video) {
                var vhtml='';
                var vidfmt= video.split('.').pop();
                vhtml += '<br class=embedstuff>';
                vhtml += '<a href="#" class="hidevid embedstuff">Hide Video</a><br>';
                vhtml += '<span style="display:none" id=showvid><a href="#" >Show Video</a></span>';
                vhtml += '<div class="embed-container"><br>';
                if (vidfmt=='flv') {
                    vhtml += '<object data="mediaplayer.swf?file=images%2Frecipe%2F'+video+'" type="application/x-shockwave-flash">';
                    vhtml += '<param value="mediaplayer.swf?file=images%2Frecipe%2F'+video+'" name="src">';
                    vhtml += '<param value="#ffffff" name="bgColor">';
                    vhtml += '<param value="transparent" name="wmode">';
                    vhtml += '<param value="false" name="autoplay">';
                    vhtml += '<param value="file=images%2Frecipe%2F'+video+'" name="flashvars">';
                    vhtml += '<div class=nophone>';
                    vhtml += '<p><strong>Flash Required</strong></p>';                        
                    vhtml += '<p>Flash is required to view this media.<a href="http://www.adobe.com/go/getflashplayer">Download Here</a></p>';
                    vhtml += '</div>';
                    vhtml += '</object>';
                } else if (vidfmt=='mp4' || vidfmt=='ogv' || vidfmt=='webm') {
                    if (vidfmt=='ogv') {vidfmt='ogg';}
                    vhtml += '<video controls>';
                    vhtml += '<source src="images/recipe/'+video+'"  type="video/'+vidfmt+'" />';
                    vhtml += '<object type="application/x-shockwave-flash" data="mediaplayer.swf">';
                    vhtml += '<param name="movie" value="mediaplayer.swf" />';
                    vhtml += '<param name="flashvars" value="controlbar=over&amp;<!--image=__POSTER__.JPG&amp-->;file=images/recipe/'+video+'" />';
                    vhtml += '</object>';
                    vhtml += '</video>';
                }
                vhtml += '</div><br class=embedstuff><a href="#" class="hidevid embedstuff">Hide Video</a><br class=embedstuff><br class=embedstuff>';
                vhtml += "<input type=hidden name='video' value='"+video+"'>";
                $('#video').html(vhtml).show();
            }
            if(note) {
                //note=note.replace(/(\r\n|\n|\r)/gm,"");
                $('#note').append('<div class=new>' + note + '<br><br></div').show();
                $("input[name='note']").val(note).addClass('hasval');
            }
            if(directions) {
                //directions=directions.replace(/(\r\n|\n|\r)/gm,"");
                $('#directions').append('<div class=new>' + directions + '<br><br><hr class=nofs></div>').show();
                $("input[name='directions']").val(directions).addClass('hasval');
            }
            if (pdf) {
                    var withoutExt = pdf.substr(0, pdf.lastIndexOf('.'));
                    var pdfname = pdf.split(/-(.+)?/)[1];
                    var pdfjpg = withoutExt+'.jpg';
                    $('#pdf img').attr('src','images/recipe/'+pdfjpg);
                    $("input[name='pdf']").val(pdfjpg).addClass('hasval');;
                    $('#pdf a:last').attr('href','images/recipe/'+pdf).html(" "+pdfname);
                    $('#pdf').show();
            }
            if (yield && yield!="") {
                if(yield_unit) {
                    $('#yielddiv').append('<div class=new> <span id=yspan>'+yield+'</span> '+yield_unit+"<br><input type=hidden name='yield_unit' value='"+yield_unit+"'></div>").show();
                    $("input[name='yield']").val(yield).addClass('hasval');
                    $("input[name='oldyield']").val(yield).addClass('hasval');
                } else {
                    $('#yielddiv').append('<div class=new> <span id=yspan>'+yield+'</span></div>').show();
                    $("input[name='yield']").val(yield).addClass('hasval');
                    $("input[name='oldyield']").val(yield).addClass('hasval');
                }
            }
            if (measure) {
                $('#measure strong').after(' <div class=new>'+measure+' </div>');
                $("input[name='measure']").val(measure).addClass('hasval');
                $("input[name='oldmeasure']").val(measure);
                $('#measure').show();
            }
            if (tried=='t' || tried==1) {
                    var tried = "Yes";
            } else {
                    var tried = "No";
            }
            $('#tried').append('<div class=new> '+tried+'</div>').show();
            $("input[name='tried']").val(tried).addClass('hasval');
            if (preptime) {
                    $('#preptime').append('<div class=new> '+preptime+'</div>').show();
                    $("input[name='preptime']").val(preptime).addClass('hasval');
            }                           
            if (cooktime) {
                    $('#cooktime').append('<div class=new> '+cooktime+'</div>').show();
                    $("input[name='cooktime']").val(cooktime).addClass('hasval');
            }
            
            if (cuisine) {
                    $('#cuisine').append('<div class=new> '+cuisine+'</div>').show();
                    $("input[name='cuisine']").val(cuisine).addClass('hasval');
            }
            if(drows) {
                var dhtml='';    
                for (i in data.diets) {
                    var diet = data.diets[i].diet;
                    if (i > 0) {
                            dhtml += ', '+diet;
                    } else {
                           dhtml += '<strong>Diet:</strong> '+diet;
                    }
                    dhtml += '<input type=hidden name = diet[] value="'+diet+'">';
                }
                $('#diet').append(dhtml).show();
            }
            if(srows) {
                chtml="";
                for (i in data.cats) {
                    var cat = data.cats[i].cat;
                    var subcat = data.cats[i].subcat;
                    if (i > 0) {
                            if (subcat) {
                                    chtml += ', <span id=c' +i+ '>' +cat+': '+subcat+ '</span>';
                            } else {
                                    chtml += ', <span id=c' +i+ '>' +cat+ '</span>';
                            }
                    } else {
                            if (subcat) {
                                    chtml += '<strong>Recipe Types & Categories:</strong> <span id=c' +i+ '>' +cat+': '+subcat+ '</span>';
                            } else {
                                    chtml += '<strong>Recipe Types:</strong> <span id=c' +i+ '>' +cat+ '</span>';
                            }
                    }
                    if (cat) {
                            chtml += '<input type=hidden name = cat'+i+' value="'+cat+'">';
                    }
                    if (subcat) {
                            chtml += '<input type=hidden name = scat'+i+' value="'+subcat+'">';
                    }
                }
                $('#cat').append(chtml).show();
            }
            if (source) {
                if (source.substr(0,4)=='http') {
                    var shtml = "<div class=new> <a href='" + source + "' target=_BLANK>"+source+"</a></div>";
                } else {
                    var shtml = "<div class=new> "+source+'</div>';
                }
                $('#source').append(shtml).show();
                $("input[name='source']").val(source).addClass('hasval');
            }
            //var seldate=$('#seldate').val();
            if (addedby) {
                $('#addedby').append('<div class=new> '+addedby+'</div>').show();
                $("input[name='addedby']").val(addedby).addClass('hasval');
            }
            if (added) {
                    $('#added').append('<div class=new> '+adate+'</div>').show();
                    $("input[name='added']").val(added).addClass('hasval');
            }
            if (updated) {
                    $('#updated').append('<div class=new> '+udate+'</div>').show();
            }
            /*if(imgrows)  {
                  var extraimages=parseInt(imgrows)-1;
                  if (extraimages>0) {
                          for (i = 1; i < 4; i++) {
                                  if (i<=extraimages) {
                                    image[i]=data.imgs[i].image;
                                    $('#image2').append("<img src='images/recipe/"+image[i]+"'>");
                                    $('#image2').append("<input type=hidden name='image"+i+"' value='"+image[i]+"'>");
                                  }
                          }
                          $('#image2').show();
                  }
                  if (extraimages>3) {
                          for (i = 4; i < 7; i++) {
                                  if (i<=extraimages) {
                                    image[i]=data.imgs[i].image;
                                    $('#image3').append("<img src='images/recipe/"+image[i]+"'>");
                                    $('#image3').append("<input type=hidden name='image"+i+"' value='"+image[i]+"'>");
                                  }
                          }
                          $('#image3').show();
                  }
                  if (extraimages>6) {
                          for (i = 7; i < 10; i++) {
                                  if (i<=extraimages) {
                                    image[i]=data.imgs[i].image;
                                    $('#image4').append("<img src='images/recipe/"+image[i]+"'>");
                                    $('#image4').append("<input type=hidden name='image"+i+"' value='"+image[i]+"'>");
                                  }
                          }
                          $('#image4').show();
                  }
            }*/
            if (rrrows) {
                    $("input[name='related']").val(rel);
                    for (i = 0; i < rrrows; i++) {
                            var relid = data.related[i].relid;
                            var relname= data.related[i].relname;
                            
                            if (i == 0) {
                                if (rrrows==1) {
                                    $('#rrecipe h3').html("Related Recipe");
                                } else {
                                    $('#rrecipe h3').html("Related Recipes");
                                }
                            }
                            if (relname) {
                                    loadrelated(relid,i,rrrows);
                                    $('#rrecipe').append('<input type=hidden name = related_recipe[] value="'+relname+'">');
                            }
                    }
                    $('#rrecipe').show();
            }
            $('#comments').show();
            if(crows) {
                if (crows==1){
                    $('#ccnum').html('There is currently <span id=cnum>1</span> comment for this recipe');
                } else {
                    $('#ccnum').html('There are currently <span id=cnum>'+crows+'</span> comments for this recipe');
                }
        
                var rc=0;
                var cmthtml="";
                for (i = 0; i < crows; i++) {
                    rc++;
                    var commentid=data.comments[i].commentid;
                    var commentbb = data.comments[i].commentbb;
                    
                    //create the right date format
                    var commentDate = data.comments[i].commentDate;
                    if (rc>5) {
                        cmthtml += "<div style='display:none' class=commentbody id="+commentid+"><br class=noprint>";
                    } else {
                        cmthtml += "<div class=commentbody id="+commentid+"><br class=noprint>";
                    }
                    cmthtml += "<p>Comment: "+commentbb+"</p>";
                    if ($('#curruser').html()==data.comments[i].duser) {
                        cmthtml += "<img title='Delete Comment' class=commentdel src=images/extrasmall_delete.png><img title='Edit Comment' class=commentedit src=images/extrasmall_edit.png><br class=noprint><br class=noprint>";
                    }
                    cmthtml += "<p class=postedby>Posted by ";
                    var duser= data.comments[i].duser;
                    cmthtml += duser;
                    cmthtml += " on "+commentDate+"</p>";
                    cmthtml += "</div>";
                    
                }
                if (crows>5) {
                    cmthtml += "<a id=more href='#'>Show all comments</a><br class=noprint>";
                }
                $("#currentcomments").append(cmthtml);
                $("#currentcomments").show();
            }
    });
}
$(window).load(function () {
    var param = window.location.search.substring(1);
    var admin=$('#admin').val();
    var unapproved=$('#unapproved').val();
    var client=$('#client').val();
    if ($('#unapproved').val()) {
        if($('#toprhdr a').html()=='Welcome') {
            addrecipemenu();
        }
       $('#comments').hide();
       $('.appbuttons').show();
       if(!id){
           var id= $('#id').val()
       }
       if(id) {
           loadrecipe(id,null);    
       } else {
           $('#norecipes').show();
           $('.appbuttons').hide();
       }      
    } else if(param=='search=yes') {
        if($('#toprhdr a').html()=='Welcome') {
            addrecipemenu();
        }
        var id = $.cookie('rid');
        if(id) {
            var rowner = $.cookie('rowner');
            loadrecipe(id,rowner);    
        } else {
            $('#norecipes').show();
            $('#comments').hide();
        }
    } else {
        var welcome = $.cookie('welcome');
        if(welcome=='true') {
            $('#wscreen').show();
            $('#comments').hide();    
        } else {
            
            var id = $.cookie('rid');
            if(id && id!='notset') {
                if($('#toprhdr a').html()=='Welcome') {
                    addrecipemenu();
                }
                var rowner = $.cookie('rowner');
                loadrecipe(id,rowner);    
            } else {
                $('#norecipes').show();
                $('#comments').hide();
            }
            
        }
    }    
});
function addrecipemenu() {
    $.removeCookie('welcome', { path: '/' });
    $('#wscreen').hide();
    $('#toprhdr a').html('Recipe');
    $('#siderhdr a').html('Recipe<span class="sb-caret"></span>').addClass('sb-toggle-submenu');
    var myregion = $.cookie('region');
    var numfmt = $.cookie('numfmt');
    var fracdec = $.cookie('fracdec');
    var groroz = $.cookie('groroz');
        
    var thtml='<ul class=recopt>';
    if ($('#admin').val() && $('#unapproved').val()) {
        thtml += "<li><a href='#' class=approve>Approve</a></li>";
        thtml += "<li><a href='#' onclick=document.form1.action='add-recipe.php?edit=Edit';document.form1.submit()>Edit</a></li>";
        thtml += "<li><a href='#' class=delrecipe href='#'>Delete</a></li>";
        thtml += "<li><a href='display.php'>Display Approved Recipes</a></li>";
    } else {
        if($('#guest').val()) {
            thtml += "<li><a href='#' class=rsrecipe href='#'>Resize</a></li>";
            thtml += "<li><a href='#'>Convert</a>";
            thtml += "<ul>";
            if(numfmt=='notset' || fracdec=='notset' || myregion=='notset' || groroz=='notset') {
                thtml += "<li><a href='#'>You must set all preferences for recipe conversion before you can convert a recipe. You can do this at Account > Preferences</a></li>";
            } else {
                if (myregion!='Australia') {
                    thtml += "<li><a href='#' class=convertau>Australia to " + myregion + "</a></li>";
                }
                if (myregion!='Canada') {
                    thtml += "<li><a href='#' class=convertca>Canada to " + myregion + "</a></li>";
                }
                if (myregion!='Metric') {
                    thtml += "<li><a href='#' class=converteu>Metric to " + myregion + "</a></li>";
                }
                if (myregion!='New Zealand') {
                    thtml += "<li><a href='#' class=convertnz>New Zealand to " + myregion + "</a></li>";
                }
                if (myregion!='UK') {                      
                    thtml += "<li><a href='#' class=convertuk>UK to " + myregion + "</a></li>";
                }
                if (myregion!='USA') {
                    thtml += "<li><a href='#' class=convertus>USA to " + myregion + "</a></li>";
                }
            }
            thtml += "</ul>";
            thtml += "</li>";
            thtml += "<li><a href='#' onclick='window.print()'>Print</a></li>";
            thtml += "<li><a href='email.php'>Email</a></li>";
            thtml += "<li><a href='export.php?indv=yes'>Export</a></li>";
            thtml += "<li><a href='ebook.php?indv=yes'>Create eBook</a></li>"; 
            thtml += "<li><a href='#' class=fs>Fullscreen View</a></li>";
        } else {
            thtml += "<li><a href='#' class=delrecipe href='#'>Delete</a></li>";
            thtml += "<li><a href='#' class=editrecipe href='#'>Edit</a></li>";
            thtml += "<li><a href='#' class=rsrecipe href='#'>Resize</a></li>";
            thtml += "<li><a href='#'>Convert</a>";
            thtml += "<ul>";
            if(numfmt=='notset' || fracdec=='notset' || myregion=='notset' || groroz=='notset') {
                thtml += "<li><a href='#'>You must set all preferences for recipe conversion before you can convert a recipe. You can do this at Account > Preferences</a></li>";
            } else {
                if (myregion!='Australia') {
                    thtml += "<li><a href='#' class=convertau>Australia to " + myregion + "</a></li>";
                }
                if (myregion!='Canada') {
                    thtml += "<li><a href='#' class=convertca>Canada to " + myregion + "</a></li>";
                }
                if (myregion!='Metric') {
                    thtml += "<li><a href='#' class=converteu>Metric to " + myregion + "</a></li>";
                }
                if (myregion!='New Zealand') {
                    thtml += "<li><a href='#' class=convertnz>New Zealand to " + myregion + "</a></li>";
                }
                if (myregion!='UK') {                      
                    thtml += "<li><a href='#' class=convertuk>UK to " + myregion + "</a></li>";
                }
                if (myregion!='USA') {
                    thtml += "<li><a href='#' class=convertus>USA to " + myregion + "</a></li>";
                }
            }
            thtml += "</ul>";
            thtml += "</li>";
            thtml += "<li><a href='#' onclick=cbuttonval('Copy');document.form1.action='add-recipe.php';document.form1.submit()>Copy</a></li>";
            thtml += "<li><a href='#' onclick='window.print()'>Print</a></li>";
            thtml += "<li><a href='email.php'>Email</a></li>";
            thtml += "<li><a href='export.php?indv=yes'>Export</a></li>";
            thtml += "<li><a href='ebook.php?indv=yes'>Create eBook</a></li>"; 
            thtml += "<li><a href='#' class=addfav>Add to Favorites</a></li>";
            thtml += "<li><a href='#' class=delfav>Remove from Favorites</a></li>";
            thtml += "<li><a href='#' class=fs>Fullscreen View</a></li>";
        }
    }
    thtml += "</ul>";
    $('#toprhdr').append(thtml);
    var shtml = "<ul class='recopt sb-submenu'>";
    if ($('#admin').val() && $('#unapproved').val()) {
        shtml += "<li><a href='#' class=approve>Approve</a></li>";
        shtml += "<li><a href='#' onclick=document.form1.action='add-recipe.php?edit=Edit';document.form1.submit()>Edit</a></li>";
        shtml += "<li><a href='#' class=delrecipe >Delete</a></li>";
        shtml += "<li><a href='display.php'>Display Approved Recipes</a></li>";
    } else {
        if($('#guest').val()) {
            shtml += "<li><a href='#' class='rsrecipe'>Resize</a></li>";
            shtml += "<li><a class='sb-toggle-submenu' href='#'>Convert<span class='sb-caret'></a>";
            shtml += "<ul class='sb-submenu'>";
            if(numfmt=='notset' || fracdec=='notset' || myregion=='notset' || groroz=='notset') {
                shtml += "<li><a href='#'>You must set all the preferences for recipe conversion before you can convert a recipe. You can do this at Account > Preferences</a></li>";
            } else {
                if (myregion!='Australia') {
                    shtml += "<li><a href='#' class=convertau>Australia to " + myregion + "</a></li>";
                }
                if (myregion!='Canada') {
                    shtml += "<li><a href='#' class=convertca>Canada to " + myregion + "</a></li>";
                }
                if (myregion!='Metric') {
                    shtml += "<li><a href='#' class=converteu>Metric to " + myregion + "</a></li>";
                }
                if (myregion!='New Zealand') {
                    shtml += "<li><a href='#' class=convertnz>New Zealand to " + myregion + "</a></li>";
                }
                if (myregion!='UK') {
                    shtml += "<li><a href='#' class=convertuk>UK to " + myregion + "</a></li>";
                }
                if (myregion!='USA') {
                    shtml += "<li><a href='#' class=convertus>USA to " + myregion + "</a></li>";
                }
            }
            shtml += "</ul>";
            shtml += "</li>";
            shtml += "<li><a href='#' onclick='window.print()'>Print</a></li>";
            shtml += "<li><a href='email.php'>Email</a></li>";
            shtml += "<li><a href='export.php?indv=yes'>Export</a></li>";
            shtml += "<li><a href='ebook.php?indv=yes'>Create eBook</a></li>";
            shtml += "<li><a href='#' class='fs'>Fullscreen View</a></li>";
        } else {
            shtml += "<li><a href='#' class='delrecipe'>Delete</a></li>";
            shtml += "<li><a href='#' class='editrecipe'>Edit</a></li>";
            shtml += "<li><a href='#' class='rsrecipe'>Resize</a></li>";
            shtml += "<li><a class='sb-toggle-submenu' href='#'>Convert<span class='sb-caret'></a>";
            shtml += "<ul class='sb-submenu'>";
            if(numfmt=='notset' || fracdec=='notset' || myregion=='notset' || groroz=='notset') {
                shtml += "<li><a href='#'>You must set all the preferences for recipe conversion before you can convert a recipe. You can do this at Account > Preferences</a></li>";
            } else {
                if (myregion!='Australia') {
                    shtml += "<li><a href='#' class=convertau>Australia to " + myregion + "</a></li>";
                }
                if (myregion!='Canada') {
                    shtml += "<li><a href='#' class=convertca>Canada to " + myregion + "</a></li>";
                }
                if (myregion!='Metric') {
                    shtml += "<li><a href='#' class=converteu>Metric to " + myregion + "</a></li>";
                }
                if (myregion!='New Zealand') {
                    shtml += "<li><a href='#' class=convertnz>New Zealand to " + myregion + "</a></li>";
                }
                if (myregion!='UK') {
                    shtml += "<li><a href='#' class=convertuk>UK to " + myregion + "</a></li>";
                }
                if (myregion!='USA') {
                    shtml += "<li><a href='#' class=convertus>USA to " + myregion + "</a></li>";
                }
            }
            shtml += "</ul>";
            shtml += "</li>";
            shtml += "<li><a href='#' onclick=cbuttonval('Copy');document.form1.action='add-recipe.php';document.form1.submit()>Copy</a></li>";
            shtml += "<li><a href='#' onclick='window.print()'>Print</a></li>";
            shtml += "<li><a href='email.php'>Email</a></li>";
            shtml += "<li><a href='export.php?indv=yes'>Export</a></li>";
            shtml += "<li><a href='ebook.php?indv=yes'>Create eBook</a></li>";
            shtml += "<li><a href='#' class='addfav'>Add to Favorites</a></li>";
            shtml += "<li><a href='#' class='delfav'>Remove from Favorites</a></li>";
            shtml += "<li><a href='#' class='fs'>Fullscreen View</a></li>";

        }
    }
    shtml += "</ul>";
    $('#siderhdr').append(shtml);
}
function  updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps) {
    if (fracdec == 'fraction') {
        newqty=parseFloat(newqty);
        newqty=newqty.toFixed(3);
        if(newqty.toString().indexOf('.')!=-1) {
            newqty=fraction(newqty,8);
        }
        if(tbs) {
            if(tbs.toString().indexOf('.')!=-1) {
                if(myregion=='Australia') {
                   tbs=fraction(tbs,4); 
                } else {
                    tbs=fraction(tbs,3);
                }
            }
        }
        if (tsps) {
            if(tsps.toString().indexOf('.')!=-1) {
                tsps=fraction(tsps,8);
            }
        }
    } else {
        if (newunit=='g' && newqty>=1000) {
            newqty=newqty/1000;
            newunit='kg';
        }
        if (newunit=='ml') {
            if (newqty>=1000) {
                newqty=newqty/1000;
                newunit='l';
            } else if (newqty>=100) {
                newqty=newqty/100;
                newunit='dl';
            }  else if (newqty>=10) {
                newqty=newqty/10;
                newunit='cl';
            }
        } else {          
            newqty=newqty.toString();

            if (numfmt=='1.000.000,000') {
                newqty = newqty.replace('.',',');
                if (newqty.indexOf(',')>6 || (newqty.indexOf(',')==-1 && newqty.length>6 )) {
                    newqty = newqty.splice( 4, 0, "." );
                    newqty = newqty.splice( 1, 0, "." );
                } else if (newqty.indexOf(',')>3 || (newqty.indexOf(',')==-1 && newqty.length>3 )) {
                    newqty = newqty.splice( 1, 0, "." );
                }
                if (tbs) {
                    tbs=tbs.toString();
                    tbs = tbs.replace('.',',');
                    if (tbs.indexOf(',')>6 || (newqty.indexOf(',')==-1 && newqty.length>6 )) {
                        tbs = tbs.splice( 4, 0, "." );
                        tbs = tbs.splice( 1, 0, "." );
                    } else if (tbs.indexOf(',')>3 || (newqty.indexOf(',')==-1 && newqty.length>3 )) {
                        tbs = tbs.splice( 1, 0, "." );
                    }
                }
                if(tsps) {
                    tsps=tsps.toString();
                    tsps = tsps.replace('.',',');
                    if (tsps.indexOf(',')>6 || (newqty.indexOf(',')==-1 && newqty.length>6 )) {
                        tsps = tsps.splice( 4, 0, "." );
                        tsps = tsps.splice( 1, 0, "." );
                    } else if (tsps.indexOf(',')>3 || (newqty.indexOf(',')==-1 && newqty.length>3 )) {
                        tsps = tsps.splice( 1, 0, "." );
                    }
                }                
            }  else if (numfmt=='1,000,000.00') {
                if (newqty.indexOf('.')>6 || (newqty.indexOf('.')==-1 && newqty.length>6 )) {
                    newqty = newqty.splice( 4, 0, "," );
                    newqty = newqty.splice( 1, 0, "," );
                } else if (newqty.indexOf('.')>3 || (newqty.indexOf('.')==-1 && newqty.length>3 )) {
                    newqty = newqty.splice( 1, 0, "," );
                }
                if (tbs) {
                    tbs=tbs.toString();
                    if (tbs.indexOf('.')>6 || (newqty.indexOf('.')==-1 && newqty.length>6 )) {
                        tbs = tbs.splice( 4, 0, "," );
                        tbs = tbs.splice( 1, 0, "," );
                    } else if (tbs.indexOf('.')>3 || (tbs.indexOf('.')==-1 && tbs.length>3 )) {
                        tbs = tbs.splice( 1, 0, "," );
                    }
                }
                if(tsps) {
                    tsps=tsps.toString();
                    if (tsps.indexOf('.')>6 || (newqty.indexOf('.')==-1 && newqty.length>6 )) {
                        tsps = tsps.splice( 4, 0, "," );
                        tsps = tsps.splice( 1, 0, "," );
                    } else if (tsps.indexOf('.')>3 || (tsps.indexOf('.')==-1 && tsps.length>3 )) {
                        tsps = tsps.splice( 1, 0, "," );
                    }
                }
            } else if (numfmt=='1 000 000,000') {
                newqty = newqty.replace('.',',');
                if (newqty.indexOf(',')>6 || (newqty.indexOf(',')==-1 && newqty.length>6 )) {
                    newqty = newqty.splice( 4, 0, " " );
                    newqty = newqty.splice( 1, 0, " " );
                } else if (newqty.indexOf(',')>3 || (newqty.indexOf(',')==-1 && newqty.length>3 )) {
                    newqty = newqty.splice( 1, 0, " " );
                }
                if (tbs) {
                    tbs=tbs.toString();
                    tbs = tbs.replace('.',',');
                    if (tbs.indexOf(',')>6 || (tbs.indexOf(',')==-1 && tbs.length>6 )) {
                        tbs = tbs.splice( 4, 0, " " );
                        tbs = tbs.splice( 1, 0, " " );
                    } else if (tbs.indexOf(',')>3 || (tbs.indexOf(',')==-1 && tbs.length>3 )) {
                        tbs = tbs.splice( 1, 0, " " );
                    }
                }
                if(tsps) {
                    tsps=tsps.toString();
                    tsps = tsps.replace('.',',');
                    if (tsps.indexOf(',')>6 || (tsps.indexOf(',')==-1 && tsps.length>6 )) {
                        tsps = tsps.splice( 4, 0, " " );
                        tsps = tsps.splice( 1, 0, " " );
                    } else if (tsps.indexOf(',')>3 || (tsps.indexOf(',')==-1 && tsps.length>3 )) {
                        tsps = tsps.splice( 1, 0, " " );
                    }
                }
            }  else if (numfmt=='1 000.000,000') {
                newqty = newqty.replace('.',',');
                if (newqty.indexOf(',')>6 || (newqty.indexOf(',')==-1 && newqty.length>6 )) {
                    newqty = newqty.splice( 4, 0, " " );
                    newqty = newqty.splice( 1, 0, "." );
                } else if (newqty.indexOf(',')>3 || (newqty.indexOf(',')==-1 && newqty.length>3 )) {
                    newqty = newqty.splice( 1, 0, "." );
                }
                if (tbs) {
                    tbs=tbs.toString();
                    tbs = tbs.replace('.',',');
                    if (tbs.indexOf(',')>6 || (tbs.indexOf(',')==-1 && tbs.length>6 )) {
                        tbs = tbs.splice( 4, 0, " " );
                        tbs = tbs.splice( 1, 0, "." );
                    } else if (tbs.indexOf(',')>3 || (tbs.indexOf(',')==-1 && tbs.length>3 )) {
                        tbs = tbs.splice( 1, 0, "." );
                    }
                }
                if(tsps) {
                    tsps=tsps.toString();
                    tsps = tsps.replace('.',',');
                    if (tsps.indexOf(',')>6 || (tsps.indexOf(',')==-1 && tsps.length>6 )) {
                        tsps = tsps.splice( 4, 0, " " );
                        tsps = tsps.splice( 1, 0, "." );
                    } else if (tsps.indexOf(',')>3 || (tsps.indexOf(',')==-1 && tsps.length>3 )) {
                        tsps = tsps.splice( 1, 0, "." );
                    }
                }
            }
        }
    }
    newqty=newqty.toString();
    if(tbs) {
        tbs=tbs.toString();
        if(tbs!='' && tbs != '0') {
            newunit = newunit+' +'+tbs+'tbsp';
        }
    }
    if(tsps) {
        tsps=tsps.toString();
        if(tsps!='' && tsps != '0') {
            newunit = newunit+' +'+tsps+'tsp';
        }
    }                                      
    if(extra=='false') {
        $('#sqty' + key).html(newqty);
        $('#sunit' + key).html(newunit);
        $("input[name='qty"+key+"']").val(newqty);
        $("input[name='unit"+key+"']").val(newunit);
    } else {
        $('#seqty' + key).html(newqty);
        $('#seunit' + key).html(newunit);
        $("input[name='eqty"+key+"']").val(newqty);
        $("input[name='eunit"+key+"']").val(newunit);
    }
}
function convertcups(qtydec,mls,myregion,unit) {
    var tbs=0;
    var tsps=0;
    var newunit=unit;
    
    if (mls>0) {
        newqty=qtydec/mls;
    } else {
        newqty=qtydec;
    }
    
    var split = newqty.toString().split('.');
    newqty = split[0];
    var remainder = split[1];                                        
    if (remainder) {
        remainder = '.' +  remainder;
        var quarters = remainder/.25;
        var wholeqtrs = quarters.toString().split('.');
        newqty=parseFloat(newqty)+(parseFloat(wholeqtrs[0])*.25);
        remainder=remainder-(wholeqtrs[0]*.25);
        if (remainder>0) {
            if (mls>0) {
                tsps = (mls*remainder)/5;
            } else {
                tsps = remainder/5;
            }
            if (myregion=='Australia') {
                if (tsps >= 4) {
                    tbs = tsps/4; 
                    var tbsplit =tbs.toString().split('.');
                    tbs = tbsplit[0];
                    tsps=tsps-(tbs*4);
                    
                }
            } else {
                if (tsps >= 3) {
                    tbs = tsps/3; 
                    var tbsplit =tbs.toString().split('.');
                    tbs = tbsplit[0];
                    tsps=tsps-(tbs*3);
                }
            }
            var wholetsps = tsps.toString().split('.');
            tsps=wholetsps[0];
            remainder='.' + wholetsps[1];
            remainder = 5*remainder;
            var eighth =5/8;
            var eighthtsps = remainder/eighth;
            eighthtsps = Math.round(eighthtsps);
            var deceighths =  eighthtsps*.125;
            tsps = parseInt(tsps)+parseFloat(deceighths);
        }
    }
    if (newqty==0) {
        newunit='tbs';
        newqty=tbs;
        tbs=0;
        if (newqty==0) {
            newunit='tsp';
            newqty=tsps;
            tsps=0;
        }
    }
    return [newqty,tbs,tsps,newunit];
}
function converttbs(qtydec,myregion,fromregion,unit) {
    if (myregion=='Australia') {
           if (fromregion!='Australia') {
                var newqty=qtydec*3;
                var newunit='tsp';
                if(newqty>=4) {
                    var tspmls=newqty*5;
                    var tspmlstbs=tspmls/20;
                    var split=tspmlstbs.toString().split('.');
                    var extratbs=split[0];
                    var parttbs=split[1];
                    newqty=extratbs;
                    newunit='tbsp';
                    if (parttbs) {
                        parttbs='.' + parttbs
                        var extramls=20*parseFloat(parttbs);
                        tsps=extramls/5;                                                 
                    }
                } else {
                    tsps=0;
                }   
            }
        } else {
            if (fromregion=='Australia') {
                var tbs=qtydec;
                var tsps=qtydec;
                if(tsps>=3) {
                    var tspmls=tsps*5;
                    var tspmlstbs=tspmls/15;
                    var split=tspmlstbs.toString().split('.');
                    var extratbs=split[0];
                    var parttbs=split[1];
                    tbs=parseInt(tbs)+parseInt(extratbs);
                    if (parttbs) {
                        parttbs='.' + parttbs
                        var extramls=15*parseFloat(parttbs);
                        tsps=extramls/5;                                                 
                    }
                }
                var newqty=tbs;
                var newunit=unit;
            }
        }
        return [newqty,tsps,newunit]
}
function convert(fromregion) {
    var myregion = $.cookie('region');
    var numfmt = $.cookie('numfmt');
    var fracdec = $.cookie('fracdec');
    var groroz = $.cookie('groroz');
        
    if(numfmt=='notset' || fracdec=='notset' || myregion=='notset' || groroz=='notset') {
        $('.message_box').removeClass('ok');
        $('.message_box').html('<img class="close_message"  src="images/ok.png" >You must set the preferences for resizing & conversion before you can convert a recipe. You can do this at Account > Preferences');
        $('.message_box').show();
        $('#convertmsg').show();
    }  else {
        new Messi("Are you sure you wish to convert this recipe from " + fromregion+ " to " + myregion + " format?<br><br><strong>Please Note</strong>The change won't be permanent until you edit and save the recipe with the new values. Any related recipe/s will not be affected" , {
            title: 'Convert Recipe',
            buttons: [{id: 0, label: 'Convert', val: 'Y'},    
                     {id: 1, label: 'Cancel', val: 'N'}],
            width:'250px',
            callback: function(val) {    
               if (val=='Y') {
                   var error=0;
                   $.post("includes/ajaxgetunits.php", function(data) {
                       data = JSON.parse(data);
                       if(data=="nodb"){
                           $(".message_box").removeClass('ok');
                           $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                           return false;
                       }    
                       $("#ingdisp span").each(function() {
                            var unit='';
                            var qty='';
                            var newunit='';
                            var newqty='';
                            
                            qty = $(this).html();
                            qty = qty.trim();
                            if (qty!='') {
                                if ($(this).attr('id').substr(1,1)=='e') {
                                    var extra='true';
                                    var key = $(this).attr('id').substr(5);
                                    unit = $('#seunit' + key).html();
                                } else {
                                    var extra='false';
                                    var key = $(this).attr('id').substr(4);
                                    unit = $('#sunit' + key).html();
                                }
                                if (unit && unit!='') {
                                    var dash=qty.indexOf('-');
                                    var to=qty.indexOf('to');
                                    var or=qty.indexOf('or');
                                    if ( dash>-1 || to>-1 || or>-1) { //we may have a range in the quantity
                                             if (dash>-1) {
                                                  var dashspot=dash; //find the first occurence of the dash
                                             } else if (to>-1) {
                                                  var dashspot=to; //find the first occurence of the to
                                             } else if (or>-1) {
                                                  var dashspot=or; //find the first occurence of the to
                                             }
                                             qty=qty.substring(0,dashspot);
                                    }
                                    if (qty.indexOf('/')>-1) { //we have a fraction or mixed number
                                        var qtydec = frac2dec(qty);
                                    } else {
                                        var qtydec=parseFloat(qty);
                                    }
                                    if (qty && !qtydec) {
                                        error=parseInt(error)+1;
                                        return false;
                                    }
                                    var base='';    
                                    for (i in data.units) {
                                        var unitname = data.units[i].unit;
                                        if (unit==unitname) {
                                            base = data.units[i].base;
                                            //return false;
                                        }
                                    }
                                    if (base=='ounce') {
                                        if(myregion=='Metric' || myregion=='Australia' || myregion=='New Zealand' || groroz=='metric') {
                                            var qtyunit = qtydec + ' oz';
                                            qtyunit = Qty(qtyunit);
                                            qtyunit = qtyunit.to('g').toPrec('g').toString();
                                            var split=qtyunit.split(' ');
                                            newqty=split[0];
                                            newunit=split[1];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }
                                    } else if (base=='tablespoon') {
                                        var qtys=converttbs(qtydec,myregion,fromregion,unit);
                                        newunit=qtys[2];
                                        newqty = qtys[0];
                                        tsps = qtys[1];
                                        updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,tsps);                                   
                                    } else if (base=='heaped tablespoon')  {
                                        qtydec=qtydec*3;
                                        var qtys=converttbs(qtydec,myregion,fromregion,unit);
                                        newunit=qtys[2];
                                        newqty = qtys[0];
                                        tsps = qtys[1];
                                        updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,tsps);
                                    }  else if (base=='rounded tablespoon') {
                                        qtydec=qtydec*2;
                                        var qtys=converttbs(qtydec,myregion,fromregion,unit);
                                        newunit=qtys[2];
                                        newqty = qtys[0];
                                        tsps = qtys[1];
                                        updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,tsps);    
                                    } else if (base=='fluid ounce') {
                                        if(myregion=='Metric' || myregion=='Australia' || myregion=='New Zealand' || groroz=='metric') {
                                            if (fromregion=='USA') {   
                                                var qtyunit = qtydec + ' floz';
                                                qtyunit = Qty(qtyunit);
                                                qtyunit = qtyunit.to('ml').toPrec('ml').toString();
                                                var split=qtyunit.split(' ');
                                                newqty=split[0];
                                                newunit=split[1];
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            } else if (fromregion=='Canada' || fromregion=='UK' || fromregion=='Australia' || fromregion=='New Zealand') {
                                                newqty=qtydec*28;
                                                newunit='ml';
                                            }
                                        }
                                    } else if (base=='inch') {
                                        if(myregion=='Metric' || myregion=='Australia' || myregion=='New Zealand' || groroz=='metric') {
                                            var qtyunit = qtydec + ' in';
                                            qtyunit = Qty(qtyunit);
                                            qtyunit = qtyunit.to('cm').toPrec('0.5 cm').toString();
                                            var split=qtyunit.split(' ');
                                            newqty=split[0];
                                            newunit=split[1];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }
                                    } else if (base=='gallon') {
                                        if(myregion=='Metric' || groroz=='metric') {
                                            if (fromregion=='Australia' || fromregion=='New Zealand' || fromregion=='Canada' || fromregion=='UK') {
                                                newqty=qtydec*4546;
                                                newunit='ml';
                                            } else if(fromregion=='USA') {    
                                                var qtyunit = qtydec + ' gal';
                                                qtyunit = Qty(qtyunit);
                                                qtyunit = qtyunit.to('l').toPrec('ml').toString();
                                                var split=qtyunit.split(' ');
                                                newqty=split[0];
                                                newunit=split[1];
                                            }
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        } else if(myregion=='Australia' || myregion=='New Zealand' || myregion=='Canada' || myregion=='UK') {
                                            if (fromregion=='USA') {
                                                newqty=(qtydec*3785)/4546;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                                                    
                                        } else if (myregion=='USA') {
                                            if (fromregion=='Australia' || fromregion=='New Zealand' || fromregion=='Canada' || fromregion=='UK') {
                                                newqty=(qtydec*4546)/3785;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                        }
                                    } else if (base=='quart') {
                                        if(myregion=='Metric' || groroz=='metric') {
                                            if (fromregion=='Australia' || fromregion=='New Zealand' || fromregion=='Canada' || fromregion=='UK') {
                                                newqty=qtydec*1137;
                                                newunit='ml';
                                            } else if(fromregion=='USA') {
                                                var qtyunit = qtydec + ' quart';
                                                qtyunit = Qty(qtyunit);
                                                qtyunit = qtyunit.to('ml').toPrec('ml').toString();
                                                var split=qtyunit.split(' ');
                                                newqty=split[0];
                                                newunit=split[1];
                                            }
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        } else if(myregion=='Australia' || myregion=='New Zealand' || myregion=='Canada' || myregion=='UK') {
                                            if (fromregion=='USA') {
                                                newqty=(qtydec*1137)/946;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                                                    
                                        } else if (myregion=='USA') {
                                            if (fromregion=='Australia' || fromregion=='New Zealand' || fromregion=='Canada' || fromregion=='UK') {
                                                newqty=(qtydec*946)/1137;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                        }
                                    } else if (base=='dessertspoon') {
                                            if(myregion=='Metric' || groroz=='metric') {
                                                newqty=qtydec*10;
                                                newunit = 'ml';
                                                
                                            }
                                    } else if (base=='stick') {
                                            var ing=$("input[name=ing"+key+"]").val();
                                            if (ing.indexOf('butter')>-1) {
                                                if(myregion=='Metric' || myregion=='Australia' || myregion=='New Zealand' || groroz=='metric') {
                                                    newqty=qtydec*113;
                                                    newunit='g';
                                                } else if(myregion!='USA') {
                                                    newqty=4;
                                                    newunit='oz';
                                                }
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                    } else if (base=='pint') {
                                        if(myregion=='Metric' || groroz=='metric') {
                                            if (fromregion=='Australia' || fromregion=='New Zealand') {
                                                newqty = qtydec*570;
                                                newunit='ml';
                                            } else if (fromregion=='Canada' || fromregion=='UK') {
                                                newqty = qtydec*568;
                                                
                                            } else {
                                                var qtyunit = qtydec + ' pint';
                                                qtyunit = Qty(qtyunit);
                                                qtyunit = qtyunit.to('ml').toPrec('ml').toString();
                                                var split=qtyunit.split(' ');
                                                newqty=split[0];    
                                            }
                                            newunit='ml';
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }  else if(myregion=='Australia' || myregion=='New Zealand') {
                                            if (fromregion=='USA') {
                                                newqty=(qtydec*473)/570;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            } else if(fromregion=='Canada' || fromregion=='UK') {
                                                newqty=(qtydec*568)/570;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }                                                              
                                        } else if (myregion=='USA') {
                                            if (fromregion=='Australia' || fromregion=='New Zealand') {
                                                newqty=(qtydec*570)/473;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            } else if(fromregion=='Canada' || fromregion=='UK') {
                                                newqty=(qtydec*568)/473;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                        }  else if(myregion=='Canada' || myregion=='UK') {
                                            if (fromregion=='Australia' || fromregion=='New Zealand') {
                                                newqty=(qtydec*570)/568;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            } else if (fromregion=='USA') {
                                                newqty=(qtydec*473)/568;
                                                newunit=unit;
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                        }
                                    } else if (base=='pound')  {
                                        if(myregion=='Metric' || myregion=='Australia' || myregion=='New Zealand' || groroz=='metric') {
                                            var qtyunit = qtydec + ' lb';
                                            qtyunit = Qty(qtyunit);
                                            qtyunit = qtyunit.to('g').toPrec('g').toString();
                                            var split=qtyunit.split(' ');
                                            newqty=split[0];
                                            newunit=split[1];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }                                    
                                    } else if (base=='cup') {
                                        if(fromregion=='Canada' || fromregion=='Australia' || fromregion=='New Zealand') {
                                            qtydec=qtydec*250;
                                        } else if(fromregion=='UK') {
                                            qtydec=qtydec*284;
                                        } else if(fromregion=='USA') {
                                            qtydec=qtydec*237;
                                        }
                                        if(myregion=='Canada' || myregion=='Australia' || myregion=='New Zealand') {
                                            if ((myregion=='Canada' && fromregion!='Australia' && fromregion!='New Zealand')
                                            || (myregion=='Australia' && fromregion!='Canada' && fromregion!='New Zealand')
                                            ||(myregion=='New Zealand' && fromregion!='Australia' && fromregion!='Canada')) {
                                                var qtys = convertcups(qtydec,250,myregion,unit);
                                                newunit=qtys[3];
                                                newqty = qtys[0];
                                                tbs = qtys[1];
                                                tsps = qtys[2];
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                            }
                                        } else if(myregion=='UK') {
                                            var qtys = convertcups(qtydec,284,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='USA') {
                                            var qtys = convertcups(qtydec,237,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='Metric') {
                                            newqty=qtydec;
                                            newunit='ml';
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }
                                    } else if (base=='rounded cup') {
                                        var extramls=qtydec*15;
                                        var split = unit.split(' ');
                                        unit=split[1];
                                        if(fromregion=='Canada' || fromregion=='Australia' || fromregion=='New Zealand') {
                                            qtydec=qtydec*250;
                                        } else if(fromregion=='UK') {
                                            qtydec=qtydec*284;
                                        } else if(fromregion=='USA') {
                                            qtydec=qtydec*237;
                                        }
                                        qtydec=parseFloat(qtydec) + parseFloat(extramls);
                                        if(myregion=='Canada' || myregion=='Australia' || myregion=='New Zealand') {
                                            var qtys = convertcups(qtydec,250,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='UK') {
                                            var qtys = convertcups(qtydec,284,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='USA') {
                                            var qtys = convertcups(qtydec,237,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='Metric') {
                                            newqty=qtydec;
                                            newunit='ml';
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }
                                    }  else if (base=='heaped cup') {
                                        var extramls=qtydec*30;
                                        var split = unit.split(' ');
                                        unit=split[1];
                                        if(fromregion=='Canada' || fromregion=='Australia' || fromregion=='New Zealand') {
                                            qtydec=qtydec*250;
                                        } else if(fromregion=='UK') {
                                            qtydec=qtydec*284;
                                        } else if(fromregion=='USA') {                                        
                                            qtydec=qtydec*237;
                                        }
                                        qtydec=parseFloat(qtydec) + parseFloat(extramls);
                                        if(myregion=='Canada' || myregion=='Australia' || myregion=='New Zealand') {
                                            var qtys = convertcups(qtydec,250,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='UK') {
                                            var qtys = convertcups(qtydec,284,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='USA') {
                                            var qtys = convertcups(qtydec,237,myregion,unit);
                                            newunit=qtys[3];
                                            newqty = qtys[0];
                                            tbs = qtys[1];
                                            tsps = qtys[2];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,tbs,tsps);
                                        } else if(myregion=='Metric') {
                                            newqty=qtydec;
                                            newunit='ml';
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }
                                    } else if(base=='centiliter') {
                                        if(myregion!='Metric') {
                                            var qtyunit = qtydec + ' cl';
                                            qtyunit = Qty(qtyunit);
                                            qtyunit = qtyunit.to('tsp').toPrec('.125 tsp').toString();
                                            var split=qtyunit.split(' ');
                                            newqty=split[0];
                                            newunit='tsp';
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0); 
                                        }
                                    } else if (base=='centimeter') {
                                        if(myregion=='Canada' || myregion=='UK' || myregion=='USA' || groroz=='imperial') {
                                            var qtyunit = qtydec + ' cm';
                                            qtyunit = Qty(qtyunit);
                                            qtyunit = qtyunit.to('inch').toPrec('.25 inch').toString();
                                            var split=qtyunit.split(' ');
                                            newqty=split[0];
                                            newunit=split[1];
                                            updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                        }
                                    } else if (base=='deciliter') {
                                        if(myregion!='Metric') {
                                            if(myregion=='Canada' || myregion=='UK' || myregion=='USA' || groroz=='imperial') {
                                                if(myregion=='USA') {
                                                    var qtyunit = qtydec + ' dl';
                                                    qtyunit = Qty(qtyunit);
                                                    qtyunit = qtyunit.to('floz').toString();
                                                    var split=qtyunit.split(' ');
                                                    newqty=split[0];
                                                    newunit=split[1];
                                                    updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                                } else {
                                                    qtydec=qtydec*100; //mls
                                                    newqty=qtydec/28.5;
                                                    newunit='fluid ounce';
                                                    updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                                }
                                            } else {
                                                var qtyunit = qtydec + ' dl';
                                                qtyunit = Qty(qtyunit);
                                                qtyunit = qtyunit.to('ml').toString();
                                                var split=qtyunit.split(' ');
                                                newqty=split[0];
                                                newunit=split[1];
                                                updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0);
                                            }
                                        } 
                                    } else if (base=='gram') {
                                        if(myregion=='Canada' || myregion=='UK' || myregion=='USA' || groroz=='imperial') {
                                           var qtyunit = qtydec + ' g';
                                           qtyunit = Qty(qtyunit);
                                           qtyunit = qtyunit.to('oz').toString();
                                           var split=qtyunit.split(' ');
                                           newqty=split[0];
                                           newunit=split[1];
                                           updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0); 
                                        }
                                    } else if (base=='kilogram') {
                                        if(myregion=='Canada' || myregion=='UK' || myregion=='USA' || groroz=='imperial') {
                                           var qtyunit = qtydec + ' kg';
                                           qtyunit = Qty(qtyunit);
                                           qtyunit = qtyunit.to('lb').toString();
                                           var split=qtyunit.split(' ');
                                           newqty=split[0];
                                           newunit=split[1];
                                           updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0); 
                                        }
                                    } else if (base=='litre') {
                                        if(myregion=='Canada' || myregion=='UK' || myregion=='USA' || groroz=='imperial') {
                                           var qtyunit = qtydec + ' l';
                                           qtyunit = Qty(qtyunit);
                                           qtyunit = qtyunit.to('qt').toString();
                                           var split=qtyunit.split(' ');
                                           newqty=split[0];
                                           newunit=split[1];
                                           updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0); 
                                        }
                                    } else if (base=='milliliter') {
                                        if(myregion=='Canada' || myregion=='UK' || myregion=='USA' || groroz=='imperial') {
                                           var qtyunit = qtydec + ' ml';
                                           qtyunit = Qty(qtyunit);
                                           qtyunit = qtyunit.to('floz').toString();
                                           var split=qtyunit.split(' ');
                                           newqty=split[0];
                                           newunit=split[1];
                                           updaterecipe(newqty,newunit,key,extra,numfmt,fracdec,0,0); 
                                        }
                                    }    
                                }                            
                            }
                      });
                      if ($("input[name='measure']").hasClass('hasval')) {
                          $('#measure .new').html(myregion+' ');
                          $("input[name='measure']").val(myregion);
                      } else {
                          $('#measure strong').after(' <div class=new>'+myregion+' </div>');
                          $("input[name='measure']").val(myregion).addClass('hasval');
                          $('#measure').show();
                      }
                      if (error>0) {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Unable to convert all the ingredients as there is a problem with the quantity.<br>The quantity field should only contain numbers.<br>Check your recipe on the edit recipe page for any problems.');
                            $('.message_box').show();
                      } else {
                          $('.message_box').addClass('ok');
                          $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Recipe converted');
                          $('.message_box').show();
                          $('#convertmsg').show();
                      }
                   });
               }
               $('.messi').remove();                            
            }        
         });
    }
}
$(document).ready(function(){
    $(".rlink").not('#favs .rlink').draggable({
        helper: 'clone',
        revert: false
    });
    $(".cat").droppable({
        hoverClass: "cat-hover",
        tolerance: "pointer",
        drop: function(event, ui) {
            $("*").removeClass('cat-hover').removeClass('subcat-hover');
            
            if($(ui.draggable).is('[id]')) {
              var recid = $(ui.draggable).attr("id").substr(1);
            } else {
              var idclass = $.grep($(ui.draggable).attr('class').split(" "), function(v, i){
                  return v.indexOf('i') === 0;
              })
              var recid = idclass[0].substr(1);
            }
            var newcat=$(this).attr('id');
            newcat=newcat.replace('/', '\/' );  
            var rechtml=$(ui.draggable).parent().html();
            rechtml=rechtml.replace(/<\/a>/g,'</a>|');
            rechtml=rechtml.split('|');
            rechtml='<li>' + rechtml[0] + '</li>';
            rechtml=rechtml.replace('hassubcat',"");
            $("[id='" + newcat + "'] ul:first").append(rechtml);
            /*var mylist= $("[id='" + newcat + "']").find('ul:first');
            var listitems = mylist.children('li').get();
            listitems.sort(function(a, b) {
               return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
            })
            $.each(listitems, function(idx, itm) { mylist.append(itm); });*/
            if (!$("[id='" + newcat + "']").find('ul:first').is( ":visible" )) {
                $("[id='" + newcat + "']").find('a:first').addClass('sb-submenu-active'); 
                $("[id='" + newcat + "']").find('ul:first').show().addClass('sb-submenu-active'); 
            }
      
            if ($(ui.draggable).hasClass('hassubcat')) {
              var oldsubcat = $(ui.draggable).closest('li.subcat').attr('id');
              var oldcat= $(ui.draggable).closest('li.cat').attr('id');
              $(ui.draggable).parent().remove();
              oldcat=oldcat.replace('/', '\/' );
              if (oldsubcat) {
                oldsubcat=oldsubcat.replace('/', '\/' );
              }
              var test =  $("[id='" + oldcat + "'] > ul > li").length;
              var test2 =  $("[id='" + oldsubcat + "'] > ul > li").length;
              if($("[id='" + oldsubcat + "'] > ul > li").length==0) {
                  $("[id='" + oldsubcat + "']").remove();
              }
              if($("[id='" + oldcat + "'] > ul > li").length==0) {
                  $("[id='" + oldcat + "']").remove();
              }
            } else {
               var oldcat = $(ui.draggable).closest('li.cat').attr('id');
               oldcat=oldcat.replace('/', '\/' );
               $(ui.draggable).parent().remove();
               var test =  $("[id='" + oldcat + "'] > ul > li").length;
               if($("[id='" + oldcat + "'] > ul > li").length==0) {
                  $("[id='" + oldcat + "']").remove();
              }
            }
            if (oldcat!=newcat) {
                if ($("[id='" + oldcat + "']").find('ul:first').length) {
                    $("[id='" + oldcat + "']").find('a:first').removeClass('sb-submenu-active');
                    $("[id='" + oldcat + "']").find('ul:first').hide().removeClass('sb-submenu-active');
                }
            }
            
            $(".rlink").not('#favs .rlink').draggable({
                helper: 'clone',
                revert: false
            });
            var inData = "";
            var ct=0;
              
            function appGET(data, str) {
                if (data && data != 'undefined') {
                data = encodeURIComponent(html_entity_decode(data));
                if (ct == 0) {
                    inData += str + '=' + data;
                } else {
                    inData += '&' + str + '=' + data;
                }
                ct++;
                }
            }
            appGET(recid, 'recid');
            appGET(oldcat, 'oldcat');
            if (typeof oldsubcat !== 'undefined') {
                var re4= new RegExp(oldcat + '-');
                oldsubcat=oldsubcat.replace(re4,'');
                appGET(oldsubcat, 'oldsubcat');
            }
            appGET(newcat, 'newcat');
            
            $.post("includes/ajaxchangecat.php",inData,function(data) {
                if(data=="nodb"){
                    $(".message_box").removeClass('ok');
                    $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                    return false;
                }
                if ($.cookie('rid')==recid) {
                    var rowner = $.cookie('rowner');
                    clearrecipe();
                    loadrecipe(recid,rowner);
                    /* wrong somewhere
                    var catnum = $('input[value="' + oldcat + '"]').attr('name').substr(3);    
                    var cathtml = $('#c'+catnum).html();
                    var re = new RegExp(oldcat, "g");
                    var newcathtml = cathtml.replace(re,newcat);
                    if ($('input[name=scat' + catnum + ']').length) {
                       var re4= new RegExp(oldcat + '-');
                       oldsubcat=oldsubcat.replace(re4,'');
                       var re3 = new RegExp(': ' + oldsubcat, "g");
                       newcathtml = newcathtml.replace(re3,''); 
                    }
                    $('#c'+catnum).html(newcathtml);
                    if ($('input[name=scat' + catnum + ']').length) {
                       $('input[name=scat' + catnum + ']').remove(); 
                    }*/
                }
            });
        }
    });
    $(".subcat").droppable({
        hoverClass: "subcat-hover",
        greedy: true,
        tolerance: "pointer",
        drop: function(event, ui) {
            $("*").removeClass('cat-hover').removeClass('subcat-hover');
            
            if($(ui.draggable).is('[id]')) {
              var recid = $(ui.draggable).attr("id").substr(1);
            } else {
              var idclass = $.grep($(ui.draggable).attr('class').split(" "), function(v, i){
                  return v.indexOf('i') === 0;
              })
              var recid = idclass[0].substr(1);
            }
            var newsubcat=$(this).attr('id');
            var newcat= $(this).parents('li.cat').last().attr('id');                        
            
            var rechtml=$(ui.draggable).parent().html();
            rechtml=rechtml.replace(/<\/a>/g,'</a>|');
            rechtml=rechtml.split('|');
            rechtml='<li>' + rechtml[0] + '</li>';
            rechtml=rechtml.replace('rlink',"rlink hassubcat");
            $("[id='" + newsubcat + "'] ul").append(rechtml);
            var mylist= $("[id='" + newsubcat + "']").find('ul:first');
            var listitems = mylist.children('li').get();
            listitems.sort(function(a, b) {
               return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
            })
            $.each(listitems, function(idx, itm) { mylist.append(itm); });
            
            if (!$("[id='" + newsubcat + "']").find('ul:first').is( ":visible" )) { 
               $("[id='" + newsubcat + "']").find('ul:first').show().addClass('sb-submenu-active'); 
            }
            
            if ($(ui.draggable).hasClass('hassubcat')) {
              var oldsubcat = $(ui.draggable).closest('li.subcat').attr('id');
              var oldcat= $(ui.draggable).closest('li.cat').attr('id');
              $(ui.draggable).parent().remove();
              oldcat=oldcat.replace('/', '\/' );
              if (oldsubcat) {
                oldsubcat=oldsubcat.replace('/', '\/' );
              }
              if($("[id='" + oldsubcat + "'] > ul > li").length==0) {
                  $("[id='" + oldsubcat + "']").remove();
              }
              if($("[id='" + oldcat + "'] > ul > li").length==0) {
                  $("[id='" + oldcat + "']").remove();
              }
            } else {
               var oldcat= $(ui.draggable).closest('li.cat').attr('id');
               oldcat=oldcat.replace('/', '\/' );
               $(ui.draggable).parent().remove();
               if($("[id='" + oldcat + "'] > ul > li").length==0) {
                  $("[id='" + oldcat + "']").remove();
               }
            }
            if (oldcat!=newcat) {
                if ($("[id='" + oldcat + "']").find('ul:first').length) {
                    $("[id='" + oldcat + "']").find('a:first').removeClass('sb-submenu-active');
                    $("[id='" + oldcat + "']").find('ul:first').hide().removeClass('sb-submenu-active');
                }
            }
            if ($("[id='" + oldsubcat + "']").find('ul:first').length) {
                $("[id='" + oldsubcat + "']").find('a:first').removeClass('sb-submenu-active');
                $("[id='" + oldsubcat + "']").find('ul:first').hide().removeClass('sb-submenu-active');
            }
            
            $(".rlink").not('#favs .rlink').draggable({
                helper: 'clone',
                revert: false
            });
            
            var inData = "";
            var ct=0;
              
            function appGET(data, str) {
                if (data && data != 'undefined') {
                data = encodeURIComponent(html_entity_decode(data));
                if (ct == 0) {
                    inData += str + '=' + data;
                } else {
                    inData += '&' + str + '=' + data;
                }
                ct++;
                }
            }
            appGET(recid, 'recid');
            appGET(oldcat, 'oldcat');
            if (typeof oldsubcat !== 'undefined') {
                var re4= new RegExp(oldcat + '-');
                oldsubcat=oldsubcat.replace(re4,'');
                appGET(oldsubcat, 'oldsubcat');
            }
            if (typeof newsubcat !== 'undefined') {
                var re4= new RegExp(oldcat + '-');
                newsubcat=newsubcat.replace(re4,'');
                appGET(newsubcat, 'newsubcat');
            }
            appGET(newcat, 'newcat');
            
            $.post("includes/ajaxchangecat.php",inData,function(data) {
                if(data=="nodb"){
                    $(".message_box").removeClass('ok');
                    $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                    return false;
                }
                if ($.cookie('rid')==recid) {
                    var rowner = $.cookie('rowner');
                    clearrecipe();
                    loadrecipe(recid,rowner);
                    /*var catnum = $('input[value="' + oldcat + '"]').attr('name').substr(3);
                    var re4= new RegExp(oldcat + '-');
                    newsubcat=newsubcat.replace(re4,'');
                    if ($('input[name=scat' + catnum + ']').length) {
                        var cathtml = $('#c'+catnum).html();
                        var re = new RegExp(oldcat, "g");
                        var re2 = new RegExp(oldsubcat, "g");
                        var newcathtml = cathtml.replace(re,newcat);
                        oldsubcat=oldsubcat.replace(re4,'');
                        if (newsubcat) {
                            newcathtml = newcathtml.replace(re2,newsubcat);                        
                        } else {
                            var re3 = new RegExp(': ' + oldsubcat, "g");
                            var newcathtml = cathtml.replace(re3,'');
                            $('input[name=scat' + catnum + ']').remove();
                        }
                        $('#c'+catnum).html(newcathtml);
                    }  else {
                        var cathtml = $('#c'+catnum).html();
                        var re = new RegExp(oldcat, "g");
                        var newcathtml = cathtml.replace(re,newcat + ': ' + newsubcat);
                        newcathtml = newcathtml + '<input type="hidden" value="' + newsubcat + '" name="scat' + catnum + '">';
                        $('#c'+catnum).html(newcathtml);
                        $('input[name=cat' + catnum + ']').val(newcat);
                    }*/
                }
            }); 
        }
    });
    $(document).on('click', ".convertau", function() {
        var fromregion =  'Australia';
        convert(fromregion);
    });                                     
    $(document).on('click', ".convertca", function() {
        var fromregion =  'Canada';
        convert(fromregion);
    });
    $(document).on('click', ".converteu", function() {
        var fromregion =  'Metric';
        convert(fromregion);
    });
    $(document).on('click', ".convertnz", function() {
        var fromregion =  'New Zealand';
        convert(fromregion);
    });
    $(document).on('click', ".convertuk", function() {
        var fromregion =  'UK';
        convert(fromregion);
    });
    $(document).on('click', ".convertus", function() {
        var fromregion =  'USA';
        convert(fromregion);
    });
    //revert converted recipe to original
     $(document).on('click', "#convertrevert", function() {
         $("#ingdisp span").each(function() {
            var id=$(this).attr('id');
            var qtytype=id.substring(1,2);
            if(qtytype=='q') {
                var ingnum=id.substr(4);
                $(this).text($("input[name='oldqty"+ingnum+"']").val());
                $("input[name='qty"+ingnum+"']").val($("input[name='oldqty"+ingnum+"']").val());
                $('#sunit'+ingnum).text($("input[name='oldunit"+ingnum+"']").val());
                $("input[name='unit"+ingnum+"']").val($("input[name='oldunit"+ingnum+"']").val());
            } else {
                var ingnum=id.substr(5);
                $(this).text($("input[name='oldeqty"+ingnum+"']").val());
                $("input[name='eqty"+ingnum+"']").val($("input[name='oldeqty"+ingnum+"']").val());
                $('#seunit'+ingnum).text($("input[name='oldeunit"+ingnum+"']").val());
                $("input[name='eunit"+ingnum+"']").val($("input[name='oldeunit"+ingnum+"']").val());
            }
            if($("input[name='oldmeasure']").val()) {
               $('#measure .new').html($("input[name='oldmeasure']").val()+' ');
               $("input[name='measure']").val($("input[name='oldmeasure']").val()); 
            } else {
                $('#measure').hide();
            }
            
         });
         $('#convertmsg').hide();
   });
    //edit comment confirmation
    $(document).on('click', ".commentedit", function() {
        var commentid=$(this).parent().attr('id');
        var comment=$('#'+commentid).find('p:first').html().substr(9);
        comment=comment.replace("<br>","");
        comment=comment.replace("\n","");
        new Messi('', {
            title: 'Edit comment',
            buttons: [{id: 0, label: 'Save', val: 'Y'},
                    {id: 1, label: 'Cancel', val: 'N'}],
            textareas: [{id: 0, label: "Comment", fid: "newcomment", value: comment}],
            callback: function(val) {
                if (val=='Y') {
                    var newcomment=$('#newcomment').val();
                    $('#'+commentid).find('p:first').html('Comment: ' + newcomment);

                    var inData = "";
                    var ct=0;
                    function appGET(data, str) {
                        if (data && data != 'undefined') {
                            data = encodeURIComponent(html_entity_decode(data));
                            if (ct==0) {
                                inData += str + '=' + data;
                            } else {
                                inData += '&' + str + '=' + data;
                            }
                            ct++;
                        }
                    }
                    appGET(commentid, 'commentid');
                    appGET(newcomment, 'newcomment');
                    $.post("includes/updcomment.php",inData,function(data) {
                        if(data=="nodb"){
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                            return false;
                       }
                    });
                }
                $('.messi').remove();
            }
        });
    });
    //delete comment confirmation
    $(document).on('click', ".commentdel", function() {
        var commentid=$(this).parent().attr('id');
        var comment=$(this).prev().html().substr(9);
        comment=comment.replace("<br>","");
        comment=comment.replace("\n","");
        new Messi('Are you sure you want to PERMANENTLY delete the comment "' + comment + '"', {
            title: 'Delete comment',
            buttons: [{id: 0, label: 'Yes', val: 'Y'    },
                        {id: 1, label: 'No', val: 'N'}],
            callback: function(val) {
                if (val=='Y') {
                    $('#'+commentid).remove();
                    var cnum=parseInt($('#cnum').html())-1;
                    if (cnum==0) {
                        $('#currentcomments').hide();
                    } else if (cnum==1){
                        $('#ccnum').html('There is currently <span id=cnum>1</span> comment for this recipe');
                    } else {
                        $('#ccnum').html('There are currently <span id=cnum>'+ccnum+'</span> comments for this recipe');
                    }

                    var inData = "";
                    var ct=0;

                    function appGET(data, str) {
                            if (data && data != 'undefined') {
                                    data = encodeURIComponent(html_entity_decode(data));
                                    if (ct == 0) {
                                            inData += str + '=' + data;
                                    } else {
                                            inData += '&' + str + '=' + data;
                                    }
                                    ct++;
                            }
                    }
                    appGET(commentid, 'commentid');

                    $.post("includes/delcomment.php",inData,function(data) {
                        if(data=="nodb"){
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                            return false;
                       }
                    });
                }
                $('.messi').remove();
            }
        });
    });
    $(document).on('click', ".dispapproved", function() {
        window.location="display.php";
    });
     $(document).on('click', ".approve", function() {
        $('.message_box').addClass('ok');
        $('.message_box').html('Approving recipe...');
        $('.message_box').show();
        
        var numapp= $('#numapp').text();
        numapp = parseInt(numapp) + 1;
        $('#numapp').text(numapp);
        
        var numunapp= $('#numunapp').text();
        numunapp = parseInt(numunapp) - 1;
        $('#numunapp').text(numunapp);
        
        var currid =$('#id').val();
        
        $(".i"+currid).each(function() {
            if ($(this).hasClass('hassubcat')) {
              var cat = $(this).parent().parent().parent().parent().parent().attr('id');
              var subcat = $(this).parent().parent().parent().attr('id');
              $(this).parent().remove();
              if($('#'+subcat+' > ul > li').length==0) {
                  $('#'+subcat).remove();
              }
              if($('#'+cat+' > ul > li').length==0) {
                  $('#'+cat).remove();
              }
            } else {
                var cat = $(this).parent().parent().parent().attr('id');
                $(this).parent().remove();
                if($('#'+cat+' > ul > li').length==0) {
                  $('#'+cat).remove();
                }
            }
        });
        
        var inData = "";
          var ct=0;
            
          function appGET(data, str) {
              if (data && data != 'undefined') {
              data = encodeURIComponent(html_entity_decode(data));
              if (ct == 0) {
                  inData += str + '=' + data;
              } else {
                  inData += '&' + str + '=' + data;
              }
              ct++;
              }
          }
          appGET($('#id').val(), 'id');
          
          $.post("includes/ajaxapprecipe.php",inData,function(data) {
            if(data=="nodb"){
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                return false;
            }
            var id = data;  
            
            clearrecipe();
            if(id) {    
                $("input[name='id']").val(id);
                loadrecipe(id,null);
            } else {
                $('#norecipes').show();
                $('#recopt').hide();
                $('.appbuttons').hide();  
            }
            $('.message_box').addClass('ok');
            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Recipe Approved');
            $('.message_box').show();
        });
        return false;        
     });
     //revert recipe to original
     $(document).on('click', "#revert", function() {
         $('#yield').val($('#oldyield').val());
         $('#yspan').text($('#oldyield').val());
         $("#ingdisp span").each(function() {
            var id=$(this).attr('id');
            var qtytype=id.substring(1,2);
            if(qtytype=='q') {
                var ingnum=id.substr(4);
                $(this).text($("input[name='oldqty"+ingnum+"']").val());
                $("input[name='qty"+ingnum+"']").val($("input[name='oldqty"+ingnum+"']").val());
            } else {
                var ingnum=id.substr(5);
                $(this).text($("input[name='oldeqty"+ingnum+"']").val());
                $("input[name='eqty"+ingnum+"']").val($("input[name='oldeqty"+ingnum+"']").val());
            }
         });
         $(".ringdisp").each(function() {
            var ryield = $(this).find('.ryspan').val();
            if(ryield) {
               $(this).find('span').each(function() {
                    var id=$(this).attr('id');
                    var matches = id.match(/(\d+)rr(\d+)/);
                    var ingnum = Number(matches[1]);
                    var rnum = Number(matches[2]);
                    var qtytype=id.substring(2,3);
                    if(qtytype=='q') {
                        if(ingnum==0) {
                            $('#yield'+rnum).text(ryield);
                        }
                        $(this).text($("#oldsrqty"+ingnum+'rr'+rnum).val());
                    } else {
                        $(this).text($("#oldsreqty"+ingnum+'rr'+rnum).val());
                    }
               });
            }
         });
         $('#revertmsg').hide();
   });
function resize(obj,factor,resizeerror) {
    var myregion = $.cookie('region');
    var numfmt = $.cookie('numfmt');
    var fracdec = $.cookie('fracdec');
    var groroz = $.cookie('groroz'); 
    var qty=obj.text();
    qty = qty.replace('&nbsp;','');
    qty = qty.trim();
    var id = obj.attr('id');
    if (obj.attr('id').substr(1,1)=='e') {
        var key = $(this).attr('id').substr(5);
        unit = $('#seunit' + key).html();
        qtytype = 'extra';
    } else if(obj.attr('id').substr(1,1)=='r') {
        qtytpe='rr';
        //var key =  $(this).attr('id').substr(5);
        //var rrkey = $(this).attr('id').substr(5);                             
    } else {
        var key = obj.attr('id').substr(4);
        unit = $('#sunit' + key).html();
        qtytype = 'initial';
    }
    var dash=qty.indexOf('-');
    var to=qty.indexOf('to');
    var or=qty.indexOf('or');
    if ( dash>-1 || to>-1 || or>-1) { //we may have a range in the quantity
       if (dash>-1) {
            var dashspot=dash; //find the first occurence of the dash
       } else if (to>-1) {
            var dashspot=to; //find the first occurence of the to
       } else if (or>-1) {
            var dashspot=or; //find the first occurence of the to
       }
       qty=qty.substring(0,dashspot);
    }
    if (qty.indexOf('/')>-1) { //we have a fraction or mixed number
        var qtydec = frac2dec(qty);
    } else {
        var qtydec=parseFloat(qty);
    }
    if (qty && !qtydec) {
            resizeerror=parseInt(resizeerror)+1;
            return false;
    }
    qty= parseFloat(qtydec)*parseFloat(factor);
    qty=Math.round( qty * 1000 )/1000;
    qty=qty.toFixed(3);
    qty=parseFloat(qty);
    if (fracdec=='fraction') {
        if(qty.toString().indexOf('.')!=-1) {
            qty=fraction(qty,8);
        }
    } else {
        qty=qty.toString();
        if (numfmt=='1.000.000,000') {
            qty = qty.replace('.',',');
            if (qty.indexOf(',')>6 || (qty.indexOf(',')==-1 && qty.length>6 )) {
                qty = qty.splice( 4, 0, "." );
                qty = qty.splice( 1, 0, "." );
            } else if (qty.indexOf(',')>3 || (qty.indexOf(',')==-1 && qty.length>3 )) {
                qty = qty.splice( 1, 0, "." );
            }                
        }  else if (numfmt=='1,000,000.00') {
            if (qty.indexOf('.')>6 || (qty.indexOf('.')==-1 && qty.length>6 )) {
                qty = qty.splice( 4, 0, "," );
                qty = qty.splice( 1, 0, "," );
            } else if (qty.indexOf('.')>3 || (qty.indexOf('.')==-1 && qty.length>3 )) {
                qty = qty.splice( 1, 0, "," );
            }
        } else if (numfmt=='1 000 000,000') {
            qty = qty.replace('.',',');
            if (qty.indexOf(',')>6 || (qty.indexOf(',')==-1 && qty.length>6 )) {
                qty = qty.splice( 4, 0, " " );
                qty = qty.splice( 1, 0, " " );
            } else if (qty.indexOf(',')>3 || (qty.indexOf(',')==-1 && qty.length>3 )) {
                qty = qty.splice( 1, 0, " " );
            }
        }  else if (numfmt=='1 000.000,000') {
            qty = qty.replace('.',',');
            if (qty.indexOf(',')>6 || (qty.indexOf(',')==-1 && qty.length>6 )) {
                qty = qty.splice( 4, 0, " " );
                qty = qty.splice( 1, 0, "." );
            } else if (qty.indexOf(',')>3 || (qty.indexOf(',')==-1 && qty.length>3 )) {
                qty = qty.splice( 1, 0, "." );
            }
        }
    }
    if(qtytype=='initial') {
        obj.text(qty);
        var ingnum=id.substr(4);
        $("input[name='qty" + ingnum +"']").val(qty);
    } else if(qtytype=='extra') {
        obj.text(qty);
        var ingnum=id.substr(5);
        $("input[name='eqty" + ingnum +"']").val(qty);
    } else {
        obj.text(qty);
    }
}
    //resize recipe select
   $(document).on('click', ".rsrecipe", function() {
       var myregion = $.cookie('region');
       var numfmt = $.cookie('numfmt');
       var fracdec = $.cookie('fracdec');
       var groroz = $.cookie('groroz');     
    
    if(numfmt=='notset' || fracdec=='notset' || myregion=='notset' || groroz=='notset') {
        $('.message_box').removeClass('ok');
        $('.message_box').html('<img class="close_message"  src="images/ok.png" >You must set the preferences for resizing & conversion before you can convert a recipe. You can do this at Account > Preferences');
        $('.message_box').show();
        $('#convertmsg').show();
    }  else {
       
      var ryield = $('#yield').val();
      var yield_unit = $("input[name='yield_unit']").val();
      var related = $('#related').val();
      
      if (yield_unit) {
          var mess = '<strong>This recipe makes ' + ryield + ' ' + yield_unit + '. Enter a new number of ' + yield_unit + '</strong><br><br>';
      } else {    
          var mess = '<strong>This recipe makes ' + ryield + '. Enter a new amount.</strong><br><br>';
      }
      
      if (ryield && related=='yes') {
         new Messi(mess, {
            title: 'Resize Recipe',
            buttons: [{id: 0, label: 'Resize', val: 'Y'},    
                     {id: 1, label: 'Cancel', val: 'N'}],        
            checkboxes: [{id: 0, label: "Scale Related Recipe/s ", fid: "rel"}],    
            inputs: [{id: 0, label: "Yield", fid: "yieldinp"}],    
            callback: function(val) {    
               if (val=='Y') {        
                  if($('#rel').is(':checked')) {
                     var rscale='yes';                
                  } else {                    
                      var rscale='no';                
                  }
                  var resizeerror=0;
                  var yieldinp = $('#yieldinp').val();
                  if(yieldinp) {
                      $('#yspan').text(yieldinp);
                      $('#yield').val(yieldinp);
                      var new_yield=yieldinp;
                      var factor = parseFloat(new_yield)/parseFloat(ryield);
                      factor= Math.round( factor * 1000 )/1000;
                      factor=factor.toFixed(3);
                      $("#ingdisp span").each(function() {            
                        resize($(this),factor,resizeerror);
                      });
                      if(rscale=='yes') {
                          var rrnoyield=0;
                          var rresizeerror=0;
                          var rrnum=0
                          $(".ringdisp").each(function() {
                                var ryield = $(this).find('.ryspan').val();
                                if(ryield) {
                                    $('#yield' + rrnum).text(yieldinp);
                                    var factor = parseFloat(new_yield)/parseFloat(ryield);
                                    factor= Math.round( factor * 1000 )/1000;
                                    factor=factor.toFixed(3);
                                    $(this).find('span').each(function() {            
                                        resize($(this),factor,rresizeerror);
                                    });
                                } else {
                                    rrnoyield = parseInt(rrnoyield) + 1;
                                }
                                rrnum=parseInt(rrnum) +1;
                           }); 
                      }
                      if (resizeerror>0) {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Unable to resize the main recipe as there is a problem with one or more of the ingredient quantities.<br>The quantity field should only contain numbers.<br>Check your recipe on the edit recipe page for any problems.');
                            $('.message_box').show();
                      } else if (rrnoyield>0 && rresizeerror>0) {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >'+rrnoyield+" of the related recipes was not able to be resized as it doesn't have a yield specified.<br><br>Unable to resize some of the related recipes as there is a problem with one or more of the ingredient quantities.<br>The quantity field should only contain numbers.");
                            $('.message_box').show();
                            $('#revertmsg').show();
                      } else if (rresizeerror>0) {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Unable to resize some of the related recipes as there is a problem with one or more of the ingredient quantities.<br>The quantity field should only contain numbers.');
                            $('.message_box').show();
                            $('#revertmsg').show();
                      } else if (rrnoyield>0) {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >'+rrnoyield+" of the related recipes was not able to be resized as it doesn't have a yield specified.");
                            $('.message_box').show();
                            $('#revertmsg').show();
                      } else {
                            $('.message_box').addClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Recipe resized');
                            $('.message_box').show();
                            $('#revertmsg').show();
                      }
                  } else {
                      $('.message_box').removeClass('ok');
                      $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >A new yield must be entered');
                      $('.message_box').show();
                  }
               }        
               $('.messi').remove();
            }                            
         });                   
      } else if (ryield) {
         new Messi(mess, {
            title: 'Resize Recipe',
            inputs: [{id: 0, label: "Yield", fid: "yieldinp"}],    
            buttons: [{id: 0, label: 'Resize', val: 'Y'},    
                     {id: 1, label: 'Cancel', val: 'N'}],
            width:'250px',
            callback: function(val) {    
               if (val=='Y') {    
                  var resizeerror=0;
                  var yieldinp = $('#yieldinp').val();
                  if(yieldinp) {
                      $('#yspan').text(yieldinp);
                      $('#yield').val(yieldinp);
                      var new_yield=yieldinp;
                      var factor = parseFloat(new_yield)/parseFloat(ryield);
                      factor= Math.round( factor * 1000 )/1000;
                      factor=factor.toFixed(3);
                      
                      $("#ingdisp span").each(function() {
                        resize($(this),factor,resizeerror);
                      });
                      if (resizeerror>0) {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Unable to resize recipe as there is a problem with one or more of the ingredient quantities.<br>The quantity field should only contain numbers.<br>Check your recipe on the edit recipe page for any problems.');
                            $('.message_box').show();
                      } else {
                            $('.message_box').addClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Recipe resized');
                            $('.message_box').show();
                            $('#revertmsg').show();
                      }
                  } else {
                      $('.message_box').removeClass('ok');
                      $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >A new yield must be entered');
                      $('.message_box').show();
                  }    
               }
               $('.messi').remove();                            
            }        
         });                
      } else {    
         $(".message_box").removeClass('ok');
         $(".message_box").html('<img class="close_message"  src="images/ok.png">The recipe must have a yield before it can be resized.');
         $(".message_box").show();
      }
    }    
});
    $(document).on('click', ".rlink", function() {
        var admin=$('#admin').val();
        var client=$('#client').val();
        if($('#toprhdr a').html()=='Welcome') {
            addrecipemenu();
        }
        clearrecipe();
        if($(this).is('[id]')) {
            var id = $(this).attr("id").substr(1);
        } else {
            var idclass = $.grep($(this).attr('class').split(" "), function(v, i){
                return v.indexOf('i') === 0;
            })
            var id = idclass[0].substr(1);
        }
        $("input[name='id']").val(id);
        if(!$('#unapproved').val()) {
            $.cookie('rid',id, { path: '/' });
            var rowner = $(this).attr('class').split(' ')[1].substr(1);
            $("input[name='rowner']").val(rowner);
            $.cookie('rowner',rowner, { path: '/' });
            loadrecipe(id,rowner);
        } else {
            loadrecipe(id,null);
        }
    });
    //edit recipe, only alow admins or owner to edit
    $(document).on('click', ".editrecipe", function() {
      if ($('#admin').val()=='yes' || $('#uid').val() == $('#rowner').val()) {
         document.form1.action='add-recipe.php?edit=Edit';
         $('#form1').submit();
      } else {    
         $(".message_box").removeClass('ok');
         $(".message_box").html('<img class="close_message"  src="images/ok.png">You are only able to edit your own recipes.');
         $(".message_box").show();
         return false;
      }    
   });
   //delete recipe confirmation
   $(document).on('click', ".delrecipe", function() {
      if ($('#admin').val()=='yes' || $('#uid').val() == $('#rowner').val()) {
         if ($('#admin').val()=='yes') {
            var mess = 'Are you sure you want to PERMANENTLY delete this recipe?';
            var title = 'Delete Confirmation';
         } else if ($('#uid').val() == $('#rowner').val()) {
            var mess = 'Are you sure you want to PERMANENTLY remove this recipe?';
            var title = 'Removal Confirmation';
         }
         new Messi(mess, {
            title: title,
            buttons: [{id: 0, label: 'Yes', val: 'Y'},     
            {id: 1, label: 'No', val: 'N'}], 
            callback: function(val) {    
               if (val=='Y') {
                  $('.messi').remove();    
                  $('.message_box').addClass('ok');
                  $('.message_box').html('Deleting Recipe...');
                  $('.message_box').show();
                  
                  var numrec= $('#numrec').text();
                  numrec = parseInt(numrec) - 1;
                  $('#numrec').text(numrec);
                  if(numrec==0) {
                      $.removeCookie('rid', { path: '/' });
                      $.removeCookie('rowner', { path: '/' });
                  }
                  
                  if($('#unapproved').val()) {
                     var numunapp= $('#numunapp').text();
                     numunapp = parseInt(numunapp) - 1;
                     $('#numunapp').text(numunapp); 
                  }
        
                  var currid =$('#id').val();
                  
                  $(".i" + currid).each(function() {
                      if ($(this).hasClass('hassubcat')) {
                        var cat = $(this).closest('li.cat').attr('id');
                        var subcat = $(this).closest('li.subcat').attr('id');
                        $(this).parent().remove();
                        cat=cat.replace('/', '\/' );
                        subcat=subcat.replace('/', '\/' );
                        if($("[id='" + subcat + "'] > ul > li").length==0) {
                              $("[id='" + subcat + "']").remove();
                        }
                        if($("[id='" + cat + "'] > ul > li").length==0) {
                            $("[id='" + cat + "']").remove();
                        }
                      } else {
                          var cat = $(this).closest('li.cat').attr('id');
                          cat=cat.replace('/', '\/' );
                          $(this).parent().remove();
                          if($("[id='" + cat + "'] > ul > li").length==0) {
                                $("[id='" + cat + "']").remove();
                          }
                      }
                  });
                  
                    var inData = "";
                    var ct=0;
                      
                    function appGET(data, str) {
                        if (data && data != 'undefined') {
                        data = encodeURIComponent(html_entity_decode(data));
                        if (ct == 0) {
                            inData += str + '=' + data;
                        } else {
                            inData += '&' + str + '=' + data;
                        }
                        ct++;
                        }
                    }
                    appGET($('#id').val(), 'id');
                    appGET($('#admin').val(), 'admin');
                    appGET($('#unapproved').val(), 'unapproved');
                    
                    $.post("includes/ajaxdelrecipe.php",inData,function(data) {
                        if(data=="nodb"){
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                            return false;
                        }
                          var parsed = data.split('|');
                          var id = parsed[0];
                          var rowner = parsed[1];  
                          
                          clearrecipe();
                          if(id) {    
                              $("input[name='id']").val(id);
                              if(!$('#unapproved').val()) {
                                  $("input[name='rowner']").val(rowner);
                                  $.cookie('rid',id, { path: '/' });
                                  $.cookie('rowner',rowner, { path: '/' });
                                  loadrecipe(id,rowner);
                              } else {
                                  loadrecipe(id,null);
                              }
                          } else {
                              $('#norecipes').show();
                              $('#recopt').hide();
                              if(!$('#unapproved').val()) {
                                  $.removeCookie('rid', { path: '/' });
                                  $.removeCookie('rowner', { path: '/' });
                              } else {
                                  $('.appbuttons').hide();                          
                              } 
                          }
                          $('.message_box').addClass('ok');
                          $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Recipe Deleted');
                          $('.message_box').show();
                    });                                
               }    
            }        
         });
         return false
      } else {
         new Messi("You are unable to remove this recipe as you didn't add it.", {
            title: 'Removal Notification',
            buttons: [{id: 0, label: 'OK', val: 'Y'    }], 
            callback: function(val) {    
               $('.messi').remove();    
            }        
         });
         return false;
      }
   });
   $(document).on('click', ".addfav", function() {
       $('.message_box').addClass('ok');
       $('.message_box').html('Adding to favorites...');
       $('.message_box').show();
        
       var inData = "";
       var ct=0;
         
       function appGET(data, str) {
           if (data && data != 'undefined') {
           data = encodeURIComponent(html_entity_decode(data));
           if (ct == 0) {
               inData += str + '=' + data;
           } else {
               inData += '&' + str + '=' + data;
           }
           ct++;
           }
       }
       appGET($('#id').val(), 'id');
       
       $.post("includes/ajaxaddfav.php",inData,function(data) {
           if(data=="nodb"){
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                return false;
           }
       });
       
       if($('#favs').length==0) {
           var fhtml = "<li id=favs><a class='sb-toggle-submenu' href='javascript:void(0);'>Favorites<span class='sb-caret'></span></a>";
           fhtml += '<ul class="sb-submenu">';
           fhtml += "<li><a href='javascript:void(0);' class='rlink o"+$('#rowner').val()+"' id=i"+$('#id').val()+">"+$("input[name='name']").val()+"</a></li>";
           fhtml += '</ul></li>';
           $('#recnav ul:first').prepend(fhtml);
       } else {
           fhtml = "<li><a href='javascript:void(0);' class='rlink o"+$('#rowner').val()+"' id=i"+$('#id').val()+">"+$("input[name='name']").val()+"</a></li>";
           $('#favs ul').append(fhtml);
       }
       $('.message_box').addClass('ok');
       $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Added to Favorites');
       $('.message_box').show();       
   });
   $(document).on('click', ".delfav", function() {
       $('.message_box').addClass('ok');
       $('.message_box').html('Removing from favorites...');
       $('.message_box').show();
                        
       var inData = "";
       var ct=0;
         
       function appGET(data, str) {
           if (data && data != 'undefined') {
           data = encodeURIComponent(html_entity_decode(data));
           if (ct == 0) {
               inData += str + '=' + data;
           } else {
               inData += '&' + str + '=' + data;
           }
           ct++;
           }
       }
       appGET($('#id').val(), 'id');
       
       $.post("includes/ajaxdelfav.php",inData,function(data) {
           if(data=="nodb"){
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                return false;
           }
       });
       
       var currid =$('#id').val();
       $('#i' + currid).parent().remove();
       
       if($('#favs > ul > li').length==0) {
            $('#favs').remove();
       }
                  
       $('.message_box').addClass('ok');
       $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Removed from Favorites');
       $('.message_box').show();
   });
   //fullscreen view
   $(document).on('click', ".fs", function() {
      $("link[rel=stylesheet][media=screen]").attr({href : "css/fsrecipe.css"});
      $(".nm").eq(1).css('margin-top','10px');
   });
   // back to normal view
   $(document).on('click', ".nm", function() {
      $("link[rel=stylesheet][media=screen]").attr({href : "css/style.css"});
   });    
});
