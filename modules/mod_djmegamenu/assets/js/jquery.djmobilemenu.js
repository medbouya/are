/**
 * @package DJ-MegaMenu
 * @copyright Copyright (C) 2022 DJ-Extensions.com, All rights reserved.
 * @license DJ-Extensions.com Proprietary Use License
 * @author url: https://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski, Artur Kaczmarek
 */

 var DJMegaMobile;

(function($) {
	DJMegaMobile = function () {
		this.mega = [];
		this.timer = null;

		this.init();
	};

	DJMegaMobile.prototype.init = function () {

		var self = this;

		// init mobile menu
		$('.dj-megamenu:not(.dj-megamenu-sticky)').each(function() {
			
			var menu = $(this);
			var mobile = $('#'+menu.prop('id')+'mobile');
			var offcanvas = $('#'+menu.prop('id')+'offcanvas');
			
			var idx = self.mega.length;
			self.mega[idx] = {};
			self.mega[idx].id = menu.prop('id');
			self.mega[idx].trigger = menu.data('trigger');
			self.mega[idx].menu = menu;
			self.mega[idx].menuHandler = $('<div />');
			self.mega[idx].mobile = mobile.length ? mobile : null;
			self.mega[idx].mobileHandler = $('<div />');
			self.mega[idx].offcanvas = offcanvas.length ? offcanvas : null;
			self.mega[idx].offcanvasHandler = $('<div />');
			
			var wrapper = $('#'+menu.prop('id')+'mobileWrap');
			if(wrapper.length) {
				wrapper.empty().append(self.mega[idx].mobile);
			}
			
			if(self.mega[idx].mobile) {
				// remove hidden menu items from the DOM
				self.mega[idx].mobile.find('.dj-hideitem').remove();
				
				if(self.mega[idx].mobile.hasClass('dj-megamenu-offcanvas')) {
					self.createOffcanvas(self.mega[idx].mobile);
				} else if(self.mega[idx].mobile.hasClass('dj-megamenu-accordion')) {
					self.createAccordion(self.mega[idx].mobile);
				}
				
				// fix double collapse Joomla!3 Protostar 
				self.mega[idx].mobile.parents('.nav-collapse').addClass('collapse in').css('height', 'auto').prev('.navbar').remove();
				
				// fix double collapse Joomla!4 Cassiopeia
				self.mega[idx].mobile.parents('.navbar-collapse').addClass('show').prev('.navbar-toggler').remove();
			}

		});

		$(window).resize(self.switchMenu.bind(self));
		self.switchMenu();

		$(document).on('click', '.dj-offcanvas-open', function(e) {
			if( $(e.target).parents('.dj-offcanvas').length || $(e.target).hasClass('dj-offcanvas')) return;
			//if clicked outside offcanvas close it
			$('.dj-offcanvas-opened').find('.dj-offcanvas-close-btn').click();
		});

		$(document).on('djmegamobile:pageload', function() {
			for(var idx = 0; idx < self.mega.length; idx++) {
				if(self.mega[idx].mobile) {
					if(self.mega[idx].mobile.hasClass('dj-megamenu-select')) {
						self.createSelectMenu(self.mega[idx].menu, self.mega[idx].mobile);
					}
				}
			}
		});
	};

	DJMegaMobile.prototype.createSelectMenu = function(menu, mobile) {
		
		// Create the dropdown base
		var id = menu.attr('id');
		var name = mobile.attr('data-label') || 'menu';

		var btn_open = mobile.find('.dj-mobile-open-btn');

		var select = $('<select id="'+ id +'select" class="inputbox dj-select" />');

		select.on('click blur', function() {
			btn_open.toggleClass('active');
		});

		select.on('change', function() {
			btn_open.removeClass('active');
			if($(this).val) window.location = $(this).val();
		});

		var label = $('<label class="hidden" aria-hidden="true" for="'+ id +'select">' + name + '</label>')

		var list = menu.find('li.dj-up');
		this.addOptionsFromDJMegaMenu(list, select, 0);
		
		label.appendTo(mobile);
		select.appendTo(mobile);
		
		btn_open.on('click', function(e){

			e.stopPropagation();
			e.preventDefault();

			var element = select[0];
			if (document.createEvent) { // all browsers
				var ev = document.createEvent("MouseEvents");
				ev.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
				element.dispatchEvent(ev);
			} else if (element.fireEvent) { // ie
				element.fireEvent("onmousedown");
			}
		});
	};
	
	DJMegaMobile.prototype.addOptionsFromDJMegaMenu = function(items, select, level) {
		var self = this;

		var sep = '',
		active = false;
		for(var i=0;i<level;i++) {
			sep += '- ';
		}
		//console.log(items);
		items.each(function(){
			
			var item = $(this);

			var link = item.find('> a').first();
			var kids = item.find('> .dj-subwrap > .dj-subwrap-in > .dj-subcol > .dj-submenu > li, > .dj-subtree > li');
			
			if(link.length) {
				var text = '';
				var img = link.find('img').first();
				if(img.length) {
					text = sep + img.attr('alt');
				} else {
					text = link.html().replace(/(<small[^<]+<\/small>)/ig,"");
					text = sep + text.replace(/(<([^>]+)>)/ig,"");
				}
				//console.log(text);
				var option = $('<option value="'+link.prop('href')+'">'+ text +'</option>').appendTo(select);
				if(!link.prop('href')) { option.prop('disabled',true); }
				if(item.hasClass('active')) {
					select.val(option.val());
					active = true;
				}
			}
			if(kids) self.addOptionsFromDJMegaMenu(kids, select, level+1);
		});
		
		if(!level && !active) {
			//$('<option value="">Menu</option>').prependTo(select);
			select.val('');
		}
	};
	
	DJMegaMobile.prototype.initAccordion = function(mobile) {
		//console.log('initAccordion');
		var focusTimer = null;

		var btn_close = mobile.find('.dj-offcanvas-close-btn');

		mobile.find('ul.dj-mobile-nav > li, ul.dj-mobile-nav-child > li').each(function(){
			
			var menu = $(this);
			var anchor = menu.find('> a').first();

			if(anchor.length) {

				var subs = menu.find('> ul.dj-mobile-nav-child > li:not(:empty)');

				if( !subs.length ) {
					menu.removeClass('parent');
					menu.find('ul.dj-mobile-nav-child').remove();
				}

				if( menu.hasClass('parent') ) {
					
					if( menu.hasClass('active') ) {
						anchor.attr('aria-expanded', true);
						menu.find('> ul').slideDown(400);
					} else {
						anchor.attr('aria-expanded', false);
					}
					
					anchor.append('<span class="toggler"></span>');
				}
				
				anchor.on('click',function(e) {

					var $this = $(this);
					var is_toggler = $(e.target).hasClass('toggler');
					var _href = $this.attr('href');
					var _hash = ( _href != undefined && _href.length > 1 && _href.indexOf('#') !== -1 ) ? true : false;

					clearTimeout(focusTimer);

					//detect hash, close off-canvas
					if ( _hash && ! is_toggler && e.which ) { //e.which detects if a real click
						$(document.body).addClass('dj-offcanvas-no-effects');
						btn_close.click();
					} else if( menu.hasClass('parent') && !menu.hasClass('active') ) {
						e.preventDefault(); //first click - open submenu
					} else if( is_toggler ) { //second click in toggler - close submenu
						e.preventDefault();
						e.stopPropagation();
						
						menu.removeClass('active').find('> ul').slideUp(400);
						$this.attr('aria-expanded', false);
					}

				});

				anchor.on('focus',function() {

					var $this = $(this);

					mobile.find('[aria-expanded]').attr('aria-expanded', false);
					$this.parents('.active').find('> [aria-expanded]').attr('aria-expanded', true);
					$this.attr('aria-expanded', true);

					focusTimer = setTimeout(function(){
						menu.click();
					}, 250);
				});
			}
			
			menu.on('click', function( e ) {
				menu.siblings().removeClass('active').find('> ul').slideUp(400);
				menu.addClass('active').find('> ul').slideDown(400);
			});
		});
	};
	
	DJMegaMobile.prototype.createOffcanvas = function(mobile) {
		
		var isJoomla4 = mobile.parents('[data-joomla4]').length ? true : false;
		var template = mobile.parents('[data-tmpl]').attr('data-tmpl');

		var FXnotSupported = ( 'cassiopeia' === template ) ? true : false;

		var content 	= null;
		var wrapper 	= $('.dj-offcanvas-wrapper').first();
		var pusher 		= $('.dj-offcanvas-pusher').first();
		var pusherIn 	= $('.dj-offcanvas-pusher-in').first();
		
		if( ! wrapper.length ) {
			content		= $(document.body).children();
			wrapper		= $('<div class="dj-offcanvas-wrapper" />');
			pusher		= $('<div class="dj-offcanvas-pusher" />');
			pusherIn	= $('<div class="dj-offcanvas-pusher-in" />');
		}
		
		var allOffcanvas = $('.dj-offcanvas');
		var offcanvas = mobile.find('.dj-offcanvas').first();


		var fx = ( FXnotSupported || ! wrapper.length || allOffcanvas.length > 1 ) ? '1' : offcanvas.data('effect');
		var simple_fx = ( fx == 1 ) ? true : false; //effect slide in on top
		
		$(document.body).addClass('dj-megamenu-offcanvas dj-offcanvas-effect-' + fx);

		//if simple effect, no need to add pushers
		if( !simple_fx ) {
			if(content) $(document.body).prepend(wrapper);
			if(fx == 3 || fx == 6 || fx == 7 || fx == 8 || fx == 14) {
				pusher.append(offcanvas);
			} else {
				wrapper.append(offcanvas);
			}
			if(content) {
				wrapper.append(pusher);
				pusher.append(pusherIn);
				pusherIn.append(content);
			}
		} else {
			$(document.body).append(offcanvas); //move offcanvas to the end
		}

		allOffcanvas.hide();

		var timer = null;

		var btn_open = mobile.find('.dj-mobile-open-btn');
		var btn_close = offcanvas.find('.dj-offcanvas-close-btn');
		var last_item = offcanvas.find('button, a, input:not([type="hidden"]), select, textarea, [tabindex]:not([tabindex="-1"])').last();

		btn_open.on('click', function(e){
			e.stopPropagation();
			e.preventDefault();
			if( $(document.body).hasClass('dj-offcanvas-open') ) {
				btn_open.removeClass('active');
				btn_close.click();
			} else {

				btn_open.addClass('active');

				clearTimeout(timer);
				offcanvas.data('scroll', $(window).scrollTop());
				$(document.body).addClass('dj-offcanvas-anim').removeClass('dj-offcanvas-no-effects');
				setTimeout(function(){
					$(document.body).addClass('dj-offcanvas-open');
				}, 50 );

				if( ! simple_fx ) {
					pusherIn.css('top', -offcanvas.data('scroll'));
				}

				allOffcanvas.hide();
				offcanvas.show();
				offcanvas.removeAttr('aria-hidden');
				offcanvas.attr('role', 'dialog');
				offcanvas.attr('aria-modal', 'true');
				offcanvas.addClass('dj-offcanvas-opened');

				if( ! $('.dj-megamenu-offcanvas-overlay').length ) {
					offcanvas.parent().append('<div class="dj-megamenu-offcanvas-overlay" />');
				}

				//move focus to offcanvas
				setTimeout(function(){
					btn_close.focus();
				}, 250 );
			}
		});

		btn_close.on('click', function(e) {
			e.stopPropagation();
			e.preventDefault();

			if($(document.body).hasClass('dj-offcanvas-open')) {

				btn_open.removeClass('active');

				$(document.body).removeClass('dj-offcanvas-open');
				
				if( $(document.body).hasClass('dj-offcanvas-no-effects') ) {

					if( !simple_fx ) pusherIn.css('top', 0);

					$(document.body).removeClass('dj-offcanvas-anim dj-offcanvas-no-effects');
					offcanvas.hide();
					btn_open.focus();
				} else {
					timer = setTimeout(function(){

						if( !simple_fx ) pusherIn.css('top', 0);

						$(document.body).removeClass('dj-offcanvas-anim');
						$(window).scrollTop($(window).scrollTop() + offcanvas.data('scroll'));
						offcanvas.hide();
						btn_open.focus();
					}, 250 );
				}
				
				offcanvas.attr('aria-hidden', 'true');
				offcanvas.removeAttr('role');
				offcanvas.removeAttr('aria-modal');
				offcanvas.removeClass('dj-offcanvas-opened');

				$(document.body).find('.dj-megamenu-offcanvas-overlay').remove();

			}
		});

		btn_close.on('keydown', function(event){
			if(event.key == 'Tab' && event.shiftKey) {
				event.preventDefault();
				last_item.focus();
			}
		});

		last_item.on('keydown', function(event){
			if(event.key == 'Tab' && !event.shiftKey) {
				event.preventDefault();
				btn_close.focus();
			}
		});

		offcanvas.on('keydown', function(e) {
			if (e.key === "Escape") {
				btn_close.click();
			}
		});

		this.initAccordion(offcanvas);
	};

	DJMegaMobile.prototype.createAccordion = function(mobile) {
		
		var btn_open = mobile.find('.dj-mobile-open-btn');

		btn_open.on('click', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).toggleClass('active');
			mobile.find('.dj-accordion-in').slideToggle('fast');
		});
		
		$(document).on('click', function(e){
			if(!$(e.target).closest('.dj-accordion-in').length) {
				btn_open.removeClass('active');
				if(mobile.find('.dj-accordion-in').is(':visible')) mobile.find('.dj-accordion-in').slideUp('fast');
			}
		});

		this.initAccordion(mobile);
		
	};

	DJMegaMobile.prototype.switchMenu = function() {
		
		var self = this;

		window.clearTimeout(self.timer);
		self.timer = window.setTimeout(function(){
			
			for(var idx = 0; idx < self.mega.length; idx++) {
				
				if(self.mega[idx].mobile) {
					
					if(window.matchMedia("(max-width: "+self.mega[idx].trigger+"px)").matches) {
						
							$(document.body).addClass('dj-megamenu-mobile');
							$(document.body).addClass(self.mega[idx].id+'-mobile');
							// we need only one menu in DOM
							if($.contains(document, self.mega[idx].menu[0])) {
								self.mega[idx].menu.after(self.mega[idx].menuHandler);
								self.mega[idx].menu.detach();
							}
							if($.contains(document, self.mega[idx].mobileHandler[0])) {
								self.mega[idx].mobileHandler.replaceWith(self.mega[idx].mobile);
							}
							if($.contains(document, self.mega[idx].offcanvasHandler[0])) {
								self.mega[idx].offcanvasHandler.replaceWith(self.mega[idx].offcanvas);
							}
							
					} else {
						
							$(document.body).removeClass('dj-megamenu-mobile dj-offcanvas-open dj-offcanvas-anim');
							$(document.body).removeClass(self.mega[idx].id+'-mobile');
							// we need only one menu in DOM
							if($.contains(document, self.mega[idx].mobile[0])) {
								self.mega[idx].mobile.after(self.mega[idx].mobileHandler);
								self.mega[idx].mobile.detach();
							}
							if(self.mega[idx].offcanvas && $.contains(document, self.mega[idx].offcanvas[0])) {
								self.mega[idx].offcanvas.after(self.mega[idx].offcanvasHandler);
								self.mega[idx].offcanvas.detach();
							}
							if($.contains(document, self.mega[idx].menuHandler[0])) {
								self.mega[idx].menuHandler.replaceWith(self.mega[idx].menu);
							}
					}
				}
			}
			
		}, 100);
	};
})(jQuery);

var initMobile = function() {
	if (typeof jQuery == 'undefined') {
		console.log('DJ-Megamenu: jQuery missing');
	} else {
		new DJMegaMobile;
	}
}

if (document.readyState !== 'loading') {
  initMobile();
} else {
  document.addEventListener('DOMContentLoaded', function() {
    initMobile();
  });
}

window.addEventListener('load', function() {
	if (typeof jQuery == 'undefined') {
		console.log('DJ-Megamenu: jQuery missing');
	} else {
		jQuery(document).trigger('djmegamobile:pageload');
	}
});