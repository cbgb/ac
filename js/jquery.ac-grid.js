/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * acGrid
 *
 * Editable grid plugin
 */
(function($) {
	$.fn.acGrid = function(options) {
		
		var opts = $.extend({}, $.fn.acGrid.defaults, options);

		var server		= opts.server;					//PHP backend
		var rate			= opts.rate;						//transitional effects rate
		var oldValue	= null;									//original field value

		//IMAGE field drop event handle
		var imgDropOpts = {
			drop:	function(event, ui) {
				var imgDiv = this;
				var oldValue = $(imgDiv).attr('title');
				var newValue = ui.draggable.attr('title');
				if (newValue != oldValue) {
					if (newValue == 'empty.png') newValue = '';
					var info = getContainer(this);
					processStart(info.obj, info.left, info.top, function() {
						$.fn.acGrid.update(server, 'update', 'html', info.row, info.col, newValue, function(payload) {
							if (payload.result == 'Ok') {
								processReady(function() {
									var newDiv = $(payload.html).droppable(imgDropOpts);
									$(imgDiv).replaceWith(newDiv);
								}, rate);
							} else debug(payload.result);
						});
					});
				}
			}
		};

		//case TEXT type field
		$('div.text')
			.focus(function() {									//field focused
				oldValue = $(this).html();
				var txtDiv = this;
				$(txtDiv).keypress(function(e) {	//catch Enter key
					if (e.which == 13) {
						e.preventDefault();
						txtDiv.blur();
					}
				});
			})
			.blur(function() {									//end of field focus, send change (if any)
				var newValue = $(this).html();
				if (newValue != oldValue) {
					var info = getContainer(this);
					processStart(info.obj, info.left, info.top, function() {
						$.fn.acGrid.update(server, 'update', 'json', info.row, info.col, newValue, function(payload) {
							if (payload.result == 'Ok') processReady(null, rate);
							else debug(payload.result);
						});
					});
				}
			});
		
		//case SELECTBOX driven field
		$('div.select')
			.live('click', function() {					//field clicked => invoke selectbox
				var selDiv = this;
				var txt = $(selDiv).html();
				var info = getContainer(selDiv);
				var selBox = '#sel' + info.col;
				oldValue = getSelValue(txt, selBox, 1);
				$(selBox).css({left: info.left, top: info.top});
				togglePair(selDiv, selBox, rate);
				$(selBox)
					.change(function() {						//selectbox value changed
						$(this).unbind('change');			//immediately unbind the change event - otherway is chained
						processStart(info.obj, info.left, info.top, function() {
							var newValue = $(selBox).val();
							$.fn.acGrid.update(server, 'update', 'html', info.row, info.col, newValue, function(payload) {
								if (payload.result == 'Ok') {
									processReady(function() {
										$(selDiv).replaceWith(payload.html);
										togglePair(selBox, selDiv, rate);
									}, rate);
								} else debug(payload.result);
							});
						});
					});
			});
		
		//case RADIOBUTTONS field
		$('div.radio input')
			.change(function() {
				var container = $(this).parent();
				var radioBtn = this;
				var info = getContainer(container);
				processStart(info.obj, info.left, info.top, function() {
					var newValue = $(radioBtn).val();
					$.fn.acGrid.update(server, 'update', 'json', info.row, info.col, newValue, function(payload) {
						if (payload.result == 'Ok') processReady(function() {
							$(radioBtn).blur();
						}, rate);
						else debug(payload.result);
					});
				});
			});

		//case IMAGE field
		$('div.image')
			.droppable(imgDropOpts);

		//case New button pressed
		$('a#acGridNew').click(function() {
			$.fn.acGrid.update(server, 'new', 'json', null, null, null, function(payload) {
				if (payload.result == 'Ok') location.reload();
				else debug(payload.result);
			});
		});

		//case Delete button pressed
		$('a#acGridDel').click(function() {
			$('#acQuery').dialog({
				width:	800,
				height:	60,
				title:	'Query'
			});
			var form = $('#acQuery').find('form');
			var expr = $(form).find('input');
			$(expr).focus();
			$(form).submit(function(event) {
				event.preventDefault();
				$(this).unbind('submit');
				$.fn.acGrid.update(server, 'delete', 'json', null, null, $(expr).val(), function(payload) {
					$(expr).val('');
					if (payload.result == 'Ok') location.reload();
					else debug(payload.result);
				});
			});
		});

		return this;
	}

	//gets the PARENT object info
	function getContainer(object)
	{
		var obj = $(object).parent();
		var id = $(obj).attr('id');
		var arr = id.split('-');
		var pos = obj.offset();
		var info = {obj: obj, col: arr[0], row: arr[1], left: pos.left, top: pos.top};
		return info;
	}
	
	//gets value from selectbox (by option text)
	function getSelValue(txt, obj, sel)
	{
		$(obj + ' option').each(function() {
			if ($(this).text() == txt) {
				var v = $(this).val();
				if (sel) $(obj).val(v);
				return v;
			}
		});
		return false;
	}

	//toggles two objects
	function togglePair(visibleObj, hiddenObj, rate)
	{
		if (!rate) var rate = 'fast';
		$(visibleObj).fadeOut(rate, function() {
			$(hiddenObj).fadeIn(rate);								
		});
	}
	
	//AJAX process wrapping function
	function processStart(obj, left, top, callback)
	{
		var process = $('<span id="process">&nbsp&nbsp</span>').css({left: left, top: top});
		$(obj).append(process);											
		if (callback) {
			if (typeof callback == 'function') callback();
			else debug('To je hnus a né callback ! : ' + callback);			
		}
	}
	
	//end of AJAX operation
	function processReady(callback, rate)
	{
		var sign = 'span#process';
		if ($(sign).length) {
			$(sign).fadeOut(rate, function(){
				$(sign).remove();
				if (callback) {
					if (typeof callback == 'function') callback();
					else debug('To je hnus a né callback ! : ' + callback);			
				}
			});				
		}		
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
$.fn.acGrid.update = function(server, cmd, type, row, col, value, callback)
{
	$.post(server, {
		cmd:	cmd,
		type:	type,
		row:	row,
		col:	col,
		content: value
	}, function(payload) {
			callback(payload);
	});
}

$.fn.acGrid.defaults = {
	server:	'server.php',
	thumbs:	'/images/thumbs/thumb_',
	rate:		1000
};
