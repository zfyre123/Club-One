tribe.events=tribe.events||{};tribe.events.views=tribe.events.views||{};tribe.events.views.weekEventLink={};(function($,obj){'use strict';var $document=$(document);obj.config={delayHoverIn:600,};obj.selectors={weekEventLink:'[data-js~="tribe-events-pro-week-grid-event-link"]',weekEventLinkHoverClass:'.tribe-events-pro-week-grid__event-link--hover',weekEventLinkIntendedClass:'.tribe-events-pro-week-grid__event-link--intended',};obj.addIntendedClass=function($link){setTimeout(function(){if(!$link.is(':focus')&&!$link.hasClass(obj.selectors.weekEventLinkHoverClass.className())){return;}
$link.addClass(obj.selectors.weekEventLinkIntendedClass.className());},obj.config.delayHoverIn);};obj.removeIntendedClass=function($link){if($link.is(':focus')||$link.hasClass(obj.selectors.weekEventLinkHoverClass.className())){return;}
$link.removeClass(obj.selectors.weekEventLinkIntendedClass.className());};obj.handleMouseEnter=function(event){var $link=event.data.target;$link.addClass(obj.selectors.weekEventLinkHoverClass.className());obj.addIntendedClass($link);};obj.handleMouseLeave=function(event){var $link=event.data.target;$link.removeClass(obj.selectors.weekEventLinkHoverClass.className());obj.removeIntendedClass($link);};obj.handleFocus=function(event){var $link=event.data.target;obj.addIntendedClass($link);};obj.handleBlur=function(event){var $link=event.data.target;obj.removeIntendedClass($link);};obj.deinitEventLink=function($container){$container.find(obj.selectors.weekEventLink).each(function(index,link){$(link).off();});};obj.initEventLink=function($container){$container.find(obj.selectors.weekEventLink).each(function(index,link){var $link=$(link);$link.on('mouseenter touchstart',{target:$link},obj.handleMouseEnter).on('mouseleave touchstart',{target:$link},obj.handleMouseLeave).on('focus',{target:$link},obj.handleFocus).on('blur',{target:$link},obj.handleBlur);});};obj.deinit=function(event,jqXHR,settings){var $container=event.data.container;obj.deinitEventLink($container);$container.off('beforeAjaxSuccess.tribeEvents',obj.deinit);};obj.init=function(event,index,$container,data){if('week'!==data.slug){return;}
obj.initEventLink($container);$container.on('beforeAjaxSuccess.tribeEvents',{container:$container},obj.deinit);};obj.ready=function(){$document.on('afterSetup.tribeEvents',tribe.events.views.manager.selectors.container,obj.init);};$document.ready(obj.ready);})(jQuery,tribe.events.views.weekEventLink);