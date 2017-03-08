function set_helper(graph_id) {

}

var App = function(container_el) {
	var public = {

	};
	var private = {
		initialize: function() {
			private.style_breaks();
			private.style_items();
			private.set_break_targets();
		},
		set_break_targets: function() {
			$('.break',container_el).hover(
				function() {
					var break_name = $(this).data('break');
					$('[data-break="'+break_name+'"]').css({'transform':'scale(1.05)'});
				},function() {
					var break_name = $(this).data('break');
					$('[data-break="'+break_name+'"]').css({'transform':'scale(1)'});
				});
		},
		style_breaks: function() {
			var count = $('.track',container_el).length;
			$('.track:first-of-type .break',container_el).each(function() {
				var break_name = $(this).data('break');
				var target_val = Math.ceil(count/2);
				var target = $('[data-break="'+break_name+'"]',container_el).eq(target_val);
				if (count % 2 === 0) {
					target.addClass('vertical-topline');
				} else {
					target.addClass('vertical-center');
				}
				target.addClass('shown');
			});
		},
		style_items: function() {
			$('.track-item:not(".break")',container_el).each(function() {
				if ($(this).children('h3').width() > $(this).width()) {
					$(this).addClass('rotated');
				}
			});
		},
	};
	private.initialize();
	return public;
};

$(document).ready(function() {
	var graph = "";
	var active = false; // Check if in a boostrap tab & tab is active
	$('.graph-container').each(function() {
		if ($(this).parents('.bs-tab').length > 0) {
			if (active) {
				graph = new App($(this));
			} else {
				set_helper($(this).attr('id'));
			}
		} else {
			graph = new App($(this));
		}
	});
});