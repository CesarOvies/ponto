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

function uf(string) {
	return string.substr(0, 8);
}

function leftPad(number, targetLength) {
	var output = number + '';
	while (output.length < targetLength) {
		output = '0' + output;
	}
	return output;
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

function playSound() {
	var noti = document.getElementById("notificationSound");
	if (!noti.paused) {
		noti.pause();
		noti.currentTime = 0;
	};
	noti.play();
}
function createListeners(elem){
    $('[data-toggle="tooltip"]').tooltip();
    if(elem){
        elem.children().children().children().children('img').unbind('click');
        elem.children().children().children().children('img').on('click',function(){
            elem.toggleClass('item_large');
        });
    }else{
    $('.nomiss .img-circle').on('click',function(){
        $(this).parent().parent().parent().parent().toggleClass('item_large');
    });
    }
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
    time = new Date('2015/01/01 '+time);
    add = new Date('2015/01/01 '+add);
    var diff = Math.abs(add - time);
    return uf(msToTime(diff));
}
function msToTime(s) {

    function addZ(n) {
        return (n<10? '0':'') + n;
    }

    var ms = s % 1000;
    s = (s - ms) / 1000;
    var secs = s % 60;
    s = (s - secs) / 60;
    var mins = s % 60;
    var hrs = (s - mins) / 60;

    return addZ(hrs) + ':' + addZ(mins) + ':' + addZ(secs) + '.' + ms;
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

function dayWeek() {
	today = new Date;
	return today.getDayName();
}

$.extend({
	redirectPost : function(location, args) {
		var form = '';
		$.each(args, function(key, value) {
			form += '<input type="hidden" name="' + key + '" value="' + value + '">';
		});
		$('<form action="' + location + '" method="POST">' + form + '</form>').appendTo('body').submit();
	}
});

$.fn.clickToggle = function(func1, func2) {
	var funcs = [func1, func2];
	this.data('toggleclicked', 0);
	this.click(function() {
		var data = $(this).data();
		var tc = data.toggleclicked;
		$.proxy(funcs[tc], this)();
		data.toggleclicked = (tc + 1) % 2;
	});
	return this;
};

$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name] !== undefined) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
}; 