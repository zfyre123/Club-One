tribe.events=tribe.events||{};tribe.events.views=tribe.events.views||{};tribe.events.views.weekMultidayToggle={};(function($,obj){'use strict';var $document=$(document);obj.selectors={weekMultidayRow:'[data-js="tribe-events-pro-week-multiday-events-row"]',weekMultidayToggleButton:'[data-js="tribe-events-pro-week-multiday-toggle-button"]',weekMultidayToggleButtonOpenClass:'.tribe-events-pro-week-grid__multiday-toggle-button--open',weekMultidayMoreButtonWrapper:'[data-js="tribe-events-pro-week-multiday-more-events-wrapper"]',weekMultidayMoreButton:'[data-js="tribe-events-pro-week-multiday-more-events"]',tribeCommonA11yHiddenClass:'.tribe-common-a11y-hidden',};obj.toggleMultidayEvents=function(event){var $toggleButton=event.data.toggleButton;var togglesAndContainers=event.data.togglesAndContainers;if('true'===$toggleButton.attr('aria-expanded')){tribe.events.views.accordion.closeAccordion($toggleButton,$(''));$toggleButton.removeClass(obj.selectors.weekMultidayToggleButtonOpenClass.className());}else{tribe.events.views.accordion.openAccordion($toggleButton,$(''));$toggleButton.addClass(obj.selectors.weekMultidayToggleButtonOpenClass.className());}
togglesAndContainers.forEach(function(item){var $headerWrapper=item.headerWrapper;var $header=item.header;var $content=item.content;if('true'===$header.attr('aria-expanded')){tribe.events.views.accordion.closeAccordion($header,$content);$headerWrapper.removeClass(obj.selectors.tribeCommonA11yHiddenClass.className());}else{tribe.events.views.accordion.openAccordion($header,$content);$headerWrapper.addClass(obj.selectors.tribeCommonA11yHiddenClass.className());}});};obj.getTogglesAndContainers=function($multidayRow,containerIds){var togglesAndContainers=[];containerIds.forEach(function(toggleContent){var $toggleContent=$multidayRow.find('#'+toggleContent);var $moreButtonWrapper=$toggleContent.siblings(obj.selectors.weekMultidayMoreButtonWrapper);var $moreButton=$moreButtonWrapper.find(obj.selectors.weekMultidayMoreButton)
togglesAndContainers.push({headerWrapper:$moreButtonWrapper,header:$moreButton,content:$toggleContent,});});return togglesAndContainers;}
obj.initToggle=function($container){var $multidayRow=$container.find(obj.selectors.weekMultidayRow);var $toggleButton=$multidayRow.find(obj.selectors.weekMultidayToggleButton);var containerIds=$toggleButton.attr('aria-controls').split(' ');var togglesAndContainers=obj.getTogglesAndContainers($multidayRow,containerIds);$toggleButton.on('click',{toggleButton:$toggleButton,togglesAndContainers:togglesAndContainers,},obj.toggleMultidayEvents);togglesAndContainers.forEach(function(item){var $moreButton=item.header;$moreButton.on('click',{toggleButton:$toggleButton,togglesAndContainers:togglesAndContainers,},obj.toggleMultidayEvents);});};obj.deinitToggle=function($container){var $multidayRow=$container.find(obj.selectors.weekMultidayRow);$multidayRow.find(obj.selectors.weekMultidayToggleButton).off('click',obj.toggleMultidayEvents);$multidayRow.find(obj.selectors.weekMultidayMoreButton).each(function(index,moreButton){$(moreButton).off('click',obj.toggleMultidayEvents);});};obj.deinit=function(event,jqXHR,settings){var $container=event.data.container;obj.deinitToggle($container);$container.off('beforeAjaxSuccess.tribeEvents',obj.deinit);};obj.init=function(event,index,$container,data){var $toggleButton=$container.find(obj.selectors.weekMultidayToggleButton);if(!$toggleButton.length){return;}
obj.initToggle($container);$container.on('beforeAjaxSuccess.tribeEvents',{container:$container},obj.deinit);};obj.ready=function(){$document.on('afterSetup.tribeEvents',tribe.events.views.manager.selectors.container,obj.init);};$document.ready(obj.ready);})(jQuery,tribe.events.views.weekMultidayToggle);