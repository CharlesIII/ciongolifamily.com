$(window).load(function () {
   loadlist()
});
function removefromtrolley(key,pkey) {
    $('#div' + key).removeClass('noprint').removeClass('ui-multidraggable-element').show();
    $('#div' + key + ' input.chk').prop('checked',false);
    $('#divt' + key).addClass('noprint').hide();
    $('#h' + pkey).removeClass('noprint').show();
    if ($('#dragothers div.drop').length > $('#dragothers div.noprint').length) {
        $('#dragothers').removeClass('noprint').show();
    }
    var tdivs = $('#trolley div.drop').length;
    var thidden = $('#trolley div.drop:hidden').length;
    if (tdivs == thidden) {
        $('#trolley').hide();
    }
}
function addtotrolley(key, pkey) {
    if ($('#divt' + key).length==0) {
        var html='<div id="divt' + key + '" class="drop ui-draggable noprint" name="divt' + key + '">' + $('#div' + key).html() + '</div>'; 
        if ($('#trolley').length==0) {
            $('#list').append('<div id=trolley class=noprint><span class=h><strong>In Trolley</strong></span></div>');
        }
        $('#trolley').append(html);
        $('#divt' + key + ' label').css("text-decoration", "line-through");
        $('#divt' + key + ' input.chk').prop('checked',true);
        $('#trolley').show();
    } else {
        $('#divt' + key).show();
        $('#divt' + key + ' input.chk').prop('checked',true);
        $('#trolley').show();
    }
    $('#div' + key).addClass('noprint').hide();
    if (pkey) {
        var divs=$('#a' + pkey + ' div.drop').length;
        var hidden=$('#a' + pkey + ' div.noprint').length;
        if (divs == hidden) {
            $('#h' + pkey).addClass('noprint').hide();
        }
    }
    if ($('#dragothers div.drop').length == $('#dragothers div.noprint').length) {
        $('#dragothers').addClass('noprint').hide();
    }
}
function descending( a, b ) {
    return b - a;
}
function randomIntFromInterval(min,max){
    return Math.floor(Math.random()*(max-min+1)+min);
}
function slotaisle(aisle_order,divahtml) {
    var match='no';
    var ids = $(".hasorder[id]")         // find spans with ID attribute
      .map(function() { return this.id.substring(1); }) // convert to set of IDs
      .get();
    ids = ids.sort(descending);
    $.each( ids, function( i, val ) {
        if(parseInt(val) < parseInt(aisle_order)) {
            $('#a' + val).after(divahtml);
            match='yes';
            return false;   
        }
    });
    if(match!='yes') {
       $('#list').prepend(divahtml); 
    }
}                                 
function parselist(data) {
	var ingindex = $('#ingnum').val();
	if (!ingindex) {ingindex=0;}
	var curraisles = $('#aislenum').val();
	if (!curraisles) {curraisles = 0;}
    var rand = $('#rand').val();
    if (!rand) {rand = randomIntFromInterval(1000,9999);}
	for (i in data.ings) {
        var item = data.ings[i].item;
		var aisle = data.ings[i].aisle;
		var image = data.ings[i].image;
		var name = data.ings[i].name;
		var recid = data.ings[i].recid;
		var ing = data.ings[i].ing;
        var aisle_order = data.ings[i].aisle_order;
        var numings = data.ings.length;
        var ct = parseInt(i) + 1;
		divhtml = "<div id=div" + ingindex + " name=div" + ingindex + " class='drop";
		if (aisle) {
			divhtml += " inaisle";
		}
		divhtml += "'><input type=checkbox id=chk" + ingindex + " name=chk" + ingindex + "  class='chk css-checkbox'><label for=chk" + ingindex + " class=css-label>" + item + "</label>";
		if (recid) {
			if (image) {
				if (name && name.length>22) {
					name=name.substr(0,19) + '...';
				}
				divhtml += " <img class=recimg id=rec" + ingindex + " src='images/recipe/" + image + "' alt='" + name + "' title='" + name + "'>";
			} else if(name){
				divhtml += "<span class=recspan id=rec" + ingindex + "> (" + name + ")</span>";
			}
		}
		divhtml += "</div><input id='item" + ingindex + "' type=hidden name='item" + ingindex + "' value='" + item + "'><input id='ing" + ingindex + "' type=hidden name='ing" + ingindex + "' value='" + ing + "'><input id='recid" + ingindex + "' type=hidden name='recid" + ingindex + "' value='" + recid + "'></div>";

		if (aisle == null) {
			if ($('#dragothers').length==0 && curraisles>0) {
				$('#list').append("<div id=dragothers><div class=header><span class=h><strong class=rheader>Other Items</strong></span></div></div>");
				$('#dragothers').append(divhtml);
			} else if (curraisles>0) {
				$('#dragothers').append(divhtml);
			} else {
				$('#list').append(divhtml);
			}
		} else {
            (function($){
                $.expr[':'].text = function(obj, index, meta, stack){
                    return ($(obj).text() === meta[3])
                };
            })(jQuery);     
            var olddiv=$('strong:text("' + aisle + '")').parent().attr('id');
			//var olddiv = $("strong:contains(" + aisle + ")").parent().attr('id');
            //var olddiv=$('strong').filter(function(aisle) {
              // return ($(this)[0].textContent == aisle);
             //}).parent().attr('id');
             //var olddiv = $('strong').filter(function(aisle){ return $(this).text() == aisle; }).parent().attr('id');
			if (olddiv) {
				var key=olddiv.match(/\d+$/);
				$('#a' + key).append(divhtml);
			} else {
                if(aisle_order) {
				    var divahtml="<div id=h" + aisle_order + " class='drag hasorder'><span class=h id=s" + aisle_order + "><strong>" + aisle + "</strong></span><img class=aisledel src=images/extrasmall_delete.png><img class=aisleedit src=images/extrasmall_edit.png><img class=aislerem src=images/extrasmall_remove.png></div><div id=a" + aisle_order + ">" + divhtml + "</div>"
				    if (curraisles>0) {
                        slotaisle(aisle_order,divahtml);
				    } else {
					    $('#list').prepend(divahtml);
				    }
                } else {
                    var divahtml="<div id=h" + rand + " class='drag hasorder'><span class=h id=s" + rand + "><strong>" + aisle + "</strong></span><img class=aisledel src=images/extrasmall_delete.png><img class=aisleedit src=images/extrasmall_edit.png><img title='Remove Aisle from Shopping List' class=aislerem src=images/extrasmall_remove.png></div><div id=a" + rand + ">" + divhtml + "</div>"
                    if($('#dragothers').length==0) {
                        $('#list').append(divahtml);
                    } else {
                       $('#dragothers').before(divahtml); 
                    }
                    rand = parseInt(rand) + 1;
                }
				curraisles = parseInt(curraisles) + 1;
			}
		}
		ingindex=parseInt(ingindex)+1;
	}    
	$("#ingnum").val(ingindex);
	$("#aislenum").val(curraisles);
    $("#rand").val(rand);
	
}
function dragdrop() {
	$(".drop").multidraggable({
		helper: 'clone',
        revert: false,
        containment: "#list",
        cursorAt: { left: 5, top: 5 }
	});
	$(".drag, #dragothers").droppable({
        hoverClass: "ui-state-hover",
		drop: function() {
            var dropelem = $(this).attr("id");
			if (dropelem=='dragothers') {
				aisle='Other Items';
			} else {
				var dropnum= dropelem.substring(1);
				var aisle = $('#s' + dropnum + ' strong').html();
			}
			if ($('.ui-multidraggable-element').length>0) {
				var itemnum;
				$.each($('.ui-multidraggable-element'), function(){
					itemnum = $(this).attr('name');
					itemnum = itemnum.substring(3);
					if (aisle=='Other Items') {
						$('#div' + itemnum).appendTo($('#dragothers'));
						$('#div' + itemnum).removeClass('inaisle');
					} else {
						$('#div' + itemnum).appendTo($('#a' + dropnum));
						$('#div' + itemnum).addClass('inaisle')
						$("#a" + dropnum).show();
					}
					$('#div' + itemnum).removeClass('ui-multidraggable');

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
					appGET(aisle, 'aisle');
					appGET($('#ing' + itemnum).val(), 'ing');

					$.post("includes/ingaisle.php",inData,function(data) {
                        if(data=="nodb"){
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                            return false;
                       }
                    });
				});
			} else {
				var itemnum = $('.ui-draggable-dragging').attr('name');
				itemnum = itemnum.substring(3);
				if (aisle=='Other Items') {
					$('#div' + itemnum).appendTo($('#dragothers'));
					$('#div' + itemnum).removeClass('inaisle');
				} else {
					$('#div' + itemnum).appendTo($('#a' + dropnum));
					$('#div' + itemnum).addClass('inaisle')
					$("#a" + dropnum).show();
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
				appGET(aisle, 'aisle');
				appGET($('#ing' + itemnum).val(), 'ing');

				$.post("includes/ingaisle.php",inData,function(data) {
                    if(data=="nodb"){
                        $(".message_box").removeClass('ok');
                        $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                        return false;
                   }
                });
			}
			var ingnum=$('#ingnum').val();
			if (itemnum<ingnum && !$("#dragothers").length) {
				$("#list").append("<div id=dragothers><div class=header><span class=h><strong class=rheader>Other Items</strong></span></div></div>");
                $('.drop').each(function() {
                      if(!$(this).hasClass('inaisle')) {
                          $(this).appendTo("#dragothers");
                      }
                });
			}
			$('.inaisle').each(function() {
				if (!$(this).attr('id')) {
				    $(this).remove();
				}
			});

			var inaisles=$('.inaisle').length;
			if (inaisles==ingnum) {
				$('#dragothers').remove();
			}
            $(".drop").multidraggable({
                helper: 'clone',
                revert: false,
                containment: "#list",
                cursorAt: { left: 5, top: 5 }
            });
		}
	});
}
function validateEmail(email) {
    	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(email);
}

function emaillist() {
	new Messi('Enter email address and a name below to send this list.<br><br>', {
		title: 'Email Shopping List',
		buttons: [{id: 0, label: 'Send', val: 'Y'	},
		{id: 1, label: 'Cancel', val: 'N'}],
		inputs: [{id: 0, label: "Name", fid: "name"},
		{id: 1, label: "Email Address", fid: "lemail"}],
		callback: function(val) {
			if (val=='Y') {
				if($('#list').children().length==0) {
					$('.messi').remove();
					$(".message_box").removeClass('ok');
					var msg = 'Please Add or Select a List to Email';
					$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
					$(".message_box").show();
				} else if(!validateEmail($('#lemail').val())) {
					$('.messi').animate({opacity: 1}, 600);
					$(".message_box").removeClass('ok');
					var msg = 'The email address is invalid';
					$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
					$(".message_box").show();
				} else if (!$('#name').val()) {
					$('.messi').animate({opacity: 1}, 600);
					$(".message_box").removeClass('ok');
					var msg = 'A name must be entered';
					$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
					$(".message_box").show();
				} else {
					var msg = 'Sending...';
					$(".message_box").addClass('ok');
					$(".message_box").html(msg);
					$(".message_box").show();
					var messagetext='';
					var item='';
					var h=0;
					$('#list').children().children().each(function () {
						if (($(this).hasClass('h') && $(this).parent().attr('id')!='trolley') || $(this).hasClass('header') && !$(this).hasClass('noprint')) {
							h = h+1;
							if (h>1) {
								messagetext +=	'<br>';
							}
                            messagetext += $(this).text().toUpperCase() + '<br>';
						} else if ($(this).hasClass('drop') && !$(this).hasClass('noprint')) {
							messagetext += $(this).find('label').html()  + '<br>';
						}
					});
					$('#list').children().each(function () {
						if ($(this).hasClass('drop') && !$(this).hasClass('noprint')) {
							item=$(this).find('label').html();
							if (item.indexOf('(') === -1) {
								item += '(' + $(this).find('img').attr('alt') + ')';
							}
							messagetext += item  + '<br>';

						}
					});
					if (messagetext=='') {
						var msg = 'Your shopping list has no items';
						$(".message_box").removeClass('ok');
						$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
						$(".message_box").show();
						$('.messi').remove();
					} else {
						$.post("includes/email_list.php",{first:$('#name').val(),email:$('#lemail').val(),mess:messagetext} ,function(data) {
							$('.messi').remove();
							if(data=='yes') {
								var msg = 'Email Sent';
								$(".message_box").addClass('ok');
								$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
								$(".message_box").show();
							} else if(data=='nodb') {
                                var msg = 'Unable to connect to database';
                                $(".message_box").removeClass('ok');
                                $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                                $(".message_box").show();
                            } else {
								$(".message_box").removeClass('ok');
								$(".message_box").html('<img class="close_message"  src="images/ok.png">' + data);
								$(".message_box").show();
							}
						});
					}
				}
			} else {
				$('.messi').remove();
			}
		}
	});
	return false;
}
function loadlist() {
    var listid = $('#slist').combobox('value');
    if (listid!='' && typeof(listid)!='undefined' && listid!=null) {
         $.post('includes/ajaxsavedlist.php',{listid:listid}, function(data) {
            if(data=='nodb') {
                var msg = 'Unable to connect to database';
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                $(".message_box").show();
                return false;
            }
            $(".list").html(null);
            $("#ingnum").val(0);
            $("#aislenum").val(0);
            $("#rand").val('');
            $('.shopping').hide();
            if(data!="noitems") {
                data = JSON.parse(data);
                parselist(data);
            }
            $('.shopping').show();
            $('.lloaded').show();
            dragdrop();
            popovers();
         });
    }
}
function addrecipeings(recipes) {
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
    for (i in recipes) {
        if (recipes[i].ing) {
            if(i==0) {
                var recipelist = recipes[i].ing;
            } else {
                recipelist =recipelist + "," + recipes[i].ing;
            }
        } else {
            if(i==0) {
                var recipelist = recipes[i];
            } else {
                recipelist =recipelist + "," + recipes[i];
            }
        }
         
    }
    appGET(recipelist, 'recipelist');

    $.post("includes/addrecipeings.php", inData, function(data) {
        if(data=='nodb') {
            var msg = 'Unable to connect to database';
            $(".message_box").removeClass('ok');
            $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
            $(".message_box").show();
            return false;
        } else if(data=='noings'){
            var msg = 'The added recipe/s have no ingredients';
            $(".message_box").removeClass('ok');
            $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
            $(".message_box").show();
            return false;
        }
        data = JSON.parse(data);
        parselist(data);
        $('.shopping').show();
        $('.lloaded').show();
        dragdrop();
        popovers();
    });
}
function savelist() {
    //remove all the class add the messagebox classes and start fading
        $(".message_box").addClass('ok');
        $(".message_box").html('Saving....');
        $(".message_box").show();
        
        var listname=$("#combo1").val();
        var oldid=$('#slist').combobox('value');

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
        
        appGET($("#slist").combobox('value'), 'id');
        appGET(listname, 'list');
        var ingnum=$('#ingnum').val();
        appGET(ingnum, 'ingnum');
    
        for (i=0;i<ingnum;i++) {
            appGET($('#item' + i).val(), 'listitem' + i);
            appGET(!$('#chk' + i + ':checked').val(), 'chk' + i);
            appGET($('#ing' + i).val(), 'ing' + i);
            appGET($('#recid' + i).val(), 'recid' + i);
        }
        $.post("includes/savelist.php",inData,function(data) {
            if(data=="nodb"){
                 $(".message_box").removeClass('ok');
                 $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                 return false;
            }
            var parsed = data.split('|');
            var id = parsed[0];
            if (id>0) {
               var newlist = parsed[2];
               if (newlist==1) {
                    $('#slist').append($('<option>', { 
                        value: id,
                        text : listname 
                    }));
                    $('#slist').combobox('value', id);
               } else {
                   $("#slist option[value="+oldid+"]").remove();
                   $('#slist').append($('<option>', { 
                        value: id,
                        text : listname 
                    }));
                   $('#slist').combobox('value', id);
               }
            }
            var msg = parsed[1];
            if (msg=='Shopping List Saved') {
                    $(".message_box").addClass('ok');
                } else {
                    $(".message_box").removeClass('ok');
                }
            $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
        });
}
function addaisletolist() {
    var aisleid = $("#aisle").combobox('value');
    var aisle = $("#combo2").val();
   if (aisleid) {
        var aisles = '';
        $('.h').each(function() {
            aisles += "'" + $(this).html() + "',";
        });
    }
    
    aisles += "'" + aisle + "'";
    
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
    appGET(aisle, 'aisle');
    appGET(aisles, 'aisles');
    appGET(aisleid, 'aisleid');
   
    if (aisle!='' && typeof(aisle)!='undefined' && aisle!=null) {
        $.post('includes/addaisle.php',inData, function(data) {
               if(data=='nodb') {
                    var msg = 'Unable to connect to database';
                    $(".message_box").removeClass('ok');
                    $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                    $(".message_box").show();
                    return false;
               }
               var order=data;
               var aislenum = $("#aislenum").val();
               var ingnum = $("#ingnum").val();
               var rand = $("#rand").val();
               if (!rand) {rand = randomIntFromInterval(1000,9999);}
               if (aislenum=="") {
                   aislenum=0;
               }
               if (order=='ok') {
                   var divahtml="<div id='h" + rand + "' class='drag'><span id=s" + rand + " class=h><strong>" + aisle + "</strong></span><img class=aisledel src=images/extrasmall_delete.png><img class=aisleedit src=images/extrasmall_edit.png><img class=aislerem src=images/extrasmall_remove.png></div><div id=a" + rand + "></div>";
                   if (aislenum==0) {
                       $("#list").prepend(divahtml);
                       if ($('.inaisle').length<ingnum && !$("#dragothers").length) {
                           $("#list").append("<div id=dragothers><div class=header><span class=h><strong class=rheader>Other Items</strong></span></div></div>");
                           $('.drop').each(function() {
                                 if(!$(this).hasClass('inaisle')) {
                                     $(this).appendTo("#dragothers");
                                 }
                           });
                       }
                   } else {
                       if($('#dragothers').length==0) {
                           $('#list').append(divahtml);
                       } else {
                          $('#dragothers').before(divahtml); 
                       }
                   }
                   $('#aisle').next().children().first().val('');
                   $("#aisle option").prop("selected", false);
                   var nextaisle = parseInt(aislenum)+1;
                   $("#aislenum").val(nextaisle);
                   var nextrand = parseInt(rand)+1;
                   $("#rand").val(nextrand);
                   dragdrop();
                   popovers();
               } else {
                   var divahtml = "<div id='h" + order + "' class='drag'><span id=s" + order + " class=h><strong>" + aisle + "</strong></span><img class=aisledel src=images/extrasmall_delete.png><img class=aisleedit src=images/extrasmall_edit.png><img class=aislerem src=images/extrasmall_remove.png></div><div id=a" + order + "></div>";
                   if (aislenum>0) {
                       slotaisle(order,divahtml);
                   } else {
                       $('#list').prepend(divahtml);
                       if ($('.inaisle').length<ingnum && !$("#dragothers").length) {
                           $("#list").append("<div id=dragothers><div class=header><span class=h><strong class=rheader>Other Items</strong></span></div></div>");
                           $('.drop').each(function() {
                                 if(!$(this).hasClass('inaisle')) {
                                     $(this).appendTo("#dragothers");
                                 }
                           });
                       }
                   }
                   $('#aisle').next().children().first().val('');
                   $("#aisle option").prop("selected", false);
                   var nextaisle = parseInt(aislenum)+1;
                   $("#aislenum").val(nextaisle);
                   dragdrop();
                   popovers();
               }
        });
    
    }
}
function popovers() {
    var popovers = $.cookie('popovers');
    if(popovers=='true') {
        $("#accordion").popover({
             placement: 'top',
             content: 'Click to hide or show the content for adding aisles, ingredients and recipes',
             trigger: 'hover',
             html: true
        });
        $("#combo1").popover({
             placement: 'top',
             content: 'Select an existing list to load it or type in a new name when saving a new list',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#combo2").popover({
             placement: 'right',
             content: 'Select an existing aisle or type in a new one and click Add Aisle to add it to the shopping list',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#rdrop").popover({
             placement: 'top',
             content: 'Drag recipes from the left menu then click Add Recipes to add them to your shopping list',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#other").popover({
             placement: 'top',
             content: 'Select ingredients from the dropdown then click Add Ingredients to add them to the shopping list, you can add quantities as well if you like in the format 1 cup rice by editing each line',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $(".aisledel:first").popover({
             placement: 'top',
             content: 'Delete aisle',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $(".aisleedit:first").popover({
             placement: 'top',
             content: 'Change aisle name',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $(".aislerem:first").popover({
             placement: 'top',
             content: 'Remove aisle from this list',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
    }
}
$(function() {
        $( "#accordion" )
        .accordion({
            collapsible : true, 
            active : false,
            autoHeight : false,
            activate: function(event, ui) {
                $("#sb-site").show()[0].scrollIntoView(true);
            }
         });
         
});
$(document).ready(function(){
    $("#slist").combobox({ 
            select: function (event, ui) {
                loadlist();
            } 
        }
    );
    $("#aisle").combobox();
    popovers();
    $(document).on('click', "#adda", function() {
        addaisletolist();
    });    
	$(document).on('click', ".shopping", function() {
      $("link[rel=stylesheet][media=screen]").attr({href : "css/shopping.css"});
      $('.drop').draggable("destroy");
      $('#draqgtoggle').val('Drag On');
   });
   $(document).on('click', "#norm", function() {
      $("link[rel=stylesheet][media=screen]").attr({href : "css/style.css"});
      dragdrop();
   });
   $(document).on('click', "#dragtoggle", function() {
      if ($('#dragtoggle').val()=='Drag On') {
          dragdrop();
          $('#dragtoggle').val('Drag Off');
      } else {
          $('.drop').draggable("destroy");
          $('#dragtoggle').val('Drag On');
      }
   });
	$(document).on('click', "#addr", function() {
		if ($('#rdrop').html()) {
            var recs = $('#recipelist').val();
            var recipes = new Array();
            recipes = recs.split(",");
			addrecipeings(recipes);
            $('#rdrop').html(null);
            $('#rdropped').val('');
            $('#recipelist').val('');
		}
		return false;
	});
	$('.rlink').attr('href','#');
	$(".rlink").draggable({
		helper: 'clone',
		revert: false,
		start: function(event, ui) {
			$('.sb-left').css('overflow-y','visible');
			$('#sb-site').css('z-index','0');
		},
		stop: function(event, ui) {
                        $('.sb-left').css('overflow-y','auto');
			$('#sb-site').css('z-index','1');
		}
	});
	$("#rdrop").droppable({
        hoverClass: "ui-state-hover",
		drop: function(event,ui) {
			var i = $('#rdropped').val();
			if (!i) {i=0;}
			var name = $('.ui-draggable-dragging').text();
			var newhtml = '<table><tr><td><img id=img' + i + ' src=images/del.png></td><td>' + name + '</td></tr></table>';
			$("#rdrop").append(newhtml);
			$("#rdrop").height($("#rdrop").innerHeight() + 16);
			if($(ui.draggable).is('[id]')) {
                var id = $(ui.draggable).attr("id").substr(1);
            } else {
                var idclass = $.grep($(ui.draggable).attr('class').split(" "), function(v, i){
                    return v.indexOf('i') === 0;
                })
                var id = idclass[0].substr(1);
            }
			if (i==0) {
				$('#recipelist').val(id);
			} else {
				$('#recipelist').val($('#recipelist').val() + ',' + id);
			}
			i=parseInt(i)+1;
			$('#rdropped').val(i);
		}
	});
	dragdrop();
    popovers();
	$('#ings').change(function() {
		var ingid = $(this).val();
		if (ingid>0) {
			var ing = $("option:selected", this).text();
			$(this).val(0);

			var txt = $('#other');
			if (txt.val()) {
				txt.val(txt.val() + '\n' + ing);
			} else {
				txt.val(ing);
			}
		}
	});
	$(document).on('click', "#add", function() {
		if ($('#other').val()) {
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
            
			$.post("includes/slparseing.php", inData, function(data) {
                if(data=='nodb') {
                    var msg = 'Unable to connect to database';
                    $(".message_box").removeClass('ok');
                    $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                    $(".message_box").show();
                    return false;
                }
				data = JSON.parse(data);
                parselist(data);
                $('.shopping').show();
                $('.lloaded').show();
                dragdrop();
                popovers();
				$('#other').val('');
			});
		}
		return false;
	});
	//edit aisle confirmation
	$(document).on('click', ".aisleedit", function() {
		var aislenum=$(this).parent().attr('id');
		aislenum=aislenum.substring(1);
		var aisle=$('#s' + aislenum + ' strong').html();
		new Messi('', {
			title: 'Edit Aisle',
			buttons: [{id: 0, label: 'Save', val: 'Y'},
					{id: 1, label: 'Cancel', val: 'N'}],
			inputs: [{id: 0, label: "Aisle", fid: "aisle", value: aisle}],
			callback: function(val) {
				if (val=='Y') {
					var newaisle=$('#aisle').val();
					$('#s' + aislenum).html('<strong>' + newaisle + '</strong>');

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
					appGET(aisle, 'aisle');
					appGET(newaisle, 'newaisle');
					$.post("includes/updaisle.php",inData,function(data) {
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
	//remove aisle confirmation
	$(document).on('click', ".aislerem", function() {
		var aislenum=$(this).parent().attr('id');
		aislenum=aislenum.substring(1);
		var aisle=$('#s' + aislenum).html();
		new Messi('Are you sure you want to remove the ' + aisle + ' aisle from this shopping list only?', {
			title: 'Remove Aisle',
			buttons: [{id: 0, label: 'Yes', val: 'Y'	},
						{id: 1, label: 'No', val: 'N'}],
			callback: function(val) {
				if (val=='Y') {
					$('#h' + aislenum).remove()
					$('#aislenum').val(parseInt($('#aislenum').val())-1);
					$('#div' + aislenum).removeClass('inaisle');
                    if ($('#a' + aislenum).html()) {
                        if (!$('#dragothers').length) {
                            $('#list').append('<div id=dragothers><div class=header><span class=h><strong class=rheader>Other Items</strong></span></div></div>');
                        }
					    $('#dragothers').append($('#a' + aislenum).html());
                    }
					$('#a' + aislenum).remove();
					if ($('#aislenum').val()==0) {
						$('#dragothers.header').remove();
                        $('#list').append($('#dragothers').html());
                        $('#dragothers').remove();
					}
				}
				$('.messi').remove();
			}
		});
	});
	//delete aisle confirmation
	$(document).on('click', ".aisledel", function() {
		var aislenum=$(this).parent().attr('id');
		aislenum=aislenum.substring(1);
		var aisle=$('#s' + aislenum + ' strong').html();
		new Messi('Are you sure you want to PERMANENTLY delete the ' + aisle + ' aisle from all shopping lists?', {
			title: 'Delete Aisle',
			buttons: [{id: 0, label: 'Yes', val: 'Y'	},
						{id: 1, label: 'No', val: 'N'}],
			callback: function(val) {
				if (val=='Y') {
					$('#h' + aislenum).remove()
					$('#aislenum').val(parseInt($('#aislenum').val())-1);
					$('#div' + aislenum).removeClass('inaisle');
					if ($('#a' + aislenum).html()) {
                        if (!$('#dragothers').length) {
                            $('#list').append('<div id=dragothers><div class=header><span class=h><strong class=rheader>Other Items</strong></span></div></div>');
                        }
                        $('#dragothers').append($('#a' + aislenum).html());
                    }
					$('#a' + aislenum).remove();
					if ($('#aislenum').val()==0) {
                        $('#dragothers.header').remove();
                        $('#list').append($('#dragothers').html());
                        $('#dragothers').remove();
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
					appGET(aisle, 'aisle');

					$.post("includes/delaisle.php",inData,function(data) {
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
	//delete shopping list confirmation
	$(document).on('click', ".delete", function() {
		new Messi('Are you sure you want to PERMANENTLY delete this shopping list?', {
			title: 'Delete Confirmation',
			buttons: [{id: 0, label: 'Yes', val: 'Y'},
			{id: 1, label: 'No', val: 'N'}],
			callback: function(val) {
				if (val=='Y') {
                    var lid=$('#slist').combobox('value');    
					$.post("includes/delslist.php",{list:lid},function(data) {
                        if (data=='ok') {
                            $('.message_box').addClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Shopping List Deleted');
                            $('.message_box').show();
                            $('.lloaded').hide();
                            $("#slist > option:selected").remove();
                            $('#slist').combobox('value', null);                            
                            $('#list').html(null);
                        } else {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No Shopping List Selected');
                            $('.message_box').show();
                        }
                    });
				}
				$('.messi').remove();
			}
		});
		return false;
	});
	$(document).on('click', ".recimg, .recspan", function() {
		var okey = $(this).parent().attr('id').substr(3);
        if ($.isNumeric(okey)){
			if ($(this).hasClass('recimg')) {  
				var chk = $(this).attr('src');
				$('img[src="' + chk + '"]').each(function () {
					var key = $(this).attr('id').substr(3);
					var pkey = $(this).parent().parent().attr('id').substr(1);
					addtotrolley(key,pkey);
				});
			} else {
				var chk = $(this).html();
				$('span').each(function () {
					if ($(this).html() == chk) {
						var key = $(this).attr('id').substr(3);
                        var pkey = $(this).parent().parent().attr('id').substr(1);
						addtotrolley(key,pkey);
					}
				});
			}
		} else {
            if ($(this).hasClass('recimg')) {
				var chk = $(this).attr('src');
				$('img[src="' + chk + '"]').each(function () {
					var key = $(this).attr('id').substr(3);
                    var pkey = $(this).parent().parent().attr('id').substr(1);
					removefromtrolley(key,pkey);
				});
			} else {
				var chk = $(this).html();
				$('span').each(function () {
					if ($(this).html() == chk) {
						var key = $(this).attr('id').substr(3);
                        var pkey = $(this).parent().parent().attr('id').substr(1);
						removefromtrolley(key,pkey);
					}
				});
			}
		}
	});
    /*$(document).on('click', ".css-label", function(e) {
        alert($(this).attr('class'));
        e.preventDefault();
    });*/
    $(document).on('click', ".chk", function(e) {
        if (e.shiftKey) {
            return false;
        } else {
            if($(this).attr('id')) {
                var key = $(this).attr('id').substr(3);
            } else {
                var key=$(this).attr('for').substr(3);
            }
            if ($(this).parent().hasClass('inaisle')) {
		        var pkey = $(this).parent().parent().attr('id').substr(1);
            }
		    if ($(this).is(':checked')){
			    addtotrolley(key,pkey);
		    } else {
                removefromtrolley(key,pkey);    
		    }
        }
	});
	$(document).on('click', ".clear", function() {
		new Messi('Are you sure you want to remove all items from this shopping list?<br><strong>Note: </strong>Clearing the list does not remove the entries from your database. To remove them completely, just save the empty list.', {
			title: 'Clear Confirmation',
			buttons: [{id: 0, label: 'Yes', val: 'Y'	},
			{id: 1, label: 'No', val: 'N'}],
			callback: function(val) {
				if (val=='Y') {
					$(".list").html(null);
                    $("#ingnum").val(0);
					$("#aislenum").val(0);
                    $("#rand").val('');
				}
				$('.messi').remove();
			}
		});
		return false;
	});
	$(document).on('click', ".save", function() {
        if($('#trolley div:visible').length!=0) {
            new Messi('You have items in your trolley that will not be saved, are you sure you wish to proceed?', {
                title: 'Save Confirmation',
                buttons: [{id: 0, label: 'Yes', val: 'Y'    },
                {id: 1, label: 'No', val: 'N'}],
                callback: function(val) {
                    if (val=='Y') {
                        savelist();
                    }
                    $('.messi').remove();
                }
            });
        } else {
            savelist();
        }
		return false;
    });
});