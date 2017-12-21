// -------------------------EVENTS
$(function() {
	$(document).on('focus', 'input', function() {
		$(this).parent().removeClass("has-error");
	});

	$(document).on('focus', 'select', function() {
		$(this).parent().removeClass("has-error");
	});
	$(document).on('change', '#inputFoto', function() {
		showImg(this);
	});
	$(document).on('change', '#inputFotoEdit', function() {
		showImg(this);
	});
	
	$(document).on('change', '#inputSelEmp', function() {
		$('#form-selEmp').submit();
	});
	$(document).on('change', '#inputSelTurn', function() {
		$('#form-selTurn').submit();
	});
	$(document).on('change', '#inputSelHoli', function() {
		$('#form-selHoli').submit();
	});
	$(document).on('click', '#excludeHolidayConfirm', function() {
		holiDate = $('#inputHoliDate').val();
		$.redirectPost( "../action/editHoli.php", { type: "exclude", inputHoliDate: holiDate } );

		$('#excludeHolidayModal').modal('hide');
	});
	
	$(document).on('submit', '#form-selEmp', function() {
		var form_data = $(this).serialize();
		$.ajax({
			type : "POST",
			url : 'formEditEmp.php',
			data : form_data,
			beforeSend : function() {
				$('#loader').show();
			},
			success : function(response) {
				$('#formEditCont').html(response);
			},
			complete : function() {
				$('#loader').hide();
			},
			error : function() {
				console.log('erro ajax selEmp');
			},
		});
		return false;
	});
	$(document).on('submit', '#form-selTurn', function() {
		var form_data = $(this).serialize();
		$.ajax({
			type : "POST",
			url : 'formEditTurn.php',
			data : form_data,
			beforeSend : function() {
				$('#loader').show();
			},
			success : function(response) {
				$('#formEditTurnCont').html(response);
			},
			complete : function() {
				$('#loader').hide();
			},
			error : function() {
				console.log('erro ajax selTurn');
			},
		});
		return false;
	});
	$(document).on('submit', '#form-selHoli', function() {
		var form_data = $(this).serialize();
		$.ajax({
			type : "POST",
			url : 'formEditHoli.php',
			data : form_data,
			beforeSend : function() {
				$('#loader').show();
			},
			success : function(response) {
				$('#formEditHoliCont').html(response);
			},
			complete : function() {
				$('#loader').hide();
			},
			error : function() {
				console.log('erro ajax selHoli');
			},
		});
		return false;
	});
	
	
	$('.send_form').submit(function() {
		form = '#' + $(this).attr('id');
		if (validaForm(form)) {
			if ($('#inputFoto').val() !== undefined) {
				if (window.File && window.FileReader && window.FileList && window.Blob) {
					var fsize = $('#inputFoto')[0].files[0].size;
					var ftype = $('#inputFoto')[0].files[0].type;
					switch(ftype) {
					case 'image/png':
					case 'image/jpeg':
					case 'image/pjpeg':
						break;
					default:
						alert("<b>" + ftype + "</b> Tipo de arquivo não suportado!");
						return false;
					}

					//Allowed file size is less than 5 MB (1048576 = 1 mb)
					if (fsize > 5242880) {
						alert("<b>" + fsize + "</b> Arquivo muito grande! <br />O arquivo deve ter menos do que 5Mb.");
						return false;
					}
				} else {
					//Error for older unsupported browsers that doesn't support HTML5 File API
					alert("Por favor atualize seu navegador, ou tente em outro!");
					return false;
				}
			}
			return;
		}
		return false;
	});

});
//------------FUNCTIONS
function validaForm(form_name) {
	var erro = 0;
	$(".has-error").each(function() {
		$(this).removeClass("has-error");
	});
	regEx = /^([01]?[0-9]|2[0-3]):[0-5][0-9]/;
	$(form_name + ' .time_format').each(function() {
		if (!regEx.test($(this).val())) {
			if ($(this).val() != "") {
				erro++;
				$(this).parent().addClass("has-error");
			}
		}
	});

	console.log($("#form-cadNewHoli input:checkbox:checked").length );
	if($("#form-cadNewHoli input:checkbox:checked").length == 0){
		erro++;
	}


	$(form_name + ' .required').each(function() {
		if ($(this).val().length == 0) {
			erro++;
			$(this).parent().addClass("has-error");
		}
	});

	if (!erro) {
		return true;
	}
	return false;
};
function showImg(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#picture' + input.id).css('background-image', 'url(' + e.target.result + ')');
		};
		reader.readAsDataURL(input.files[0]);
	}
}
$.extend(
{
    redirectPost: function(location, args)
    {
        var form = '';
        $.each( args, function( key, value ) {
            form += '<input type="hidden" name="'+key+'" value="'+value+'">';
        });
        $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
    }
});
