$(function() {
	var clock = $('#clock');

	var digit_to_name = 'zero one two three four five six seven eight nine'.split(' ');
	var weekday_names = 'SEG TER QUA QUI SEX SÁB DOM'.split(' ');

	var digits = {};

	var positions = ['h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'];

	var digit_holder = clock.find('.digits');
	var weekday_holder = clock.find('.weekdays');
	
	$.each(positions, function() {

		if (this == ':') {
			digit_holder.append('<div class="dots">');
		} else {

			var pos = $('<div>');

			for (var i = 1; i < 8; i++) {
				pos.append('<span class="d' + i + '">');
			}

			// Set the digits as key:value pairs in the digits object
			digits[this] = pos;

			// Add the digit elements to the page
			digit_holder.append(pos);
		}

	});
	weekday_holder.append('<span class=\' col-xs-2 col-xs-offset-1\' ></span>');
	$.each(weekday_names, function() {
		weekday_holder.append('<span class=\'col-xs-1\'>' + this + '</span>');
	});

	var weekdays = clock.find('.weekdays span');
	var glob = 0;
	var now = 0;

	(function check_righ_time() {
		$.ajax({
			type : "POST",
			url : 'class/now.php',
			async : false,
			success : function(response) {
				response = JSON.parse(response);
				glob = response.time;
				dow = response.dof;
				date = response.dateBr;
			},
			error : function() {
				console.log('erro get NOW');
			},
		});
		Anow = glob;
		
		if (dow == 0) {
			// Make it last
			dow = 7;
		}
		weekdays.removeClass('active').eq(dow).addClass('active');
		weekdays.eq(0).addClass('active');
		weekdays.eq(0).html(date);
		
		setTimeout(check_righ_time, 5000);
	})();
	
	(function update_time() {
		Anow = Anow.split(':');
		if (Anow[2] > 59) {
			Anow[1]++;
			Anow[2] = 0;
		} else {
			Anow[2]++;
		}
		if (Anow[1] > 59) {
			Anow[0]++;
			Anow[1] = 0;
		}
		Anow = leftPad(Anow[0], 2) + ':' + leftPad(Anow[1], 2) + ':' + leftPad(Anow[2], 2);
		
		now = Anow.replace(new RegExp('[:]', 'g'), '');
		
		digits.h1.attr('class', digit_to_name[now[0]]);
		digits.h2.attr('class', digit_to_name[now[1]]);
		digits.m1.attr('class', digit_to_name[now[2]]);
		digits.m2.attr('class', digit_to_name[now[3]]);
		digits.s1.attr('class', digit_to_name[now[4]]);
		digits.s2.attr('class', digit_to_name[now[5]]);


		setTimeout(update_time, 1000);

	})();
});