(function($) {
	if (typeof $ == "undefined") return;
	$(document).ready(function(){
		var i = edButtons.length;
		edButtons[i] = new edButton(
				'ed_fswiki',
				'p',
				'[fswiki]\n',
				'[/fswiki]\n',
				'p');
		var $button = $('<input/>')
			.attr({type:'button',
				id: edButtons[i].id,
				className: 'ed_button',
				value: 'fswiki',
				title: 'FSWiki'
			}).click(function(e) {
				edInsertTag(edCanvas, i);
			})
			;
		$('#ed_code').after($button);
	});
})(jQuery)
