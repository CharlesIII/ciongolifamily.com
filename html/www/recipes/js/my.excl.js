$(document).ready(function(){
	$(document).on('click', ".clear", function() {
		new Messi('Are you sure you want to remove all items from your exclusion list?<br><strong>Note: </strong>Clearing the list does not remove the entries from your database. To remove them completely, just save the empty list.', {
			title: 'Clear Confirmation',
			buttons: [{id: 0, label: 'Yes', val: 'Y'	}, 	
			{id: 1, label: 'No', val: 'N'}], 
			callback: function(val) {	
				if (val=='Y') {	
					$("#list").html(null);
					$("#exclnum").val(0);
				}
				$('.messi').remove();
			}		
		});
		return false;
	});
	$(document).on('click', "#add", function() {
		var html ='';
		var ingindex=$("#exclnum").val();
		$('option:selected','#ing').each( function() {
			var ing = this.text;
			var ingid = this.value;
			$(this).remove();
            html += "<div id=div" + ingindex + "><input type=checkbox id=chk" + ingindex + " name=chk" + ingindex + " checked class='chk css-checkbox' onclick='removeUnchecked(this);'>";
			html += "<label for=chk" + ingindex + " class=css-label>" + ing + "</label><input id='item" + ingindex + "' type=hidden name='item" + ingindex + "' value=" + ingid + "></div>";
			ingindex=parseInt(ingindex)+1;
		});
		$('#list').append(html);
		$('#exclnum').val(ingindex);
		$('#ing').attr('selectedIndex', '-1');
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
		appGET($('#exclnum').val(), 'exclnum');
		var exclnum=$('#exclnum').val();
		for (i=0;i<exclnum;i++) {
			appGET($('#item' + i).val(), 'item' + i);
			appGET($('#chk' + i + ':checked').val(), 'chk' + i);
		}
		$.post("includes/saveexcl.php",inData,function(data) {
            $.post("includes/ajaxexcl.php",function(newdata) {
				    $("#list").html(null);
					if(newdata) {
                        if(newdata=="nodb"){
                            $(".message_box").removeClass('ok');
                            $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.');
                            return false;
                       }
						var parsed = newdata.split('||');
						var ingnum = parsed[0];
						var itemids = parsed[1].split("|");
						var items = parsed[2].split("|");
						var len = items.length;
						var item = '';
						var itemid = '';
                        var html='';
						for (i=0;  i<len; i++ ){
							itemid=itemids[i];
							item=items[i];
							html += "<div id=div" + i + "><input type=checkbox id=chk" + i + " name=chk" + i + " checked class='chk css-checkbox' onclick='removeUnchecked(this);'>";
                            html += "<label for=chk" + i + " class=css-label>" + item + "</label><input id='item" + i + "' type=hidden name='item" + i + "' value=" + itemid + "></div>";
            
						}
						$("#list").html(html);
						$("#exclnum").val(ingnum);
					} else {
						$("#exclnum").val(0);
					}
			});
			if (data=='Exclusion List Saved') {
				$(".message_box").addClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">' + data);
			} else if(data=="nodb") {
                $(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">Unable to connect to database.');
            } else {
				$(".message_box").removeClass('ok');
                $(".message_box").html('<img class="close_message"  src="images/ok.png">' + data);
			}
			
		});
		return false;
    });                                                                         
});