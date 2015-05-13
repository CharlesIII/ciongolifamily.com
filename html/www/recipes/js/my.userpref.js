$(document).ready(function(){
    $("#measure").combobox();
    
    $("#support_form").submit(function() {
        $('.message_box').addClass('ok');
        $('.message_box').html('Updating your preferences...');
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
        var measureid = $("#measure").combobox('value');                                    
        appGET(measureid,'measureid');
        appGET($(".ui-combobox-input").val(), 'measure');
        appGET($('#title').val(), 'title');
        appGET($('#date').val(), 'date');
        var numfmtid=$('#numfmt').val();
        var numfmt=$("#numfmt option:selected").text();
        appGET(numfmtid,'numfmtid');
        if (!numfmt) {
            numfmt='notset';
        }
        $.cookie('numfmt',numfmt, { path: '/' });
        var fracdecid=$('#fracdec').val();
        if (!fracdecid) {
            var fracdec='notset';
        } else {
            if(fracdecid==0) {
                var fracdec='fraction';
            } else {
                var fracdec='decimal';
            }
        }
        appGET(fracdecid, 'fracdecid');
        if (!fracdec) {
            fracdec='notset;'
        }
        $.cookie('fracdec',fracdec, { path: '/' });
        var regionid=$('#region').val();
        var region=$("#region option:selected").text();
        appGET(regionid, 'regionid');
        if (!region) {
            region='notset'
        }
        $.cookie('region',region, { path: '/' });
        var grorozid=$('#groroz').val();
        if(grorozid==0) {
            groroz='metric';
        } else if(grorozid==1) {
            groroz='imperial';
        } else {
            groroz='notset';
        }
        appGET(grorozid, 'grorozid');
        $.cookie('groroz',groroz, { path: '/' });
        appGET($('#paper').val(), 'paper');
        if ($('#toc').is(":checked")) {
                appGET('on', 'toc');
        } else {
                appGET('off', 'toc');
        }
        if ($('#catt').is(":checked")) {
                appGET('on', 'catt');
        } else {
                appGET('off', 'catt');
        }
        if ($('#pdf').is(":checked")) {
                appGET('on', 'pdf');
        } else {
                appGET('off', 'pdf');
        }
        if ($('#welcome').is(":checked")) {
                appGET('on', 'welcome');
        } else {
                appGET('off', 'welcome');
        }
        if ($('#rapp').is(":checked")) {
                appGET('on', 'rapp');
        } else {
                appGET('off', 'rapp');
        }
        if ($('#popovers').is(":checked")) {
                appGET('on', 'popovers');
                var popovers=true;
        } else {
                appGET('off', 'popovers');
                var popovers=false; 
        }
        $.cookie('popovers',popovers, { path: '/' });
        $.post("includes/saveuserprefs.php",inData,function() {
            $('.message_box').addClass('ok');
            $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >Preferences saved');
            $('.message_box').show();
        });
        return false;
    });
});