$(document).ready(function(){
	$("#uploader").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : 'includes/upload.php',
		
		filters : {
			// Maximum file size
			//max_file_size : '1000mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Image files", extensions : "jpg,jpeg,pdf,gif,png,flv,mp4,ogv,webm"},
			]
		},

		// Rename files by clicking on their titles
		rename: true,
		
		// Sort files
		sortable: true,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		// Views to activate
		views: {
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
			}
		}
	});

	// Handle the case when form was submitted before uploading has finished
	$('#form').submit(function(e) {
		// Files in queue upload them first
		if ($('#uploader').plupload('getFiles').length > 0) {

			// When all files are uploaded submit form
			$('#uploader').on('complete', function() {
				$('#form')[0].submit();
			});

			$('#uploader').plupload('start');
		} else {
			alert("You must have at least one file in the queue.");
		}
		return false; // Keep the form from submitting
	});
});