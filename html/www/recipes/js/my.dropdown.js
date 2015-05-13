$(document).ready(function(){
    var popovers = $.cookie('popovers');
    if(popovers=='true') {
        $(".sb-toggle-left").popover({
             placement: 'bottom',
             content: 'Click to view menu',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
        $(".sb-toggle-right").popover({
             placement: 'left',
             content: 'Click to view page help',
             trigger: 'hover',
             delay: { show: 350, hide: 100 },
             html: true
        });
    }
    $(document).on('click', ".deldb", function() {
        var owner = $(this).attr('id');                        
        new Messi('Are you sure you want to PERMANENTLY delete all the accounts and recipes in your shared database?', {
            title: 'Remove Account Confirmation',
            buttons: [{id: 0, label: 'Yes', val: 'Y'}, 	
            {id: 1, label: 'No', val: 'N'}], 
            callback: function(val) {	
                if (val=='Y') {	
                    $.post("includes/deletedb.php",{owner:owner} ,function(data){
                        if(data.substring(0,3)=='yes') {
                            window.location ="index.php?deleted=yes";
                        } else {
                            new Messi("Sorry we're having technical issues, please try again soon...", {
                                title: 'Error',
                                width: '300px'
                            });
                        }
                    });
                    return false;								
                }
                $('.messi').remove();
            }
        });
    });
});