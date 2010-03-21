/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * acPic
 *
 * Image uploading plugin
 * uses flash (UPLOADIFY) for multi-uploads
 */
(function($) {
	$.fn.acPic = function(options) {

		var opts = $.extend({}, $.fn.acPic.defaults, options);

		var x = this;												//this alias
		var server = opts.server;						//PHP backend link
		var upfServer = lnkServer(server);	//the same link without other params (for uloadify)
		var folder = opts.folder;						//thumbnails directory
		var thumbs = opts.thumbs + '/' + opts.prefix;	//complete string before the image name
		var th = $(x).find('.acPicThumbnail');				//picture containers
		var pic = null;
		var dragOpts = {										//draggable objects (image containers) options
			helper:		'clone',
			appendTo:	'body',
			opacity:	0.5,
			cursor:		'move',
			revert:		'invalid',
			zIndex:		333
		};

		$(x).dialog({												//pictures dialog options
			height:			350,
			width:			425,
			minHeight:	200,
			minWidth:		200,
			autoOpen:		false,
			title:			'Choose picture',
			zIndex:			-2
		});

		//include uploadify
		$('#uploadify').uploadify({					//uploadify settings
			uploader:		opts.uploader,
			script:			upfServer,
			queueID:		'upQueue',
			fileDesc:		'Only images allowed',
			fileExt:		'*.bmp;*.gif;*.jpg;*.png',
	    buttonImg:	'/css/img/Add.png',
	 		height: 		32,
		  width:			32,
			wmode:			'transparent',
			cancelImg:	'/css/img/Exit16.png',
			folder:			folder,
			auto:				opts.auto,
			multi:			opts.multi,
	    onSelect:   function() {
				$('#acStartUpload').show();
				$('#acCancelAll').show();
			},
			onComplete:	function(event, queueID, fileObj) {
				$('#acStartUpload').hide();
				var txt = fileObj.name;
				var thDiv = $('<div class="acPicThumbnail" title="' + txt + '"></div>');
				var img = $('<img src="' + thumbs + txt + '" />');
				var pgf = $('<p></p>').text(txt);
				thDiv.append(img).append(pgf).draggable(dragOpts);
				$('#acPicList').append(thDiv);
			},
			onAllComplete:	function(event, data, filesUploaded, errors, allBytesLoaded, speed) {
				$('#acCancelAll').hide();
			}
		});

		$(th).draggable(dragOpts);

		$('#acPicTrash').droppable({				//picture dialog trash droppable options
			accept:	"div[title!='empty.png']",
			over:	function() {
				$('#acTrashImg').toggleClass('acTrashImgActive');
			},
			out:	function() {
				$('#acTrashImg').toggleClass('acTrashImgActive');
			},
			drop:	function(event, ui) {
				var obj = ui.draggable;
				var name = obj.attr('title');
				$.fn.acPic.update(server, 'delete', 'json', name, function(res) {
					if (res.result == 'Ok') $(obj).remove();
				});
				$('#acTrashImg').toggleClass('acTrashImgActive');
			}
		});

		$('div.image').click(function() {		//open dialog when picture field clicked
			$(x).dialog('open');
		});

	}

	//creates 'pure' link to server backend (for uploadify)
	function lnkServer(lnk)
	{
		var wrk = lnk.split('?');
		var str = wrk[0];
		wrk = wrk[1].split('&');
		str += '?' + wrk[wrk.length - 1];
		return str;
	}

	//writes message on console (if available) or alert
  function debug(msg)
	{
		if (window.console && window.console.log) {
			window.console.log('Debug message: ' + msg);
		} else {
			alert('Debug message: ' + msg);
		}
	}

	return this;
})(jQuery);

//AJAX update request function
$.fn.acPic.update = function(server, cmd, type, filename, callback)
{
	$.post(server, {
		cmd:	cmd,
		type:	type,
		filename: filename
	}, function(res) {
		if (type == 'json') {	//JSON response
			callback(eval('(' + res + ')'));
		} else {							//HTML response
			callback(res);
		}
	});
}

//default values
$.fn.acPic.defaults = {
	uploader:	'/swf/uploadify.swf',
	folder:		'/images',
	thumbs:		'/images/thumbs',
	prefix:		'thumb_',
	server:		'server.php',
	auto:			false,
	multi:		true
};
//TODO: functionality in the fuckin' IE (flash button)