function sortings() {
    $("#sorting").sortable({
        scroll : true,
        placeholder: 'ui-state-highlight',
        start : function (event,ui) {
             ui.helper.css("background-color", "#a15883");
        },
        update : function (event,ui) {
            $( "#sorting" ).sortable( "disable" );
            var ct=0
            $('#sorting li').each(function() {
                var oldid=$(this).attr("id").substr(1);
                $(this).attr("id","l"+ct);
                $(this).find('#qty' +oldid).attr("id","qty"+ct);
                $(this).find('#unit' +oldid).attr("id","unit"+ct);
                $(this).find('#eqty' +oldid).attr("id","eqty"+ct);
                $(this).find('#eunit' +oldid).attr("id","eunit"+ct);
                $(this).find('#ing' +oldid).attr("id","ing"+ct);
                $(this).find('#pp1' +oldid).attr("id","pp1"+ct);
                $(this).find('#pp2' +oldid).attr("id","pp2"+ct);
                ++ct;
            });
            $( "#sorting" ).sortable( "enable" );
        },
        stop : function (event,ui) {
             $('#sorting li').css("background-color", "#ddd");
        }
    });
    $("#sorting").sortable({
        zIndex: 9999
    });
}
$(window).load(function () {
        $('.btn').removeAttr('disabled');
        $("#msgbox").hide();
});
function split( val ) {
  return val.split( /,\s*/ );
}

function extractLast( term ) {
   return split( term ).pop();
}
// Overrides the default autocomplete filter function to search only from the beginning of the string
$.ui.autocomplete.filter = function (array, term) {
    var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(term), "i");
    return $.grep(array, function (value) {
        return matcher.test(value.label || value.value || value);
    });
};
function convertTemp() {
     var c = document.getElementById('c'), f = document.getElementById('f');
     if(c.value != '') {
          f.value = Math.round(c.value * 9 / 5 + 32);
          c.value = '';
     } else  {
          c.value = Math.round((f.value - 32) * 5 / 9);
          f.value = '';
     }
}
$(document).ready(function(){
    sortings();
    var popovers = $.cookie('popovers');
    if(popovers=='true') {
        $("#sorting .ui-icon:lt(2)").popover({
             placement: 'top',
             content: 'Drag me to a new position.',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#yield").popover({
             placement: 'top',
             content: 'How many does it make, this can only be a number as it is used if you resize the recipe later.',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#yield_unit").popover({
             placement: 'top',
             content: 'Servings, Portions, etc',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#source").popover({
             placement: 'top',
             content: 'Where you got the recipe from. If you enter a full URL i.e. http://taste.com.au, it will appear as a link in your recipe',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#diet").popover({
             placement: 'top',
             content: 'Enter as many diets as you like separated by a comma. If you have already added diets to recipes before, they will appear in a dropdown below as you type, you can tnen select one to save you typing it again',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#related_recipe").popover({
             placement: 'top',
             content: 'Enter as many recipes as you like separated by a comma. Your existing recipes will appear in a dropdown below as you type, so you can select one. These recipes will be displayed along with this recipe when you view it',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#cat0").popover({
             placement: 'top',
             content: 'The recipe type e.g. Entree. This will determine where the recipe appears in the menu . You must specify at least one. Any recipe types you have used before will appear in a dropdown below as you type. You can select one if you wish, or enter a new one.',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#scat0").popover({
             placement: 'top',
             content: 'An optional recipe category e.g. Chicken',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#measure").popover({
             placement: 'top',
             content: 'The measurement system for the recipe. This is for your information only, and is intended to be used in the case where a recipe uses a different system than your own e.g metric, imperial. You can set a default for this in Account -> Preferences',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        /*$("#adding").popover({
             placement: 'bottom',
             content: 'Need to add more ingredients, click here to add more (up to 45 in total)',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });*/
        $("label[for='tried']").popover({
             placement: 'top',
             content: 'Yon can specify whether you have made the recipe before here',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $("#qtyo").popover({
             placement: 'top',
             content: 'Alternative quantity. Useful when you want to show 2 different ways of measuring an ingredient',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
    }
    $(document).on('click', "#sorting .ui-icon", function() {
        $(this).parent().toggleClass('liclicked');
    });    
    var ingsrc;
    var unitsrc;
    var ppsrc;
        $.post("includes/getingarrays.php", function(data) {
            data = JSON.parse(data);
            if(data.cats) {
                $( ".cat" ).autocomplete({
                    source: data.cats,
                    minLength:0
                });
            }
            if(data.scats) {
                $( ".scat" ).autocomplete({
                    source: data.scats,
                    minLength:1
                });
            }
            if(data.units) {
                unitsrc=data.units;
                $( ".unit" ).autocomplete({
                    source: data.units,
                    minLength:1
                });
            }
            if(data.ings) {
                ingsrc=data.ings;
                $( ".ing" ).autocomplete({
                    source: data.ings,
                    minLength:3
                });
            }
            if(data.pps) {
                ppsrc=data.pps;
                $( ".pp" ).autocomplete({
                    source: data.pps,
                    minLength:3
                });
            }
            if(data.srcs) {
                $( "#source" ).autocomplete({
                    source: data.srcs,
                    minLength:3
                });
            }
            if(data.cuisines) {
                $( "#cuisine" ).autocomplete({
                    source: data.cuisines,
                    minLength:0
                });
            }
            if(data.yield_units) {
                $( "#yield_unit" ).autocomplete({
                    source: data.yield_units,
                    minLength:0
                });
            }
            if(data.measures) {
                $( "#measure" ).autocomplete({
                    source: data.measures,
                    minLength:0
                });
            }
            
            $( "#related_recipe" )
                // don't navigate away from the field on tab when selecting an item
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                    // delegate back to autocomplete, but extract the last term
                    response( $.ui.autocomplete.filter(
                    data.recipes, extractLast( request.term ) ) );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    //terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }
            });
            $( "#diet" )
                // don't navigate away from the field on tab when selecting an item
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                    // delegate back to autocomplete, but extract the last term
                    response( $.ui.autocomplete.filter(
                    data.diets, extractLast( request.term ) ) );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    //terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }
            });
                            
        });
        
        $("#addrecipe").submit(function() {
                $(".message_box").addClass('ok');
                $(".message_box").html('Saving...');
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
        
                appGET($('#id').val(), 'id');
                appGET($('#added').val(), 'added');
                appGET($('#name').val(), 'name');
                appGET($('#directions').val(), 'directions');
                appGET($('#ing').val(), 'ing');
                appGET($('#preptime').val(), 'preptime');
                appGET($('#cooktime').val(), 'cooktime');
                appGET($('#addedby').val(), 'addedby');
                for(var i=0;i<10;i++){
                        appGET($('#newimage' + i).val(), 'newimage' + i);
                }
                for(var i=0;i<10;i++){
                        appGET($('#image' + i).val(), 'image' + i);
                }
                appGET($('#newpdf').val(), 'newpdf');
                appGET($('#pdf').val(), 'pdf');
                appGET($('#newvideo').val(), 'newvideo');
                appGET($('#video').val(), 'video');
                appGET($('#note').val(), 'note');
                appGET($('#yield').val(), 'yield');
                if ($('#tried').is(":checked")) {
                        appGET('on', 'tried');
                } else {
                        appGET('off', 'tried');
                }
                appGET($('#source').val(), 'source');
                appGET($('#cuisine').val(), 'cuisine');
                appGET($('#yield_unit').val(), 'yield_unit');
                appGET($('#rating').val(), 'rating');
                appGET($('#measure').val(), 'measure');
                
                for(var i=0;i<4;i++){
                        appGET($('#cat' + i).val(), 'cat' + i);
                        appGET($('#scat' + i).val(), 'scat' + i);
                }
        
                for(var i=0;i<45;i++){
                       appGET($('#unit' + i).val(), 'unit' + i);
                       appGET($('#eunit' + i).val(), 'eunit' + i);
                       appGET($('#ing' + i).val(), 'ing' + i);
                       appGET($('#pp1' + i).val(), 'pp1' + i);
                       appGET($('#pp2' + i).val(), 'pp2' + i);
                       appGET($('#qty' + i).val(), 'qty' + i);
                       appGET($('#eqty' + i).val(), 'eqty' + i);                        
                }        
        
                appGET($("#diet").val(), 'diet');
                appGET($("#related_recipe").val(), 'related_recipe');
        
                $.post("includes/save.php",inData,function(data) {
                        var parsed = data.split('|');
                        var msg = parsed[1];
                        if (msg=='Recipe Saved') {
                            var id = parsed[0];
                            $.cookie('rid',id, { path: '/' });
                            var rowner=parsed[2];
                            $.cookie('rowner',rowner, { path: '/' });
                        
                            var admin=$('#admin').val();
                            var rapp=$('#rapp').val();
                            if (rapp=='t' && admin!='yes') {
                                    $(".message_box").addClass('ok');
                                    $(".message_box").html('<img class="close_message"  src="images/ok.png">Recipe Saved - It will appear once checked by an administrator');
                            } else {
                                    top.location.href = 'display.php?search=yes';
                            }
                        } else if(msg.substring(0,4)=="Save"){
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
                        } else if(data=="nodb"){
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.');
                        } else {
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">' + data);
                        }
                });
                return false;
        });
        $(document).on('click', ".delpdf", function() {
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
                appGET($('#id').val(), 'recid');
                appGET($('#pdf').val(), 'pdfjpg');
       
                $.post("includes/delpdf.php",inData,function(data) {
                    if(data=="nodb"){
                        $(".message_box").removeClass('ok');
                        $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                    }
                });
                
                $('#newpdf').val(null);
                $('#pdf').val(null);
                $(this).hide();
                $('#pdfdisp').hide();
                $('#uploaderpdf').show();
                $('.pdfnote').show();
                return false;
        });
        $(document).on('click', ".delvideo", function() {
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
                appGET($('#id').val(), 'recid');
                appGET($('#video').val(), 'video');
       
                $.post("includes/delvideo.php",inData,function(data) {
                    if(data=="nodb"){
                        $(".message_box").removeClass('ok');
                        $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                    }
                });
                
                $('#newvideo').val(null);
                $('#video').val(null);
                $(this).hide();
                $('#videodisp').hide();
                $('#uploadervideo').show();
                $('.videonote').show();
                return false;
        });
        for(var i=0;i<10;i++){
                $(document).on('click', "#delimage" + i, function() {
          
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
                        appGET($('#id').val(), 'recid');
                        var slot=$(this).attr('id').substr(8)
                        appGET($('#image' + slot).val(), 'image');
            
                        $.post("includes/delimage.php",inData,function(data) {
                            if(data=="nodb"){
                                $(".message_box").removeClass('ok');
                                $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.').show();
                            }
                        });
                        $('#newimage' + slot).val(null);
                        $('#image' + slot).val(null);
                        var imagesleft=parseInt($('#imagesleft').val())+1;
                        $('#imagesleft').val(imagesleft);
                        $(this).hide();
                        $('#imagedisp' + slot).hide();
                        $('#uploader').show();
                        $('#imgnote').show();
                        return false;
                });
        }
        for(var i=0;i<10;i++){
                $(document).on('click', '#remimg' + i, function() {
                        var slot=$(this).attr('id').substr(6)
                        $('#newimage' + slot).val(null);
                        $('#image' + slot).val(null);
                        var imagesleft=parseInt($('#imagesleft').val())+1;
                        $('#imagesleft').val(imagesleft);
                        $(this).hide();
                        $('#imagedisp' + slot).hide();
                        $('#uploader').show();
                        $('#imgnote').show();
                        return false;
                });
        }
        $(document).on('click', '.rempdf', function() {
                $('#newpdf').val(null);
                $('#pdf').val(null);
                $(this).hide();
                $('#pdfdisp').hide();
                $('#uploaderpdf').show();
                $('.pdfnote').show();
                return false;
        });
        $(document).on('click', '.remvideo', function() {
                $('#newvideo').val(null);
                $('#video').val(null);
                $(this).hide();
                $('#videodisp').hide();
                $('#uploadervideo').show();
                return false;
        });
      
        $(document).on('click', '#adding', function() {
                var theLink = $('#adddiv').html();
                var user = $('#user').val();
                var classes = $(this).attr("class").split(' ');
                for (var i = 0; i < 2; i++) {
                    if (classes[i]!='btn') {
                        var x = classes[i];
                    }
                }
                var theCode = '<li id=' + x +'>' +
                    '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' +
                    '<div class="dib"><span class="iheaders idib"><strong>Qty</strong></span><input type="text" value="" class="smallinp form-control idib" id="qty' + x +'"></div>' +
                    '<div class="dib"><span class="iheaders idib"><strong>Unit</strong></span><input type="text" class="unit form-control idib ui-autocomplete-input" value="" style="width:110px;" id="unit' + x +'" autocomplete="off"></div>' +
                    '<div class="dib"><span class="iheaders idib"><strong>Qty2</strong></span><input type="text" value="" class="smallinp form-control idib" id="eqty' + x +'"></div>' +
                    '<div class="dib"><span class="iheaders idib"><strong>Unit2</strong></span><input type="text" class="unit form-control idib ui-autocomplete-input" value="" style="width:110px;" id="eunit' + x +'" autocomplete="off"></div>' +
                    '<div class="dib"><span class="iheaders idib"><strong>Ingredient</strong></span><input type="text" value="" style="width:210px;" id="ing' + x +'" class="ing form-control idib ui-autocomplete-input" autocomplete="off"></div>' + 
                    '<div class="dib"><span class="iheaders idib"><strong>Preprep</strong></span><input type="text" value="" style="width:180px;" id="pp1' + x +'" class="pp form-control idib ui-autocomplete-input" autocomplete="off"></div>' +
                    '<div class="dib"><span class="iheaders idib"><strong>Preprep</strong></span><input type="text" value="" style="width:180px;" id="pp2' + x +'" class="pp form-control idib ui-autocomplete-input" autocomplete="off"></div>' +
                    '<span class="barrow dib ui-icon ui-icon-arrowthick-2-n-s"></span></li>';
        
                newrow = parseInt(x) + 1;
                if (x>43) {
                        $('#adddiv').hide();
                } else {
                        $('#adddiv').html(theLink.replace(x,newrow));
                }
                $('#ingdiv' + x).replaceWith(theCode);
                $( ".unit" ).autocomplete({
                    source: unitsrc,
                    minLength:1
                });
                $( ".ing" ).autocomplete({
                    source: ingsrc,
                    minLength:3
                });
                $( ".pp" ).autocomplete({
                    source: ppsrc,
                    minLength:3
                });
                sortings();
                return false;
        });              
        $("#uploader").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : 'includes/upload.php',
		
		filters : {
			// Maximum file size
			max_file_size : '2mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Image files", extensions : "jpg,jpeg,gif,png,JPG"},
			],
            max_file_count: 10
		},

		// Rename files by clicking on their titles
		rename: true,
		
		// Sort files
		sortable: true,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		// Views to activate
		views: {
            list: true,
			thumbs: true, // Show thumbs
			active: 'thumbs'
		},

		// Flash settings
		flash_swf_url : 'includes//Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : 'includes//Moxie.xap',
		init: {
			FilesAdded: function(up,files) {
                var max=$('#imagesleft').val();
                $('.plupload_droptext').hide();
				plupload.each(files, function(file) {
                    if (up.files.length > max) {
                      $(".message_box").removeClass('ok');
                        $(".message_box").html("<img class='close_message' src='images/ok.png' >You can only add '" + max + "' more images");
                        $(".message_box").show();
                        return false;
                        up.removeFile(file);
                    }
					if (file.name.search(/'/) > 0) {
						$(".message_box").removeClass('ok');
						$(".message_box").html("<img class='close_message' src='images/ok.png' >The file '" + file.name + "' contains a ('), please remove and try again");
						$(".message_box").show();
						return false;
					} else if (file.name.search(/%/) > 0) {
						$(".message_box").removeClass('ok');
						$(".message_box").html("<img class='close_message' src='images/ok.png' >The file '" + file.name + "' contains a (%), please remove and try again");
						$(".message_box").show();
						return false;
					}
				});
			},
            UploadComplete: function(up,files) {
                    plupload.each(files, function(file) {
                            var i=0;
                            var slot=$('#imagenum').val();
                            $(".image").each(function() {
                                    if($(this).css('display') == 'none'){
                                            slot=i;
                                            return false;
                                    }
                                    i++;
                            });                                        
                            if (!slot) {
                                    var slot=0;           
                            }
                            $('#imagedisp' + slot).html('<img src="imagetmp/'+file.name+'"><br><a id=remimg' + slot + ' href="#">Replace image</a><input id=newimage' + slot + ' name=newimage' + slot + ' type=hidden value="'+file.name+'">');
                            $('#imagedisp' + slot).show();
                            if (slot==9) {
                               $('#uploader').hide();
                               $('.imgnote').hide();
                            }
                            $("#fserr").html(null);
                            var newimgnum=parseInt(slot)+1;
                            $('#imagenum').val(newimgnum);
                            var imagesleft=10 - parseInt(newimgnum);
                            $('#imagesleft').val(imagesleft);
                            if(imagesleft<1) {
                                $('#uploader').hide();
                                return false;
                            }                            
                    });
            }
		}
	});
        $("#uploaderpdf").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : 'includes/uploadpdf.php',
		
		filters : {
			// Maximum file size
			max_file_size : '2mb',
			// Specify what files to browse for
			mime_types: [
				{title : "PDF files", extensions : "pdf"},
			],
                        max_file_count: 1
		},

		// Rename files by clicking on their titles
		rename: true,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		// Views to activate
		views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },

		// Flash settings
		flash_swf_url : 'includes//Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : 'includes//Moxie.xap',
		init: {
			FilesAdded: function(up,files) {
				$('.plupload_droptext').hide();
				plupload.each(files, function(file) {
					if (file.name.search(/'/) > 0) {
						$(".message_box").removeClass('ok');
						$(".message_box").html("<img class='close_message' src='images/ok.png' >The file '" + file.name + "' contains a ('), please remove and try again");
						$(".message_box").show();
						return false;
					} else if (file.name.search(/%/) > 0) {
						$(".message_box").removeClass('ok');
						$(".message_box").html("<img class='close_message' src='images/ok.png' >The file '" + file.name + "' contains a (%), please remove and try again");
						$(".message_box").show();
						return false;
					}
				});
			},
            UploadComplete: function(up,files) {
                    plupload.each(files, function(file) {
                            var jpgname=file.name.replace('.pdf','.jpg');
                            jpgname=jpgname.replace(/ /g,'_');
                            var pdfname=file.name.replace(/ /g,'_');
                            $('#pdfdisp').html('<a class=rempdf href="#">Replace PDF</a><input id=newpdf name=newpdf type=hidden value="'+pdfname+'"><br><img src="imagetmp/'+jpgname+'">');
                            $('#uploaderpdf').hide();
                            $('#pdfdisp').show();
                            $('.pdfnote').hide();
                    });
            }
		}
	});
        $("#uploadervideo").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : 'includes/uploadvideo.php',
		
		filters : {
			// Maximum file size
			max_file_size : '180mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Videos", extensions : "flv,mp4,ogv,webm"},
			],
                        max_file_count: 1
		},

		// Rename files by clicking on their titles
		rename: true,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		// Views to activate
		views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },

		// Flash settings
		flash_swf_url : 'includes//Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : 'includes//Moxie.xap',
		init: {
			FilesAdded: function(up,files) {
				$('.plupload_droptext').hide();
				plupload.each(files, function(file) {
					if (file.name.search(/'/) > 0) {
						$(".message_box").removeClass('ok');
						$(".message_box").html("<img class='close_message' src='images/ok.png' >The file '" + file.name + "' contains a ('), please remove and try again");
						$(".message_box").show();
						return false;
					} else if (file.name.search(/%/) > 0) {
						$(".message_box").removeClass('ok');
						$(".message_box").html("<img class='close_message' src='images/ok.png' >The file '" + file.name + "' contains a (%), please remove and try again");
						$(".message_box").show();
						return false;
					}
				});
			},
            UploadComplete: function(up,files) {
                    plupload.each(files, function(file) {
                            var videoname=file.name.replace(/ /g,'_');
                            $('#videodisp').html('<input id=newvideo name=newvideo type=hidden value="'+videoname+'">'+videoname+'<br><a class=remvideo href="#">Replace Video</a>');
                            $('#uploadervideo').hide();
                            $('#videodisp').show();
                            $('.videonote').hide();
                    });
            }
		}
	});
});