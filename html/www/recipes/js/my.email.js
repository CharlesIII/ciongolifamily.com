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
$(document).ready(function(){
	$(document).on('click', "#back", function() {
		top.location.href = 'display.php';
	});
    $.post("includes/getemails.php", function(data) {
        if (data) {
            data = JSON.parse(data);
            $( "#input-name" )
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
                        data.emails, extractLast( request.term ) ) );
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
                        var name=ui.item.value.toString().split("(")[0].trim();
                        var email=ui.item.value.toString().split("(")[1].replace(')','');
                        if ($('#input-email').val()) {
                            $('#input-email').val($('#input-email').val()  + ',' + email);
                        } else {
                             $('#input-email').val(email);
                        }
                        
                        terms.push( name );
                        this.value = terms.join( "," );
                        return false;
                    }
    
            });
        }                   
    });
});