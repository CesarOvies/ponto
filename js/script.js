$(function() {
	$(document).on('click', '.modal button.close', function() {
		cleanInterface(100);
	});

	$('#configButton input').click(function() {
		id = $(this).attr('id');
		val = $('#' + id).is(":checked");
		localStorage.setItem(id, val);
	});

	$('#inputNotificationStore').change(function() {
		notification_store = $(this).val();
		localStorage.setItem('store', notification_store);
		$('.container_employees').load('widget/situationsEmployees.php?store=' + notification_store, function() {
			$('[data-toggle="tooltip"]').tooltip();
		});
	});

	$('#inputNotificationStore').val(localStorage.getItem('store')).trigger("change");

	$(document).on('focus', '.required > div > input, .required > div > textarea', function() {
		$(this).parent().parent().removeClass('has-error');
		$('#formJustification .errorMessage').html('');
	});

	$('#askManagerModal').on('hidden.bs.modal', function(e) {
		$('#fieldsJustification').html('');
		$('#askManagerModal .modal-footer').hide();
		$('#inputSelJustification').val('');
	});

	$('#askManagerModal').on('shown.bs.modal', function(e) {
		$('#inputSelJustification').focus();
	});

	$('#askContModal').on('hidden.bs.modal', function(e) {
		$('.disabled').removeClass('disabled').addClass('btnAsk');
	});

	$('#input_div').keypress(function(event) {
		if (event.which == 13 && $('#input_div').val().length > 0) {
			pass = $('#input_div').val();
			$("#input_div").prop('disabled', true).addClass('warning');
			$('#loader').fadeIn();
            
			$.ajax({
				type : "POST",
				url : 'assets/checkEmployee.php',
				data : {
					pass : pass
				},
				success : function(response) {
                   
					//console.log(response);
					//console.log(JSON.parse(response));
					fillEmp(JSON.parse(response));
                    
				},
				error : function(e) {
					console.log(e);
				},
			});
		}
	});

	$('#input_div').focus();
});

// GLOBALS

var nm_s = ['Entrada', 'Almoço', 'Volta do Almoço', 'Intervalo', 'Volta do Intervalo', 'Saída'];
var tags = ['tagEnt', 'tagLun', 'tagElun', 'tagSna', 'tagEsna', 'tagExi'];
var tm_s = ['tm_entry', 'tm_lunch', 'tm_elunch', 'tm_snack', 'tm_esnack', 'tm_exit'];

function fillEmp(data) {
	if (data.emp === null) {
		$('#emp_photo').html('<img src="img/misspicred.png" />');
		$('#emp_name_text').addClass('greyBG').html('Funcionário inexistente');
		$('#emp_time_text').addClass('redFT').html('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Tente novamente');
		cleanInterface(1500);
	} else {
		if (data.emp.ds_pic != '') {
			$('#emp_photo').html('<img src="pic/' + data.emp.ds_pic + '" />');
		} else {
			$('#emp_photo').html('<img src="img/misspicemp.png" />');
		}
		$('#emp_name_text').addClass('greyBG').html(data.emp.nm_emp);
		var tags_holder = $('#emp_time').find('.timeTags');

		var i = 0;
		$.each(tags_holder, function() {
			if (data.time) {
				if (data.time[tm_s[i]]) {
					$(this).html(uf(data.time[tm_s[i]]));
				}
			}
			i++;
		});

		if (data.status == 'entryLate') {
			$('#askManagerModal').modal('show');
			prepJustification(data);
		} else if (data.status == 'ask') {
			(data.time.tm_lunch == null) ? $('#btnSnack').addClass('disabled').removeClass('btnAsk') : '';
			(data.time.tm_lunch != null) ? $('#btnLunch').addClass('disabled').removeClass('btnAsk') : '';
			(data.time.tm_snack != null) ? $('#btnSnack').addClass('disabled').removeClass('btnAsk') : '';
			$('#askContModal').modal('show');
			$('.btnAsk').click(function() {
				$(".btnAsk").unbind("click");
				data.answer = $(this).attr('id');
				$('#askContModal').modal('hide');
				$('.disabled').addClass('btnAsk').removeClass('disabled');
				choice = $(this).attr('id');
				$.post("assets/answerAsk.php", {
					data : data,
					choice : choice
				}, function(r) {
                    
					r = JSON.parse(r);
                    data.node['tm_'+r.typeHit] = data.now;
					data.status = r.choice;
					data.nstatus = r.nchoice;
					if (data.status == 'cantSnack') {
						$('#emp_time_text').addClass('yellowFT').html('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Aguarde outra pessoa voltar do intervalo.');
						cleanInterface(1500);
					} else {
						$('#emp_time_text').addClass('greenFT').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' + nm_s[data.nstatus] + ' - ' + uf(data.now));
						$('#' + tags[data.nstatus]).addClass('bg-success').addClass('text-success').html(uf(data.now));
						$('#title' + tags[data.nstatus]).addClass('bg-success-title').addClass('text-success');
						cleanInterface(1500);
                        emitHit(data);
					}
				});
			});
		} else if (data.status == 'tooSoon') {
			$('#emp_time_text').addClass('yellowFT').html('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Você já bateu seu ponto. Aguarde 2 minutos.');
			cleanInterface(1500);
		} else if (data.status == 'alreadyleft') {
			$('#emp_time_text').addClass('yellowFT').html('<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Saída já efetuada.');
			cleanInterface(1500);
		} else {
			$('#emp_time_text').addClass('greenFT').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' + nm_s[data.nstatus] + ' - ' + uf(data.now));
			$('#' + tags[data.nstatus]).addClass('bg-success').addClass('text-success').html(uf(data.now));
			$('#title' + tags[data.nstatus]).addClass('bg-success-title').addClass('text-success');
			cleanInterface(1500);
            emitHit(data);
		}

	}

}

function prepJustification(data) {
	$(document).on('change', '#inputSelJustification', function() {
		//$("#formJustification").unbind("submit");
		data.reason = $(this).val();
		$('#fieldsJustification').load('assets/askManager.php', {
			data : data
		}, function() {
			$(':file').filestyle({
				buttonText : "Escolher Arquivo",
				buttonName : "btn-primary"
			});
			$('#askManagerModal .modal-footer').show();

			$("#formJustification").unbind("submit").submit(function() {

				if (validaForm('#formJustification')) {
					data.form = $(this).serializeObject();
					var form_data = new FormData(this);
					form_data.append('data', JSON.stringify(data));
					$.ajax({
						type : "POST",
						url : 'assets/createJustification.php',
						data : form_data,
						processData : false,
						contentType : false,
						beforeSend : function() {

						},
						success : function(r) {
                            //console.log(r);
							r = JSON.parse(r);
							
							if (r.status == 'success') {
                                data.node.dt_just = r.just.dt_just;
                                data.node.tp_just = r.just.tp_just;
                                data.node.ds_just = r.just.ds_just;
                                data.node.ds_file = r.just.ds_file;
                                data.node.tm_begin = r.just.tm_begin;
                                data.node.tm_end = r.just.tm_end;
                                data.node.sz_late = r.just.sz_late;
                                data.node.cd_manager = r.just.cd_manager;
                                
								if (data.reason == 'late') {
									var win = window.open('', '', "width=800, height=1000");
									win.document.write(r.html);
								}
								$('#askManagerModal').modal('hide');
								data.nstatus = 0;
								$('#emp_time_text').addClass('greenFT').html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' + nm_s[data.nstatus] + ' - ' + uf(data.now));
								$('#' + tags[data.nstatus]).addClass('bg-success').addClass('text-success').html(uf(data.now));
								$('#title' + tags[data.nstatus]).addClass('bg-success-title').addClass('text-success');
								cleanInterface(1500);
                                emitHit(data);
							} else if (r.status == 'noManager') {
								$('#formJustification #inputPassManager').val('').parent().parent().addClass("has-error");
								$('#formJustification .errorMessage').html('Senha do gerente incorreta.');
							}
						}
					});
				}
				return false;
			});
		});
	});
}

function cleanInterface(delay) {
	window.setTimeout(function() {
		$('#loader').hide();
		$("#input_div").val('').prop('disabled', false).removeClass('warning').focus();
		$('#emp_photo').delay(delay).html('');
		$('#emp_name_text').delay(delay).removeClass('greyBG').html('');
		$('#emp_time_text').delay(delay).removeClass('redFT').removeClass('yellowFT').removeClass('greenFT').html('');
		$.each(tags, function() {
			$('#' + this).removeClass('bg-success').removeClass('text-success').html('');
			$('#title' + this).removeClass('bg-success-title').removeClass('text-success');
		});
		$('#input_div').focus();
	}, delay);
}

function validaForm(form_name) {
	var erro = 0;
	$(".has-error").each(function() {
		$(this).removeClass("has-error");
	});
	$(form_name + ' .required').each(function() {
		if ($(this).children('div').children().val().length == 0) {
			erro++;
			$(this).addClass("has-error");
		}
	});

	if (!erro) {
		return true;
	}
	$('#formJustification .errorMessage').html('Campos em vermelho são obrigatórios.');
	return false;
}

