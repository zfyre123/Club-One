tribe.events=tribe.events||{};tribe.events.views=tribe.events.views||{};tribe.events.views.tooltipPro={};(function($,obj){'use strict';var $document=$(document);obj.selectors={tribeEventsProClass:'.tribe-events-pro',};obj.handleAfterTooltipInitTheme=function(event,$container){var theme=$container.data('tribeEventsTooltipTheme');theme.push(obj.selectors.tribeEventsProClass.className());$container.data('tribeEventsTooltipTheme',theme);};obj.ready=function(){$document.on('afterTooltipInitTheme.tribeEvents',tribe.events.views.manager.selectors.container,obj.handleAfterTooltipInitTheme);};$document.ready(obj.ready);})(jQuery,tribe.events.views.tooltipPro);