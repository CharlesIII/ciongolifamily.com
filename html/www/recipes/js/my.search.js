$(document).ready(function(){
    $(document).on('click', ".rlink", function() {
        
        var idclass = $.grep($(this).attr('class').split(" "), function(v, i){
            return v.indexOf('i') === 0;
        })
        var id = idclass[0].substr(1);
        
        $.cookie('rid',id, { path: '/' });
        var rowner = $(this).attr('class').split(' ')[1].substr(1);
        $.cookie('rowner',rowner, { path: '/' });
    });
    $("#search").submit(function(){
         $('.message_box').addClass('ok');
         $('.message_box').html('Searching...');
         $('.message_box').show();
         var ct=0;
         if ($('.kwd').val()) {ct++;}
         if ($('#search1').val()) {ct++;}
         if ($('#search2').val()) {ct++;}
         if ($('#rating').val()) {ct++;}
         if ($('#diet').val()) {ct++;}
         if ($('#cuisine').val()) {ct++;}
         if ($('#source').val()) {ct++;}
         if (ct==0) {
             $('.message_box').removeClass('ok');
             $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No search criteria has been selected');
             $('.message_box').show();
         } else if(ct>1) {
             $('.message_box').removeClass('ok');
             $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Only one search method can be used at a time');
             $('.message_box').show();
         } else if(ct==1) {
             if ($('#search1').val()) {
                 var id;
                 var idlist="";
                 var i=0
             
                 $('#search1').each(function() {
                     id=$(this).val();
                     if(i==0) {
                        idlist = id;
                     } else {
                        idlist += "," + id;
                     }
                 });
                 idlist = idlist.join(',')
                 $.post("includes/searchmenu.php",{idlist:idlist},function(data) {
                     if(data && data.indexOf("Document Contains no data.")==-1) {
                        $('#results').html(data);
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Search completed - results in left menu');
                        $('.message_box').show();
                    } else {
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No recipes meet your search criteria');
                        $('.message_box').show();
                    }
                 });
             } else if($('.kwd').val()) {
                var kw=$('.kwd').val().split(' ');
                var ownerid = $('#ownerid').val();
                $.post("includes/ajaxkwsearch.php",{kw:kw,oid:ownerid},function(data) {
                    if(data && data.indexOf("Document Contains no data.")==-1) {
                        $('#results').html(data);
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Search completed - results in left menu');
                        $('.message_box').show();
                    } else {
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No recipes meet your search criteria');
                        $('.message_box').show();
                    }
                 });        
             } else if($('#search2').val()) {
                 var ings = $('#search2').val();
                 var ownerid = $('#ownerid').val();
                 $.post("includes/ajaxingsearch.php",{ingredient:ings,oid:ownerid},function(data) {
                    if(data && data.indexOf("Document Contains no data.")==-1) {
                        $('#results').html(data);
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Search completed - results in left menu');
                        $('.message_box').show();
                    } else {
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No recipes meet your search criteria');
                        $('.message_box').show();
                    }
                 });       
             } else if($('#rating').val()) {
                 var rating = $('#rating').val();
                 var ownerid = $('#ownerid').val();
                 $.post("includes/ajaxrtsearch.php",{rating:rating,oid:ownerid},function(data) {
                    if(data && data.indexOf("Document Contains no data.")==-1) {
                        $('#results').html(data);
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Search completed - results in left menu');
                        $('.message_box').show();
                    } else {
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No recipes meet your search criteria');
                        $('.message_box').show();
                    }
                 });
             } else if($('#diet').val()) {
                 var diet = $('#diet').val();
                 var ownerid = $('#ownerid').val();
                 $.post("includes/ajaxdtsearch.php",{diet:diet,oid:ownerid},function(data) {
                    if(data && data.indexOf("Document Contains no data.")==-1) {
                        $('#results').html(data);
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Search completed - results in left menu');
                        $('.message_box').show();
                    } else {
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No recipes meet your search criteria');
                        $('.message_box').show();
                    }
                 });
             } else if($('#cuisine').val()) {
                 var cuisine=$('#cuisine').val();
                 var ownerid = $('#ownerid').val();
                 $.post("includes/ajaxcssearch.php",{cuisine:cuisine,oid:ownerid},function(data) {
                    if(data && data.indexOf("Document Contains no data.")==-1) {
                        $('#results').html(data);
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Search completed - results in left menu');
                        $('.message_box').show();
                    } else {
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No recipes meet your search criteria');
                        $('.message_box').show();
                    }
                 });
             } else if($('#source').val()) {
                 var source=$('#source').val();
                 var ownerid = $('#ownerid').val();
                 $.post("includes/ajaxscsearch.php",{source:source,oid:ownerid},function(data) {
                    if(data && data.indexOf("Document Contains no data.")==-1) {
                        $('#results').html(data);
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Search completed - results in left menu');
                        $('.message_box').show();
                    } else {
                        $('.message_box').addClass('ok');
                        $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >No recipes meet your search criteria');
                        $('.message_box').show();
                    }
                 });
             }
         }
         return false;
    });
});