tribe.events=tribe.events||{};tribe.events.views=tribe.events.views||{};tribe.events.views.weekGridScroller={};(function($,obj){'use strict';var $document=$(document);obj.selectors={weekGridEventsRowOuterWrapper:'[data-js="tribe-events-pro-week-grid-events-row-outer-wrapper"]',weekGridEventsRowWrapper:'[data-js="tribe-events-pro-week-grid-events-row-wrapper"]',weekGridEventsRowWrapperClass:'.tribe-events-pro-week-grid__events-row-wrapper',weekGridEventsRowWrapperActiveClass:'.tribe-events-pro-week-grid__events-row-wrapper--active',weekGridEventsPaneClass:'.tribe-events-pro-week-grid__events-row-scroll-pane',weekGridEventsSliderClass:'.tribe-events-pro-week-grid__events-row-scroll-slider',weekGridEvent:'[data-js="tribe-events-pro-week-grid-event"]',};obj.getFirstEventPosition=function($container){var $firstEvent=null;var startTime=0;var position=0;$container.find(obj.selectors.weekGridEvent).each(function(index,event){var $event=$(event);var eventStartTime=$event.data('start-time');if(!$firstEvent||($firstEvent&&(eventStartTime<startTime))){$firstEvent=$event;startTime=eventStartTime;}});var position=$firstEvent?$firstEvent.position().top:position;if(position-16>0){position-=16;}else{position=0;}
return position;};obj.deinitScroller=function($container){$container.find(obj.selectors.weekGridEventsRowOuterWrapper).nanoScroller({destroy:true});};obj.initScroller=function($container){var topPosition=obj.getFirstEventPosition($container);$container.find(obj.selectors.weekGridEventsRowOuterWrapper).nanoScroller({paneClass:obj.selectors.weekGridEventsPaneClass.className(),sliderClass:obj.selectors.weekGridEventsSliderClass.className(),contentClass:obj.selectors.weekGridEventsRowWrapperClass.className(),iOSNativeScrolling:true,alwaysVisible:false,scrollTop:topPosition,}).find(obj.selectors.weekGridEventsRowWrapper).addClass(obj.selectors.weekGridEventsRowWrapperActiveClass.className());};obj.deinit=function(event,jqXHR,settings){var $container=event.data.container;obj.deinitScroller($container);$container.off('beforeAjaxSuccess.tribeEvents',obj.deinit);};obj.init=function(event,index,$container,data){if('week'!==data.slug){return;}
obj.initScroller($container);$container.on('beforeAjaxSuccess.tribeEvents',{container:$container},obj.deinit);};obj.ready=function(){$document.on('afterSetup.tribeEvents',tribe.events.views.manager.selectors.container,obj.init);};$document.ready(obj.ready);})(jQuery,tribe.events.views.weekGridScroller);