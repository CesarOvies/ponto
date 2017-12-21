$(document).ready(function() {
	//getNotification(dateToday());

	var days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
	Date.prototype.getDayName = function() {
		return days[ this.getDay()];
	};
	$('.dropdown-menu input, .dropdown-menu label').click(function(e) {
		e.stopPropagation();
	});
	
	$('#configButton :input').each(function(){
		id = $(this).attr('id');
		if(localStorage.getItem(id)=='false'){
			$('#' + id).prop( "checked", false );
		}else if(localStorage.getItem(id)=='true'){
			$('#' + id).prop( "checked", true );
		}else{
			$('#' + id).prop( "checked", false );
		}
	});

	$('#configButton input').click(function(){
		id = $(this).attr('id');
		val = $('#' + id).is(":checked");
		localStorage.setItem(id, val);
	});    
});

//function getNotification(date, time) {
//
//	var queryString = {
//		'date' : date,
//		'time' : time
//	};
//	$.get('../notifications/notificationServer.php', queryString, function(data) {
//		var obj = jQuery.parseJSON(data);
//
//		$('body').append(time);
//        
//		notifyMe(obj[0]);
//        
//       // widgetReloadEmp(obj[0]);
//        
//		// reconecta ao receber uma resposta do servidor
//		//console.log(obj[0]);
//	    //getNotification(dateToday(), obj[1]['now'])
//	    getNotification(dateToday());
//	});
//}
//function widgetReloadEmp(emp){
//    widget_item = $('.widget_content').find('#item_'+emp.cd_emp);
//    if(emp.tm_entry && emp.tm_lunch == null && emp.tm_snack == null && emp.tm_exit == null){
//        var d = new Date();
//        var day_week_names = ['sun','mon','tue','wed','thu','fri','sat'];
//        var dof = day_week_names[d.getDay()];
//        if(emp['entry_'+dof] > emp.tm_entry){
//            widget_class = 'ontime nomiss';
//            type_item = 'ontime';
//        }else{
//            widget_class = 'late nomiss';
//            type_item = 'late';
//        }
//        if(widget_item.length > 0){
//            widget_item.removeClass('miss').addClass(widget_class);
//            widget_item.load('../notifications/widget_item_template.php',{emp: emp},function(){
//                createListeners(widget_item);
//            });  
//        }else{
//            if(type_item == 'late'){
//                if($('#checkbox_widget_late').prop('checked')){
//                    $('#store_'+emp.cd_store).after("<div id='item_"+emp.cd_emp+"' class='widget_item "+widget_class+"'></div>");
//                    $('#item_'+emp.cd_emp).load('../notifications/widget_item_template.php',{emp: emp}, function(){
//                        createListeners($('#item_'+emp.cd_emp));
//                    });
//                }
//            }
//            if(type_item == 'ontime'){
//                if($('#checkbox_widget_ontime').prop('checked')){
//                    $('#store_'+emp.cd_store).after("<div id='item_"+emp.cd_emp+"' class='widget_item "+widget_class+"'></div>");
//                    $('#item_'+emp.cd_emp).load('../notifications/widget_item_template.php',{emp: emp}, function(){
//                        createListeners($('#item_'+emp.cd_emp));
//                    });
//                }
//            }
//        }
//    }else if(widget_item.length > 0){
//        widget_item.load('../notifications/widget_item_template.php',{emp: emp},function(){
//            createListeners(widget_item);
//        });  
//    }    
//}
function notifyMe(emp) {
	if (!Notification) {
		alert('Notifications are supported in modern versions of Chrome, Firefox, Opera and Firefox.');
		return;
	}
	if (Notification.permission !== "granted") {
		Notification.requestPermission();
	}

	// CHECAR SE PIC EXISTE
	if (emp.ds_pic != '') {
		var pic = '../../pic/' + emp.ds_pic;
	} else {
		var pic = '../../img/misspicemp.png';
	}

	//GET NOTIFICATION TYPE
	noti = notificationType(emp);

	arrivalTime = emp[noti.type + '_' + dayWeek()];

	title = emp.nm_emp.slice(0, 29 - emp.nm_store.length) + ' - ' + emp.nm_store;

	justification = 'Justificativa';

	if (noti.type == 'entry') {
		if (noti.time > arrivalTime) {
			if ($('#checkboxLate').is(":checked")) {
				message = 'Chegou atrasado.' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + noti.time + '/' + arrivalTime + ' ' + justification;
				notify(title, pic, message);
			}
		} else {
			if ($('#checkboxEntry').is(":checked")) {
				message = 'Entrada. ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + noti.time;
				notify(title, pic, message);
			}
		}
	}
	if (noti.type == 'lunch') {
		if ($('#checkboxLunch').is(":checked")) {
			message = 'Almoço. ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + noti.time;
			notify(title, pic, message);
		}
	}
	if (noti.type == 'elunch') {
		if ($('#checkboxLunch').is(":checked")) {
			message = 'Volta do almoço. ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + noti.time;
			notify(title, pic, message);
		}
	}
	if (noti.type == 'snack') {
		if ($('#checkboxSnack').is(":checked")) {
			message = 'Intervalo. ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + noti.time;
			notify(title, pic, message);
		}
	}
	if (noti.type == 'esnack') {
		if (noti.time > addtime(emp.tm_snack, '00:15:00')) {
			if ($('#checkboxLateSnack').is(":checked")) {
				message = 'Demorou ' + subttime(noti.time, emp.tm_snack) + ' no intervalo.';
				notify(title, pic, message);
			}
		} else {
			if ($('#checkboxSnack').is(":checked")) {
				message = 'Volta do intervalo. ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + noti.time;
				notify(title, pic, message);
			}
		}
	}
	if (noti.type == 'exit') {
		if ($('#checkboxExit').is(":checked")) {
			message = 'Saída ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + ' ' + noti.time;
			notify(title, pic, message);
		}
	}

	//notification.onclick = function() {
	//	window.open("http://stackoverflow.com/a/13328397/1269037");
	//};
}

function notify(title, pic, message) {
	var notification = new Notification(title, {
		icon : pic,
		body : message
	});
	if ($('#checkboxSound').is(":checked")) {
		playSound();
	}
}

