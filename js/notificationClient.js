$(document).ready(function() {
	getNotification(dateToday());

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

function getNotification(date, time) {

	var queryString = {
		'date' : date,
		'time' : time
	};
	$.get('../main/notificationServer.php', queryString, function(data) {
		var obj = jQuery.parseJSON(data);

		$('body').append(time);

		notifyMe(obj[0]);
		
		// reconecta ao receber uma resposta do servidor
		console.log('a='+obj[1]['now']);
	//	getNotification(dateToday(), obj[1]['now'])
	    getNotification(dateToday());
	});
}

function notificationType(emp) {
	var dates = [];
	if (emp.tm_entry) {
		dates.push({
			type : 'entry',
			time : Date.parse("2000-01-01 " + emp.tm_entry)
		});
	}
	if (emp.tm_lunch) {
		dates.push({
			type : 'lunch',
			time : Date.parse("2000-01-01 " + emp.tm_lunch)
		});
	}
	if (emp.tm_elunch) {
		dates.push({
			type : 'elunch',
			time : Date.parse("2000-01-01 " + emp.tm_elunch)
		});
	}
	if (emp.tm_snack) {
		dates.push({
			type : 'snack',
			time : Date.parse("2000-01-01 " + emp.tm_snack)
		});
	}
	if (emp.tm_esnack) {
		dates.push({
			type : 'esnack',
			time : Date.parse("2000-01-01 " + emp.tm_esnack)
		});
	}
	if (emp.tm_exit) {
		dates.push({
			type : 'exit',
			time : Date.parse("2000-01-01 " + emp.tm_exit)
		});
	}

	dates.sort(keysrt('time'));
	lastIndex = new Date(dates[dates.length - 1].time);
	maxHour = leftPad(lastIndex.getHours(), 2);
	maxMinute = leftPad(lastIndex.getMinutes(), 2);
	maxSecond = leftPad(lastIndex.getSeconds(), 2);
	maxTime = maxHour + ':' + maxMinute + ':' + maxSecond;
	type = dates[dates.length - 1].type;
	return r = {
		time : maxTime,
		type : type
	};

}

function keysrt(key, desc) {
	return function(a, b) {
		return desc ? ~~(a[key] < b[key]) : ~~(a[key] > b[key]);
	};
}

function leftPad(number, targetLength) {
	var output = number + '';
	while (output.length < targetLength) {
		output = '0' + output;
	}
	return output;
}

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
		var pic = '../../img/misspic.png';
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

function playSound() {
	var noti = document.getElementById("notificationSound");
	if (!noti.paused) {
		noti.pause();
		noti.currentTime = 0;
	};
	noti.play();
}

function addtime(add, time) {
	time = time.split(':');
	add = add.split(':');
	time[0] = parseInt(time[0]) + parseInt(add[0]);
	time[1] = parseInt(time[1]) + parseInt(add[1]);
	time[2] = parseInt(time[2]) + parseInt(add[2]);
	if (time[2] >= 60) {
		time[1]++;
		time[2] = 0;
	}
	if (time[1] >= 60) {
		time[0]++;
		time[1] = 0;
	}
	return leftPad(time[0], 2) + ':' + leftPad(time[1], 2) + ':' + leftPad(time[2], 2);
}

function subttime(add, time) {
	time = time.split(':');
	add = add.split(':');
	time[0] = Math.abs(parseInt(time[0]) - parseInt(add[0]));
	time[1] = Math.abs(parseInt(time[1]) - parseInt(add[1]));
	time[2] = Math.abs(parseInt(time[2]) - parseInt(add[2]));

	return leftPad(time[0], 2) + ':' + leftPad(time[1], 2) + ':' + leftPad(time[2], 2);
}

function timeNow() {
	var now = new Date;
	h = now.getHours();
	m = now.getMinutes();
	s = now.getSeconds();
	u = now.getMilliseconds();
	//console.log(h + ':' + m + ':' + s + '.' + u)
	return now = h + ':' + m + ':' + s + '.' + u;

}

function dateToday() {
	today = new Date;
	D = today.getDate();
	M = today.getMonth() + 1;
	Y = today.getFullYear();
	return today = Y + '-' + M + '-' + D;
}

function dayWeek() {
	today = new Date;
	return today.getDayName();
}
