tribe.events=tribe.events||{};tribe.events.views=tribe.events.views||{};tribe.events.views.datepickerPro={};(function($,obj){'use strict';var $document=$(document);obj.selectors={datepickerDays:'.datepicker-days',datepickerDaysRow:'.datepicker-days tbody tr',datepickerDay:'.day',datepickerDayNotDisabled:'.day:not(.disabled)',activeClass:'.active',disabledClass:'.disabled',focusedClass:'.focused',hoveredClass:'.hovered',currentClass:'.current',};obj.toggleHoverClass=function(event){event.data.row.toggleClass(obj.selectors.hoveredClass.className());};obj.handleDisabledDayClick=function(event){event.data.row.find(obj.selectors.datepickerDayNotDisabled).click();};obj.bindRowEvents=function(event){var $datepickerDays=event.data.container.find(obj.selectors.datepickerDays);var config={attributes:true,childList:true,subtree:true};var $container=event.data.container;var $rows=$container.find(obj.selectors.datepickerDaysRow);$rows.each(function(index,row){var $row=$(row);$row.off('mouseenter mouseleave',obj.toggleHoverClass).on('mouseenter mouseleave',{row:$row},obj.toggleHoverClass).find(obj.selectors.datepickerDay).each(function(index,day){var $day=$(day);if($day.hasClass(obj.selectors.disabledClass.className())){$day.off('click',obj.handleDisabledDayClick).on('click',{row:$row},obj.handleDisabledDayClick);}
if($day.hasClass(obj.selectors.focusedClass.className())){$row.addClass(obj.selectors.focusedClass.className());}
if($day.hasClass(obj.selectors.activeClass.className())){$row.addClass(obj.selectors.activeClass.className());}
if($day.hasClass(obj.selectors.currentClass.className())){$row.addClass(obj.selectors.currentClass.className());}});});event.data.observer.observe($datepickerDays[0],config);};obj.afterDeinit=function(event,jqXHR,settings){var $container=event.data.container;$container.off('afterDatepickerDeinit.tribeEvents',obj.afterDeinit).off('handleMutationMonthChange.tribeEvents',obj.bindRowEvents).find(obj.selectors.input).off('show',obj.bindRowEvents);};obj.beforeInit=function(event,index,$container,data){var daysOfWeekDisabled=[];if('week'===data.slug){[0,1,2,3,4,5,6].forEach(function(value,index){if(data.start_of_week==value){return;}
daysOfWeekDisabled.push(value);});}
tribe.events.views.datepicker.options.daysOfWeekDisabled=daysOfWeekDisabled;};obj.afterInit=function(event,index,$container,data){if('week'!==data.slug){return;}
$container.on('afterDatepickerDeinit.tribeEvents',{container:$container,viewSlug:data.slug},obj.afterDeinit).on('handleMutationMonthChange.tribeEvents',{container:$container,observer:tribe.events.views.datepicker.observer},obj.bindRowEvents).find(tribe.events.views.datepicker.selectors.input).on('show',{container:$container,observer:tribe.events.views.datepicker.observer},obj.bindRowEvents);};obj.ready=function(){$document.on('beforeDatepickerInit.tribeEvents',tribe.events.views.manager.selectors.container,obj.beforeInit);$document.on('afterDatepickerInit.tribeEvents',tribe.events.views.manager.selectors.container,obj.afterInit);};$document.ready(obj.ready);})(jQuery,tribe.events.views.datepickerPro);