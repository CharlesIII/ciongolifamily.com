
function loadmenu() {
    var menuid = $('#menu').combobox('value');
    if (menuid!='' && typeof(menuid)!='undefined' && menuid!=null) {
         $.post('includes/ajaxsavedmenu.php',{menuid:menuid}, function(data) {
            if(data=='nodb') {
                var msg = 'Unable to connect to database';
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                $(".message_box").show();
                return false;
            }
            $('.mloaded').show();
            $('.ui-droppable').html(null);
            
            var day = data.split('||');
            for ( var i=0, len=day.length; i<len; ++i ){
                items=day[i].split('|')
                itemday=items[2];
                itemorder=items[3];
                itemlink=items[0];
                itemrecipe=items[1];
                itemmeal=items[4];
                if (itemday==1) {
                    itemday='mon';
                } else if(itemday==2) {
                    itemday='tue';
                } else if(itemday==3) {
                    itemday='wed';
                } else if(itemday==4) {
                    itemday='thu';
                } else if(itemday==5) {
                    itemday='fri';
                } else if(itemday==6) {
                    itemday='sat';
                } else if(itemday==7) {
                    itemday='sun';
                }
                var td=$("#droppable" + itemday + itemmeal);
                var spans=td.find('span').length;
                var slotnumber = parseInt(spans) + 1;
                if (slotnumber>1) {
                    td.append('<hr>');
                }
                newhtml = "<span id=r" + itemrecipe + "><img title='Delete Item' src=images/del.png> <kbd>" + itemlink + "</kbd></span>";
                td.append(newhtml);
                var idinput = '<input type=hidden name=id[] value=' + itemrecipe + '>';
                $("#addmenu").append(idinput);
            }
         });
    }
}
function popovers() {
    var popovers = $.cookie('popovers');
    if(popovers=='true') {
        $("#droppablemonb").popover({
             placement: 'top',
             content: 'Drag recipes from the left menu to add to the planner. The slot will turn blue to indicate when you should drop the recipe',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#combo1").popover({
             placement: 'bottom',
             content: 'Select a saved menu plan from the dropdown to load it, or type a new name to save a new plan',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
    }
}
$(document).ready(function(){
    $("#menu").combobox({ 
            select: function (event, ui) {
                loadmenu();
            } 
        }
    );
    popovers();
	//delete menu plan confirmation
	$(document).on('click', ".delete", function() {
		new Messi('Are you sure you want to PERMANENTLY delete this menu?', {
			title: 'Delete Confirmation',
			buttons: [{id: 0, label: 'Yes', val: 'Y'}, 	
			{id: 1, label: 'No', val: 'N'}], 
			callback: function(val) {	
				if (val=='Y') {
                    var mid=$('#menu').combobox('value');
                    $.post("includes/delmenu.php",{menu:mid},function(data) {
                        if (data=='ok') {
					        $('.message_box').addClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Meal Plan Deleted');
                            $('.message_box').show();
                            $('.mloaded').hide();
                            $("#menu > option:selected").remove();
                            $('#menu').combobox('value', null);                            
                            $('.ui-droppable').html(null);
                        } else {
                            $('.message_box').removeClass('ok');
                            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No Meal Plan Selected');
                            $('.message_box').show();
                        }
                    });    	
				}
				$('.messi').remove();		
			}		
		});
		return false;
	});
	$(document).on('click', ".clear", function() {
		new Messi('Are you sure you want to clear this menu? All recipes will be removed.', {
			title: 'Clear Confirmation',
			buttons: [{id: 0, label: 'Yes', val: 'Y'	}, 	
					{id: 1, label: 'No', val: 'N'}], 
			callback: function(val) {	
				if (val=='Y') {	
					$('.ui-droppable').html(null);								
				}
				$('.messi').remove();
                $('.mloaded').hide();
                $('#menu').combobox('value',null);	
			}		
		});
		return false;
	});
	$(document).on('click', ".save", function() {
        //remove all the class add the messagebox classes and start fading
		$(".message_box").addClass('ok');
		$(".message_box").html('Saving....');
		$(".message_box").show();
	  
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
        var oldid=$('#menu').combobox('value');
        var menuname=$("#combo1").val();
		appGET(oldid, 'id');
		appGET(menuname, 'menu');
        var ict=0;
        $("#drop span").each(function() {
            var recid=$(this).attr('id').substr(1);
            appGET(recid, 'recid[' + ict + ']' );
            var link=$(this).find('kbd').html();
            appGET(link, 'link[' + ict + ']' );
            var day=$(this).parent().attr('id').substring(9,12);
            if (day=='mon') {
                day=1;
            } else if(day=='tue') {
                day=2;
            } else if(day=='wed') {
                day=3;
            } else if(day=='thu') {
                day=4;
            } else if(day=='fri') {
                day=5;
            } else if(day=='sat') {
                day=6;
            } else if(day=='sun') {
                day=7;
            }    
            appGET(day, 'day[' + ict + ']');
            var meal=$(this).parent().attr('id').substr(12);
            appGET(meal, 'meal[' + ict + ']');
            ++ict;
        });
		  
		$.post("includes/savemenu.php",inData,function(data) {
            if(data=="nodb"){
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                return false;
           }
			var parsed = data.split('|');
			var id = parsed[0];
			if (id>0) {
				var newmenu = parsed[2];
				if (newmenu==1) {
                    $('#menu').append($('<option>', { 
                        value: id,
                        text : menuname 
                    }));
                    $('#menu').combobox('value', id);
               } else {
                   $("#menu option[value="+oldid+"]").remove();
                   $('#menu').append($('<option>', { 
                        value: id,
                        text : menuname 
                    }));
                   $('#menu').combobox('value', id);
               }
			}
			var msg = parsed[1];
			if (msg=='Meal Plan Saved') {
				$(".message_box").addClass('ok');
			} else {
				$(".message_box").removeClass('ok');
			}
			$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
		});
		return false;
	});
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
    $("[id^=droppable]").droppable({
		hoverClass: "ui-state-hover",
		drop: function(event, ui) {
			var slot=$(this).attr('id').substr(9);
            var spans=$(this).find('span').length;
            var slotnumber = parseInt(spans) + 1;
            if (slotnumber>1) {
                $(this).append('<hr>');
            }
            slot=slot+slotnumber;
		    var link = $('.ui-draggable-dragging').text();
            if($(ui.draggable).is('[id]')) {
			    var id = $(ui.draggable).attr("id").substr(1);
            } else {
                var idclass = $.grep($(ui.draggable).attr('class').split(" "), function(v, i){
                    return v.indexOf('i') === 0;
                })
                var id = idclass[0].substr(1);
            }
			var newhtml = '<span id=r' + id + '><img title="Delete Item" src=images/del.png> <kbd>' + link + '</kbd></span>';
		    $(this).append(newhtml);
            var idinput = '<input type=hidden name=id[] value=' + id + '>';
            $('#addmenu').append(idinput);
		    $('.mloaded').show();
            var thisObj=$(this);
            $.post("includes/getrelrecipes.php",{id:id}, function(data) {
                if (data) {
                    data = JSON.parse(data);
                    var rrrows = data.relrecipes.length;
                    if (rrrows>0) {
                        for (i in data.relrecipes) {
                            var newid=data.relrecipes[i].relid;
                            var newname=data.relrecipes[i].relname;
                            newhtml = '<hr><span id=r' + newid + '><img title="Delete Item" src=images/del.png> <kbd>' + newname + '</kbd></span>';
                            thisObj.append(newhtml);
                            var ridinput = '<input type=hidden name=id[] value=' + newid + '>';
                            $('#addmenu').append(ridinput);
                        }
                     }                             
                }
            });
		}
	    });
	$(document).on('click', "#drop img", function() {
        var td=$(this).parent().parent();
		$(this).parent().remove();
        var tdhtml=td.html();
        if (tdhtml.search('<hr>')==0) {
            tdhtml=tdhtml.substr(4);
            td.html(tdhtml);
        }
	});
});