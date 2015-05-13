
$(document).ready(function(){

	var msg='';
    $("#uploader").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : 'includes/import.php',		
		filters : {
			// Maximum file size
			max_file_size : '1000mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Recipe files", extensions : "mmf,csv"}
			]
		},

		// Rename files by clicking on their titles
		rename: false,
		
		// Sort files
		sortable: false,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		// Views to activate
		views: {
			list: true,
			active: 'thumbs'
		},

		// Flash settings
		flash_swf_url : 'includes/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : 'includes/Moxie.xap',
        preinit : {
            UploadFile: function(up, file) {
                // You can override settings before the file is uploaded
                if ($('#ow').is(':checked')){
                    var overwrite='yes';
                } else {
                   var overwrite='no';
                }
                up.setOption('multipart_params', {
                    overwrite : overwrite
                });
            }
        },
		init: {
            FilesAdded: function(up,files) {
				$('.plupload_droptext').hide();
			},
            FileUploaded: function(up,files, response) {
                var response = response.response.split('|');
                var id = response[0];
                $.cookie('rid',id, { path: '/' });
                var rowner=response[1];
                $.cookie('rowner',rowner, { path: '/' });
                var omsg =  response[2];
                if(omsg) {
                    msg += omsg;
                }
            },
            UploadComplete: function(up,files) {
                plupload.each(files, function(file) {
                    up.removeFile(file);
                });
                if(msg) {
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >' +msg);
                    $('.message_box').show();
                }
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