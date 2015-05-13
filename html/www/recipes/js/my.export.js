/**
 * Select/deselect any matching checkboxes, radio buttons or option elements.
 */
$.fn.selected = function(select) {
   if (select == undefined) select = true;
   return this.each(function() {
      var t = this.type;
      if (t == 'checkbox' || t == 'radio')
         this.checked = select;
         else if (this.tagName.toLowerCase() == 'option') {
         var $sel = $(this).parent('select');
         if (select && $sel[0] && $sel[0].type == 'select-one') {
            // deselect all other options
            $sel.find('option').selected(false);
         }
         this.selected = select;
      }
   });
};
$(document).ready(function() {
   $(document).on('click', "#add", function() {
      $("#erecipelist  option:selected").appendTo("#erelated_recipe");
      $("#erelated_recipe").sortOptions();
      $("#erelated_recipe option").selected(true);


   });
   //If you want to move all item from fromListBox to toListBox
   $(document).on('click', "#addAll", function() {
      $("#erecipelist option").appendTo("#erelated_recipe");
      $("#erelated_recipe").sortOptions();
      $("#erelated_recipe option").selected(true);
   });
   //If you want to remove selected item from toListBox to fromListBox
   $(document).on('click', "#remove", function() {
      $("#erelated_recipe option:selected").appendTo("#erecipelist");
      $("#erecipelist").sortOptions();
   });
   //If you want to remove all items from toListBox to fromListBox
   $(document).on('click', "#removeAll", function() {
      $("#erelated_recipe option").appendTo("#erecipelist");
      $("#erecipelist").sortOptions();
   });
   $("form").submit(function() {
      $('.message_box').addClass('ok');
      $('.message_box').html('Exporting recipes...');
      $('.message_box').show();
      return true;
   });
   $(document).on('click', ".multselect", function() {
      $('#msg').html(null);
      $('#msg1').html(null);
   });
});