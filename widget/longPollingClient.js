$(document).ready(function() {
	
	getNotification(dateToday());
	
});



function getNotification(date, time) {

	store = $('#inputNotificationStore').val();

	var queryString = {
		'date' : date,
		'store': store,
		'time' : time
	};
	 callChangesOnWidget = $.get('widget/longPollingServer.php', queryString, function(data) {
		var obj = jQuery.parseJSON(data);

		lightHitIconsUp(obj[0]);
		//console.log(obj);
		getNotification(dateToday());
	});

}

function lightHitIconsUp(emp){
	noti = notificationType(emp);
	if(noti.type == 'entry'){
		$('.emp_'+emp.cd_emp).removeClass('notArrived');
	}
	
	$('.emp_'+emp.cd_emp+ ' .ind_'+noti.type).addClass('hit').tooltip({title: noti.name+': '+noti.time});
	
	
		
}

function notificationType(emp) {
	var dates = [];
	if (emp.tm_entry) {
		dates.push({
			type : 'entry',
			time : Date.parse("2000-01-01 " + emp.tm_entry),
			name : 'Entrada'
		});
	}
	if (emp.tm_lunch) {
		dates.push({
			type : 'lunch',
			time : Date.parse("2000-01-01 " + emp.tm_lunch),
			name : 'Almoço'
		});
	}
	if (emp.tm_elunch) {
		dates.push({
			type : 'elunch',
			time : Date.parse("2000-01-01 " + emp.tm_elunch),
			name : 'Volta do Almoço'
		});
	}
	if (emp.tm_snack) {
		dates.push({
			type : 'snack',
			time : Date.parse("2000-01-01 " + emp.tm_snack),
			name : 'Intervalo'
		});
	}
	if (emp.tm_esnack) {
		dates.push({
			type : 'esnack',
			time : Date.parse("2000-01-01 " + emp.tm_esnack),
			name : 'Volta do Intervalo'
		});
	}
	if (emp.tm_exit) {
		dates.push({
			type : 'exit',
			time : Date.parse("2000-01-01 " + emp.tm_exit),
			name : 'Saída'
		});
	}

	dates.sort(keysrt('time'));
	lastIndex = new Date(dates[dates.length - 1].time);
	maxHour = leftPad(lastIndex.getHours(), 2);
	maxMinute = leftPad(lastIndex.getMinutes(), 2);
	maxSecond = leftPad(lastIndex.getSeconds(), 2);
	maxTime = maxHour + ':' + maxMinute + ':' + maxSecond;
	type = dates[dates.length - 1].type;
	name = dates[dates.length - 1].name;
	return r = {
		time : maxTime,
		type : type,
		name : name
	};

}

function keysrt(key, desc) {
	return function(a, b) {
		return desc ? ~~(a[key] < b[key]) : ~~(a[key] > b[key]);
	};
}
function dateToday() {
	today = new Date;
	D = today.getDate();
	M = today.getMonth() + 1;
	Y = today.getFullYear();
	return today = Y + '-' + M + '-' + D;
}
