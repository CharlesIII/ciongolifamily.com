
String.prototype.titleCase = function () {
	var str = "";
	var wrds = this.split(" ");
	for(keyvar in wrds)
	{
	str += ' ' + wrds[keyvar].substr(0,1).toUpperCase()
	 + wrds[keyvar].substr(1,wrds[keyvar].length);
	}
   return str;
}
$(document).ready(function(){
	/*$( ".resizable" ).resizable({
		handles: "se"
	});*/
	$(document).on('click', "#prname", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[name]' + selectedText + '[/name]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#ping", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[ingredients]' + selectedText + '[/ingredients]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#pnote", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[note]' + selectedText + '[/note]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#pdirections", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[directions]' + selectedText + '[/directions]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#ppreptime", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[preptime]' + selectedText + '[/preptime]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#pcooktime", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[cooktime]' + selectedText + '[/cooktime]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#pyield", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[yield]' + selectedText + '[/yield]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#psource", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[source]' + selectedText + '[/source]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#pcuisine", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[cuisine]' + selectedText + '[/cuisine]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$(document).on('click', "#pdiet", function() {
		var obj = $("#recipe").getSelection();
		if (typeof obj.text != 'undefined') {
		    var selectedText = obj.text;
		    var newtext = '[diet]' + selectedText + '[/diet]';
		    $("#recipe").replaceSelection(newtext);
		} else {
		    var msg='No Text Selected';
				$(".message_box").removeClass("ok");
				$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
				$(".message_box").show();
		}
		return false;
	});
	$("#pasterecipe").submit(function(){
		$(".message_box").addClass("ok");
		$(".message_box").html('Adding Recipe...');
		$(".message_box").show();
		var recipe = $("#recipe").val();
		var tags = 0;
		var cct = -1;
		var scct = -1;
		var dct = -1;
		var header=new Array();
		if (recipe != '') {
		$.each(["preptime","source","cuisine","cooktime"], function(i,val){
		    if (recipe.indexOf("[" + val + "]")>-1) {
			tags = tags + 1;
			part=recipe.substring(recipe.indexOf("[" + val + "]") + 2 + val.length,recipe.indexOf("[/" + val + "]"));
			if (typeof part != 'undefined') {
			    part=part.replace( new RegExp( val + 's:', "i" ), "" );
			    part=part.replace( new RegExp( val + 's', "i" ), "" );
			    part=part.replace( new RegExp( val + ':', "i" ), "" );
			    part=part.replace( new RegExp( val + '-', "i" ), "" );
			    part=part.replace( new RegExp( val, "i" ), "" );
			    part=part.replace(/^\s+/,'').replace(/\s+$/,'');
			    document.getElementById('h' + val).value = part;
			}
		    }
		    i + 1;
		});
		$.each(["name"], function(i,val){
		    if (recipe.indexOf("[" + val + "]")>-1) {
			tags = tags + 1;
			part='';
			index=0;
			end=0;
			while (index!=-1) {
			    index=recipe.indexOf("[" + val + "]",index);
			    if (index!=-1) {
				end=recipe.indexOf("[/" + val + "]",end);
				if (part=='') {
				    part=recipe.substring(index + 2 + val.length,end);
				    part=part.replace( new RegExp( val + 's:', "i" ), "" );
				    part=part.replace( new RegExp( val + 's', "i" ), "" );
				    part=part.replace( new RegExp( val + ':', "i" ), "" );
				    part=part.replace( new RegExp( val + '-', "i" ), "" );
				    part=part.replace( new RegExp( val, "i" ), "" );
				    part=part.replace(/^\s+/,'').replace(/\s+$/,'');
				} else {
				    newpart=recipe.substring(index + 2 + val.length,end);
				    header[header.length] = newpart;
				}
				index=index + 1;
				end=end + 1;
			    }
			}
			document.getElementById('h' + val).value = part;
		    }
		    i + 1;
		});
		$.each(["ingredients"], function(i,val){
		    if (recipe.indexOf("[" + val + "]")>-1) {
			tags = tags + 1;
			part='';
			index=0;
			end=0;
			ict=-1;
			while (index!=-1) {
			    index=recipe.indexOf("[" + val + "]",index);
			    if (index!=-1) {
				end=recipe.indexOf("[/" + val + "]",end);
				if (part=='') {
				    part=recipe.substring(index + 2 + val.length,end);
				    part=part.replace( new RegExp( val + 's:', "i" ), "" );
				    part=part.replace( new RegExp( val + 's', "i" ), "" );
				    part=part.replace( new RegExp( val + ':', "i" ), "" );
				    part=part.replace( new RegExp( val + '-', "i" ), "" );
				    part=part.replace( new RegExp( val, "i" ), "" );
				    part=part.replace(/^\s+/,'').replace(/\s+$/,'');
				} else {
				    ict=ict+1;
				    newpart=recipe.substring(index + 2 + val.length,end);
				    test=newpart.substring(0,newpart.indexOf("\n"));
				    test=/\d/.test(test);
				    if (test==false) {
				       header[header.length] = test;
				    } else {
					if (header[ict]) {
					    newpart=header[ict]+'\n'+newpart;
					}
				    }
				    part += '\n' + newpart;
				}
				index=index + 1;
				end=end + 1;
			    }
			}
			document.getElementById('h' + val).value = part;
		    }
		    i + 1;
		});
		$.each(["directions","note"], function(i,val){
		    if (recipe.indexOf("[" + val + "]")>-1) {
			tags = tags + 1;
			part='';
			index=0;
			end=0;
			ct=-1;
			while (index!=-1) {
			    index=recipe.indexOf("[" + val + "]",index);
			    if (index!=-1) {
				end=recipe.indexOf("[/" + val + "]",end);
				if (part=='') {
				    part=recipe.substring(index + 2 + val.length,end);
				    part=part.replace( new RegExp( val + 's:', "i" ), "" );
				    part=part.replace( new RegExp( val + 's', "i" ), "" );
				    part=part.replace( new RegExp( val + ':', "i" ), "" );
				    part=part.replace( new RegExp( val + '-', "i" ), "" );
				    part=part.replace( new RegExp( val, "i" ), "" );
				    part=part.replace(/^\s+/,'').replace(/\s+$/,'');
				} else {
				    ct=ct+1;
				    if (header[ct]) {
					part += '\n\n' + header[ct].toUpperCase() + '\n\n' + recipe.substring(index + 2 + val.length,end);
				    } else {
					part += '\n\nAdditional ' + val + ':\n\n' + recipe.substring(index + 2 + val.length,end);
				    }
    
				}
				index=index + 1;
				end=end + 1;
			    }
			}
			document.getElementById('h' + val).value = part;
		    }
		    i + 1;
		});
		val = "yield";
		if (recipe.indexOf("[" + val + "]")>-1) {
		    tags = tags + 1;
		    part=recipe.substring(recipe.indexOf("[" + val + "]") + 2 + val.length,recipe.indexOf("[/" + val + "]"));
		    if (typeof part != 'undefined') {
    
			part=part.replace( new RegExp( val + 's', "i" ), "" );
			part=part.replace( new RegExp( val, "i" ), "" );
			part=part.replace(/makes/i,"");
			part=part.replace(/about/i,"");
			part=part.replace(/approx./i,"");
			part=part.replace(/approx/i,"");
			part=part.replace(/approximately/i,"");
			var y = part.match(/[\d\.]+/g);
    
			var arLen=y.length;
			for ( var i=0, len=arLen; i<len; ++i ){
			  part=part.replace(y[i],"");
			}
    
			part=part.replace(/[;:,-]+/g,'');
			part=part.replace(' to ',"");
			part=part.titleCase();
			part=part.replace(/^\s+/,'').replace(/\s+$/,'');
			document.getElementById('h' + val).value = y[0];
			document.getElementById('h' + val +'unit').value = part;
		    }
		}
		val="diet";
		uval=val.titleCase();
		uval=uval.replace(/^\s+/,'').replace(/\s+$/,'');
		mval=val + 's';
		muval=uval + 's';
		if (recipe.indexOf("[" + val + "]")>-1) {
		    tags = tags + 1;
		    part='';
		    index=0;
		    end=0;
		    while (index!=-1) {
			index=recipe.indexOf("[" + val + "]",index);
			if (index!=-1) {
			    end=recipe.indexOf("[/" + val + "]",end);
			    part=recipe.substring(index + 2 + val.length,end);
			    part=part.split(/[;:,-]+/);
			    for(i = 0; i < part.length; i++){
				if (part[i].search(val)==-1 && part[i].search(uval)==-1 && part[i].search(mval)==-1 && part[i].search(muval)==-1) {
				    dct = dct + 1;
				    if (dct<5) {
					diet = part[i].replace(/^\s+/,'').replace(/\s+$/,'');
					document.getElementById('hdiet' + dct).value = diet;
				    }
				}
			    }
			    index=index + 1;
			    end=end + 1;
			}
		    }
		}
        } else {
            var msg='No Recipe Found';
			$(".message_box").removeClass("ok");
			$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
            return false;
        }
        if (tags==0) {
            var msg='No Tagged Recipe Parts Found';
			$(".message_box").removeClass("ok");
			$(".message_box").html('<img class="close_message"  src="images/ok.png">' + msg);
            return false;
        }
        //return false;
	});
});