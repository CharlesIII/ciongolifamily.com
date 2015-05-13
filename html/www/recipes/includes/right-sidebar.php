<?php
	if(curPageName()=='display.php') {
        echo "<br class=noprint><b>CONVERTING AND RESIZING RECIPES</b><br class=noprint><br class=noprint>
        <p><strong>Please note: </strong>recipes containing units of measure in languages other than english may not resize or convert properly. If you wish to use these functions, please contact me with the details.</p>
        <p><strong>Please note: </strong>Lots of units of measure vary around the world. Cups, tablespoons (Australia uses a 20ml tablespoon), pints, quarts, fluid ounces and gallons are a few examples. You can check out the different values for these under Help > International Volume Measures</p>
        <p>If there is a range in an ingredients quantity e.g. 1-2 cups, only the lower amount will be used.</p>
        <br class=noprint><b>RESIZING RECIPES</b><br class=noprint><br class=noprint>
        <p>If there are related recipes for your recipe, you will be given the option to resize them as well.</p>
		<p>They will only be resized if they have a yield, and will be resized to match the new yield you enter in the popup box. So this works best if the yield in your main recipe matches that in the related recipes</p>";
        echo "<br class=noprint><b>CONVERTING RECIPES</b><br class=noprint><br class=noprint>
        <p>Related recipes will not be converted.</p>
        <br class=noprint><b>MOVE RECIPES TO A DIFFERENT RECIPE TYPE/CATEGORY</b><br class=noprint><br class=noprint>
        <p>Drag recipes from the menu to a different recipe type/category header. To let you know the recipe type you will be dropping your recipe into it will turn blue, and a category will turn green when you are over them.</p>
        <p>The category change will be automatically saved to your database. So there is no need to edit/save the recipe.</p>
        ";
	} else if (curPageName()=='add-recipe.php') {
		echo "<br class=noprint>
        <p>If you add a new recipe with the same name as an existing one, then you will have two copies of the recipe. The existing recipe will not be overwritten.</p>
		<p>If you are editing an existing recipe, then this recipe will be updated.</p>
		<p>Fields marked with an * are required.</p>
        <p>You can change the ingredient order simply by dragging the grey area on either end to move it to another spot.</p>
		<p>If you enter a full url in the source field (starting with http://) you will be able to link directly from your recipe to the source url. <strong>Please Note</strong> urls are subject to change, if the recipe is important to you I would not rely on the url alone to access it.</p>
		<p>All input boxes on this page (except for Rating and number only inputs) will bring up a list of your current values after typing a few letters, so you can select one of them if you like, or enter a new one. The diets and related recipes inputs, work similarly, but allow you to select or enter multiple values. If you start typing after a comma, the dropdown will appear again according to what you have typed.</p>
		<p>Define titles for sections of ingredients (e.g. SAUCE) by entering an ingredient with no other values. Any ingredients entered in this manner will be capitalized automatically. If you don't want this to happen, in the case where you might not want to enter a quantity, then put something in the 'Preparation/Note' field (e.g. to taste).</p>
		<p>Use CTRL/SHIFT to select multiples in the Diet and Related Recipes selection boxes. To unselect an item press CTRL, then click on the item. To add a new diet, select 'Other'.</p>
		<br class=noprint><br class=noprint><b>ADDING IMAGES, VIDEOS OR PDF FILES</b>
		<br class=noprint>
		<br class=noprint>
        <p>You can upload a maximum of 10 images and one pdf or video per recipe</p>
		<p>Once you've added some files to the 'select files' box you can drag them around to change the order, or double click on the file name to change it if you wish - before you upload.</p>
		<p>
		Please ensure your image names don't contain any special characters like % or '. Only Images - jpg, jpeg, gif, png Videos - flv, mp4, ogv, webm or pdf files are allowed. <strong>Videos will not be displayed on mobile devices</strong>
		</p>";
	} else if(curPageName()=='import_multi_recipes.php') {
		print("<br class=noprint><strong>Overwrite Existing Recipes</strong><br class=noprint><br class=noprint>If you choose this option, any overwritten recipes contained in saved menus will be lost,<br class=noprint>but if you <strong>don't</strong> you will end up with duplicate recipes.<br class=noprint><br class=noprint>
				<p>Use the 'Add' button to locate recipe files on your computer (*.csv,*.mmf). Then click the 'Upload' button to import the recipes.</p>
				<p>Any double quotes will automatically be replaced with 'inch' so the import doesn't fail.</p>
				<p>To see the required format for any CSV file to be imported <a class=link href=import_format.php>Click Here</a></p>");
	} else if(curPageName()=='pasterecipe.php') {
		print("<br class=noprint><strong>Paste or type your recipe in the box:</strong><br class=noprint><br class=noprint>
                    <p>Then select each part of the recipe, the name for example, and click the appropriate button underneath 'Recipe Sections' on the left of the recipe box to assign it.</p>
                    <p>Ingredients can be selected all at once, no need to tag each one separately.</p>
                    <p>You will see tags added at the beginning and end of your selection. If you make a mistake, just delete the incorrect tags, and repeat the process. These tags, and any text not tagged will not appear in your recipe once imported.</p>
                    <p>Once all parts you want to keep are tagged, click 'Add'. You will then be taken to another page where you can add an image, check the recipe and make any changes before saving it.</p>
                    <p><strong>Note: Only works for ENGLISH units of measure at the moment (any help with translation would be appreciated!!)</strong></p>
                    <p>A complicated formula is used to interpret the ingredients for your recipe, and though this will work with complete accuracy most of the time,it is important to check your recipe thoroughly before saving it. Certain <a class=link href='pasterules.php'>rules and assumptions</a> are used when adding the recipe.</p>");
	} else if(curPageName()=='upload_multi_images.php') {
		echo "Use the 'Browse Images...' button to locate images on your computer, if you don't see this button,
			<br class=noprint>please download the latest Flash plugin <a href='http://get.adobe.com/flashplayer/' target='_blank'>here.</a>
			<br class=noprint><br class=noprint>Then click the 'Upload Images' button to upload the images.
			<br class=noprint><br class=noprint>Multiple images can be selected at once using the CTRL and SHIFT keys.
			<br class=noprint><br class=noprint>Only .jpg, .jpeg, .png, .gif and .pdf images are allowed.";
	} else if(curPageName()=='ebook.php') {
		echo '<br class=noprint><p>The text size used in your eBook will be the same as that you have chosen as the text size on your pages.</p>
               <p>If you choose to have a Table of Contents or Category Title Pages in your eBook then your recipes will be organised using the
                recipe types & categories defined for your recipes. Otherwise they will be sorted alphabetically.</p><p>The Title will appear on the front cover of
                your eBook.</p>';
	} else if(curPageName()=='menuplanner.php') {
		echo '<p class=noprint>Drag recipes from the menu to add to the meal plan. To let you know the slot you will be dropping your recipe into it will turn blue when you are over it.</p>
			<p class=noprint>To remove a recipe click the <img id=di src=images/del.png> next to it.</p>
			Type a name in the Meal Plans box and click the Save button to save a new meal plan.</p>
            <p class=noprint>Load a saved menu by selecting from the Meal Plans dropdown.</p>
			<p class=noprint><strong>Please Note:</strong> To print the menu use landscape mode. In Internet Explorer and Firefox in File > Page Setup make sure Print Background is checked if you want the purple headers.</p>';
	} else if(curPageName()=='shopping-list.php') {
		echo '<br class=noprint>Load a saved shopping list by selecting it from the "saved shopping lists" dropdown.
            <br class=noprint><br class=noprint>If you are out shopping with your phone and only want to view the shopping list itself just click the shopping button (only available if you have items in your list), ensure the left menu is closed before doing this.
			<br class=noprint>When in shopping mode drag and drop functionality is turned off by default as it can be annoying when trying to scroll through your list. If you need it to move an ingredient into an aisle then you can just turn it back on by hitting the Drag On button. You can then turn it back off again by hitting the Drag Off button,
            <br class=noprint><br class=noprint><strong>Adding Items to the Shopping List</strong>
			<br class=noprint><br class=noprint>Open the bar labelled "Add Aisles, Ingredients or Recipes" by clicking on the plus sign on the right.
			<br class=noprint><br class=noprint>To add items manually, select them from the list of ingredients or other items. They will be added to the box below. Then you can edit the items to add quantities if required in the format 1 cup sugar, or type items directly into the box. The items should be one per line. Once you hit the add button, the items will be added to the list.
			<br class=noprint><br class=noprint>To add a recipe to your shopping list, open the menu on the left and drag it from the menu to the "Drop Recipes Here" box, when you arefinished adding recipes click Add Recipes. The ingredients will be added to your shopping list with either the recipe image (if there is one) or the recipe name alongside, so you can keep track of what ingredients belong to what recipe.
			<br class=noprint><br class=noprint><strong>Removing Items from the Shopping List</strong>
			<br class=noprint><br class=noprint>To remove an item from the shopping list, check it. It will be moved into a section at the bottom titled "In Trolley". To add it back simply uncheck it.
			<br class=noprint><br class=noprint>To remove all the items for a particular recipe, just click on the image or name next to one of the items that is currently checked. To add them back click again.
			<br class=noprint><br class=noprint><strong>Saving the Shopping List</strong>
			<br class=noprint><br class=noprint>Type a name in the Saved Shopping Lists box and click the Save button to create/save a new shopping list.
			<br class=noprint><br class=noprint><strong>Managing Aisles</strong>
            <br class=noprint><br class=noprint>Open the bar labelled "Add Aisles, Ingredients or Recipes" by clicking on the plus sign on the right.
			<br class=noprint><br class=noprint>Select an existing aisle from the Aisles dropdown or type in a new one then click Add Aisle to add it to your Shopping List.
			<br class=noprint><br class=noprint>To add/move ingredients to an aisle, click and drag an item to the aisle header/title. When the desired aisle title is highlighted blue, drop the item. To move multiple items, press shift and click on each one then drag them (the items will stack on top of each other while you drag) in the same way. The aisle will be saved in your database for these ingredients and will apply to all future shopping lists.';
	} else if(curPageName()=='orderaisles.php') {
		echo '<br class=noprint>Click on the arrows and drag aisles up or down to change their order.<br class=noprint><br class=noprint>
			<p>Once you move an aisle the new aisle order will be saved for all shopping lists.</p>';
	} else if(curPageName()=='email.php') {
		echo '<strong>Fields marked with * are mandatory</strong><br class=noprint><br class=noprint>
		<p>Enter as many names and email addresses as you like in the respective boxes, separated by a comma.<br class=noprint><br class=noprint>There must be the same number of each, and they must be in the same order.</p>';
	} else if(curPageName()=='excl-list.php') {
		echo "<br class=noprint>Here you can manage the list of ingredients you don't ever want to appear in your shopping lists<br class=noprint><br class=noprint>
		        Use CTRL/SHIFT to select multiple ingredients.<br class=noprint>
			To unselect an item press CTRL, then click on the item.<br class=noprint>
			Click on the list and type a letter to jump to it.<br class=noprint><br class=noprint>
			Uncheck items you don't want to exclude before saving.<br class=noprint><br class=noprint>
			<p><strong>Note: </strong>Clearing the list does not remove the entries from your database. To remove them completely, just save the empty list.</p>";
	} else if(curPageName()=='search.php') {
		echo '<br class=noprint><strong>Search Results:</strong><br class=noprint><br class=noprint>
				<p>The search results will appear in the menu in the left panel. If you click on a recipe in the menu, it will open in a new window, so you can return to your search results.</p>
				<strong>Recipe list search:</strong><br class=noprint><br class=noprint>
				<p>Use CTRL/SHIFT to select multiple recipes. To unselect an item press CTRL, then click on the item. Click on the list and type a letter to jump to it.</p>
				<strong>Ingredients At Hand search:</strong><br class=noprint><br class=noprint>
                <p>Enter one ingredient per line.<br class=noprint>To allow for single and multiple ingredient names (i.e. potato or potatoes) enter both on one line separated by a comma.</p>';
	} else if(curPageName()=='userpref.php') {
		echo "<br class=noprint>Choose your default settings for Web Recipe Manager here.<br class=noprint><br class=noprint>
				<strong>General: </strong>
				<p>If you check 'Recipe Approval Required' all recipes added by users other than administrators will not be visible until an administrator has approved them.</p>
				<strong>Recipe: </strong><br class=noprint><p>Choosing a default measurement system will not change your recipes in any way. This setting will just be used to pre-populate the value when you add a new recipe. This setting is intended to be used to remember the measurement system used in the country you got the recipe from. This helps you to use the right cup size, etc.</p>
				<strong>Login: </strong>
				<p>If you don't choose to display a welcome screen at log in, the recipe most recently modified or added will be displayed.</p>
                <strong>Resizing & Conversion of Recipes:</strong>
                <p>The first 3 options in this section are required for resizing recipes, and converting recipes you have found in other countries to the measurements, etc you prefer to use. All recipe conversions will automatically convert to the format you select with the 'Convert recipes to this format' preference. The weights preference is intended for people who live in regions or countries where some people still use Imperial measures, while others use the metric equivalent.</p>
                ";
	} else if(curPageName()=='usermgmt.php'){
		echo "<br class=noprint><strong>Admin Access</strong><br class=noprint><br class=noprint>
                <p>Giving a user Admin access allows them to do the following:</p>
                <ul><li>Permanently delete recipes.</li>
                <li>Approve recipes (if you have selected the 'Recipes Need Approval' option in Account->Preferences)</li>
                <li>Manage user access</li>
                <li>Create users</li>
                <li>Manage recipe types & categories</li>
                <li>Manage recipe comments</li>
                </ul>
                <br class=noprint><br class=noprint>
                <strong>Guest Access</strong><br class=noprint><br class=noprint>
                <p>Giving a user Guest access gives them read only access</p>";
	} else if(curPageName()=='createusers.php'){
		echo "<br class=noprint><strong>Admin Access</strong><br class=noprint><br class=noprint>
                <p>Giving a user Admin access allows them to do the following:</p>
                <ul><li>Permanently delete recipes.</li>
                <li>Approve recipes (if you have selected the 'Recipes Need Approval' option in Account->Preferences)</li>
                <li>Manage user access</li>
                <li>Create users</li>
                <li>Manage recipe types & categories</li>
                <li>Manage recipe comments</li>
                </ul>
                <br class=noprint><br class=noprint>
                <strong>Guest Access</strong><br class=noprint><br class=noprint>
                <p>Giving a user Guest access gives them read only access</p>
		<br class=noprint><br class=noprint><strong>Email Notification</strong><br class=noprint><br class=noprint>
		<p>New users will receive an email including their login details<p>";
	}  else if(curPageName()=='manage-deleted-recipes.php'){
		echo "<p>These recipes have been deleted by users of your shared database who don't have admin access, and therefore don't have access to permanently delete recipes. These recipes are no longer visible to any users in your shared database. You now have the opportunity to decide whether these recipes should really be deleted permanently or not.</p>
				<p>If you decide to retain a recipe, the recipe will be visible to all users again and you will be the new owner of the recipe.</p>";
	} else if(curPageName()=='normalise.php' || curPageName()=='normalise-cat.php' || curPageName()=='normalise-preprep.php' || curPageName()=='normalise-subcat.php' || curPageName()=='normalise-unit.php' || curPageName()=='normalise-yu.php' || curPageName()=='normalise-recipe.php') {
        echo "<p>Changes made here, including global conversion to lower case or title case, will not be reflected in your recipes until you have clicked the 'Apply Changes' button</p>
                <p>Click on column headings to sort data</p>";
        if(curPageName()!='normalise-recipe.php') {
            echo "<p>If you select a recipe from the dropdown it will display in a new window/tab. Make sure you don't have the welcome screen displayed on your recipe page, otherwise this will not work.</p>
            <p>Items that are used in recipes or shopping lists cannot be deleted.</p>";
        }
                     
    } 
        
?>

