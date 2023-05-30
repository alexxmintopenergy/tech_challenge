document.addEventListener(
	"DOMContentLoaded",
	function() {
		var mySwiper = new Swiper(
			'.product-slider',
			{
				direction: 'horizontal',
				loop: true,
				slidesPerView: 1,
				spaceBetween: 10,

				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
			}
		)
	}
);

tabControl();

var resizeTimer;
jQuery(window).on('resize', function(e) {
	clearTimeout(resizeTimer);
	resizeTimer = setTimeout(function() {
		tabControl();
	}, 250);
});

function tabControl() {
	var tabs = jQuery('.tabbed-content').find('.tabs');
	if(tabs.is(':visible')) {
		tabs.find('a').on('click', function(event) {
			event.preventDefault();
			var target = jQuery(this).attr('href'),
				tabs = jQuery(this).parents('.tabs'),
				buttons = tabs.find('a'),
				item = tabs.parents('.tabbed-content').find('.item');
			buttons.removeClass('active');
			item.removeClass('active');
			jQuery(this).addClass('active');
			jQuery(target).addClass('active');
		});
	} else {
		jQuery('.item').on('click', function() {
			var container = jQuery(this).parents('.tabbed-content'),
				currId = jQuery(this).attr('id'),
				items = container.find('.item');
			container.find('.tabs a').removeClass('active');
			items.removeClass('active');
			jQuery(this).addClass('active');
			container.find('.tabs a[href$="#'+ currId +'"]').addClass('active');
		});
	}
}

jQuery(document).ready(function(){
	jQuery(".collapse.show").each(function(){
		jQuery(this).prev(".card-header").find(".accordion-toogle").addClass("fa-minus").removeClass("fa-plus");
	});

	// Toggle plus minus icon on show hide of collapse element
	jQuery(".collapse").on('show.bs.collapse', function(){
		jQuery(this).prev(".card-header").find(".accordion-toogle").removeClass("fa-plus").addClass("fa-minus");
	}).on('hide.bs.collapse', function(){
		jQuery(this).prev(".card-header").find(".accordion-toogle").removeClass("fa-minus").addClass("fa-plus");
	});
});