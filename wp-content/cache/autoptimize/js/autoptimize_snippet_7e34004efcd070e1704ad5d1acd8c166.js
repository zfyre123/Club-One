tribe.events=tribe.events||{};tribe.events.views=tribe.events.views||{};tribe.events.views.toggleRecurrence={};(function($,obj){'use strict';var $document=$(document);obj.selectors={toggleInput:'[data-js="tribe-events-pro-top-bar-toggle-recurrence"]',};obj.handleChangeInput=function(event){var is_checked=$(event.target).is(':checked');var $container=tribe.events.views.manager.getContainer(event.target);var data={view_data:{hide_subsequent_recurrences:is_checked?true:null,},_wpnonce:$container.data('view-rest-nonce'),};tribe.events.views.manager.request(data,$container);};obj.deinit=function(event,jqXHR,settings){var $container=event.data.container;$container.off('beforeAjaxSuccess.tribeEvents',obj.deinit).find(obj.selectors.toggleInput).off('change.tribeEvents',obj.handleChangeInput);};obj.init=function(event,index,$container,data){$container.on('beforeAjaxSuccess.tribeEvents',{container:$container},obj.deinit).find(obj.selectors.toggleInput).on('change.tribeEvents',obj.handleChangeInput);};obj.ready=function(){$document.on('afterSetup.tribeEvents',tribe.events.views.manager.selectors.container,obj.init);};$document.ready(obj.ready);})(jQuery,tribe.events.views.toggleRecurrence);