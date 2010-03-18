/*
 *acPic
 *
 *Pictures uploading plugin
 */
(function($) {
	$.fn.acPic = function(options) {

		var opts = $.extend({}, $.fn.acPic.defaults, options);

		var x = this;
		var folder = opts.folder;
		var thumbs = opts.thumbs + '/' + opts.prefix;
		var th = $(x).find('.acPicThumbnail');
		var pic = null;
		var dragOpts = {
			helper:		'clone',
			appendTo:	'body',
			opacity:	0.5,
			cursor:		'move',
			revert:		'invalid',
			zIndex:		333
		};

		$(x).dialog({
			height:			360,
			width:			405,
			minHeight:	200,
			minWidth:		200,
			autoOpen:		false,
			title:			'Choose picture',
			zIndex:			-2
		});

		//include uploadify
		$('#uploadify').uploadify({
			uploader:		opts.uploader,
			script:			opts.server,
			queueID:		'upQueue',
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
				var span = $('<span></span>').text(txt);
				thDiv.append(img).append(span).draggable(dragOpts);
				$('#acPicList').append(thDiv);
				var prd = 'mrd';
			},
			onAllComplete:	function(event, data, filesUploaded, errors, allBytesLoaded, speed) {
				$('#acCancelAll').hide();
			}
		});

		$(th).draggable(dragOpts);

		$('#acPicTrash').droppable({
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
				$('#acTrashImg').toggleClass('acTrashImgActive');
				setTimeout(function() {
					$(obj).remove();
				}, 50);
			}
		});

		$('div.image').click(function() {
			$(x).dialog('open');
		});

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