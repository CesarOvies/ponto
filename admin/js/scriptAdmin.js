// -------------------------EVENTS
$(function() {
	$(document).on('focus', 'input', function() {
		$(this).parent().removeClass("has-error");
	});

    $(document).on('click', '.editTimeNoInput', function() {
        var cont = $(this).children().html();
        var name = $(this).children().attr('name');
        name = name.substr(5);
        $(this).parent().html("<input value='" + cont + "' class='editTimeEdited uf5' type='text' name='input" + name + "'><input type='hidden' value='" + cont + "' name='before" + name + "'>").children().focus().mask('99:99');
    });
    $(document).on('focusout', '.editTimeNew', function() {
        var val = $(this).val();
        if(!isTime(val)){
            //VALIDAR   
            $(this).parent().addClass('has-error'); 
        }
    });
     
    $(document).on('focusout', '.editTimeEdited', function() {
        var val = $(this).val();
        if(val.length == 5 || val.length == 0){
            var name = $(this).attr('name');
            name = name.substr(5);
            var before = $(this).siblings('input').val();
            if(val == before){
                $(this).parent().html("<div class='editTimeNoInput'><div name='input" + name + "'>" +  val + "</div></div><input type='hidden' value='" + val + "' name='before" + name + "'>");
            }
        }else{
            $(this).parent().addClass('has-error'); 
        }
    });
    
    
    //-------
    $(document).on('click', '.edit_just .glyphicon-plus, .edit_just .glyphicon-pencil', function() {
        data = $(this).data();
        var location = '../edit/addJustDay.php?cd='+data.cd+'&date='+data.date;     
        saveEditTime('form-editTime','move',location);
               
    });
    $(document).on('click', '.edit_just .glyphicon-remove', function() {
        data = $(this).data();
        var location = '../action/removeJust.php?cd='+data.cd+'&date='+data.date;
        saveEditTime('form-editTime','move',location);
    });
    $(document).on('click', '#saveEditTime', function() {
        saveEditTime('form-editTime','','');
    });

    function saveEditTime(form,action,location){
        form_data = $('#'+form).serialize();

        $.ajax({
            type : "POST",
            url : '../action/editTime.php',
            data : form_data,
            beforeSend : function() {
                $('#loader').show();
            },
            success : function(response) {
                response = JSON.parse(response);
                if(response.status == 'successEditTime'){
                    if(action == 'move'){
                        window.location = location;
                    }
                    else{
                        window.location.reload();
                    }
                }else if(response.status == 'invalidTime'){
                    alert('Formato Inválido')
                }else{
                    alert('erro ao salvar horarios');
                }
            },
            complete : function() {
                $('#loader').hide();
            },
            error : function() {
                console.log('erro ajax selSaveEdit');
            },
        });
        return false;
    }
    
    
    $(document).on('change', '#inputSelJustification', function() {
        $('#form-selectAddJust').submit();
    });
    $(document).on('submit', '#form-selectAddJust', function() {
        var form_data = $(this).serialize();
        $.ajax({
            type : "POST",
            url : 'formAddJustDay.php',
            data : form_data,
            beforeSend : function() {
                $('#loader').show();
            },
            success : function(response) {
                $('#formSelJust').html(response);
                $(':file').filestyle({
                    buttonText : "Escolher Arquivo",
                    buttonName : "btn-primary"
                });
            },
            complete : function() {
                $('#loader').hide();
            },
            error : function() {
                console.log('erro ajax selAddJustDay');
            },
        });
        return false;
    });
    //------
    
    $('#setJustModal').on('hidden.bs.modal', function (e) {
        $('#setJustModal').html('');
        $('#setJustModal').load('../assets/modalAddJust.php');
    }); 
    $('#modal_justification').on('hidden.bs.modal', function (e) {
        $('#modal_justification').find('.modal-header').html('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
        $('#modal_justification').find('.modal-body').html('');
    }); 
    //-------
    
    
    $(document).on('change', '#inputNotificationStore, #checkbox_widget_late, #checkbox_widget_miss, #checkbox_widget_dayoff, #checkbox_widget_ontime', function() {
        select_store = $('#inputNotificationStore').val();
        localStorage.setItem('admin_store', select_store);
        input_late = ($('#checkbox_widget_late').prop('checked')) ? '1' : '0';
        input_miss = ($('#checkbox_widget_miss').prop('checked')) ? '1' : '0';
        input_dayoff = ($('#checkbox_widget_dayoff').prop('checked')) ? '1' : '0';
        input_ontime = ($('#checkbox_widget_ontime').prop('checked')) ? '1' : '0';
        localStorage.setItem('admin_checkbox_late', input_late);
        localStorage.setItem('admin_checkbox_miss', input_miss);
        localStorage.setItem('admin_checkbox_dayoff', input_dayoff);
        localStorage.setItem('admin_checkbox_ontime', input_ontime);
        
        $('.widget_content').load('../notifications/widget.php?store=' + select_store + '&late=' + input_late + '&miss=' + input_miss + '&dayoff=' + input_dayoff + '&ontime=' + input_ontime , function() {
            //callChangesOnWidget.abort();
            //getNotification(dateToday());
            createListeners();
            $('.glyphicon_justification').click(function(){
                data = $(this).data();
                $('#modal_justification').find('.modal-header').append(data.nameemp);
                $('#modal_justification').find('.modal-body').html('<img max-width=\'850px\' src=\'../../justifications/'+data.dsfile+'\' />');
                $('#modal_justification').modal('show');
            });
        });
    });
    
    (localStorage.getItem('admin_checkbox_late') == 1) ? $('#checkbox_widget_late').prop('checked',true) :  $('#checkbox_widget_late').prop('checked',false);
    (localStorage.getItem('admin_checkbox_miss') == 1) ? $('#checkbox_widget_miss').prop('checked',true) :  $('#checkbox_widget_miss').prop('checked',false);
    (localStorage.getItem('admin_checkbox_dayoff') == 1) ? $('#checkbox_widget_dayoff').prop('checked',true) :  $('#checkbox_widget_dayoff').prop('checked',false);
    (localStorage.getItem('admin_checkbox_ontime') == 1) ? $('#checkbox_widget_ontime').prop('checked',true) :  $('#checkbox_widget_ontime').prop('checked',false);
    $('#inputNotificationStore').val(localStorage.getItem('admin_store')).trigger("change");
    
       
	
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
    
    $(document).on('change', '#inputSelTimeMes, #inputSelTimeEmp', function() {
        if($('#inputSelTimeMes').val() != null && $('#inputSelTimeEmp').val() != null ){
            $('#form-selTime').submit();
        } 
    });
    $(document).on('change', '#inputRepTimeMes, #inputRepTimeEmp', function() {
        if($('#inputRepTimeMes').val() != null && $('#inputRepTimeEmp').val() != null ){
            $('#form-repTime').submit();
        } 
    });
    

    $(document).on('submit', '#form-repTime', function() {
        var form_data = $(this).serialize();
        $.ajax({
            type : "POST",
            url : 'formRepTime.php', 
            data : form_data,
            beforeSend : function() {
                $('#loader').show();
            },
            success : function(response) {
                $('#formRepTimeCont').html(response);
            },
            complete : function() {
                $('#loader').hide();
            },
            error : function() {
                console.log('erro ajax repTime');
            },
        });
        return false;
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
    
    $(document).on('submit', '#form-selTime', function() {
        var form_data = $(this).serialize();
        $.ajax({
            type : "POST",
            url : 'formEditTime.php', 
            data : form_data,
            beforeSend : function() {
                $('#loader').show();
            },
            success : function(response) {
                $('#formEditTimeCont').html(response);
                $('.uf5').mask('99:99');
                $('.glyphicon_justification').click(function(){
                    data = $(this).data();
                    $('#modal_justification').find('.modal-header').append(data.nameemp);
                    $('#modal_justification').find('.modal-body').html('<img max-width=\'850px\' src=\'../../justifications/'+data.dsfile+'\' />');
                    $('#modal_justification').modal('show');
                });
                
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
    

    //---------------------------------------------------------------
    //$('#inputSelTimeMes').val('201505').trigger("change");
    //$('#inputSelTimeEmp').val('28').trigger("change");
    //---------------------------------------------------------------
    
    
    
    
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

	//console.log($("#form-cadNewHoli input:checkbox:checked").length );
    if($("#form-cadNewHoli").length > 0){
        if($("#form-cadNewHoli input:checkbox:checked").length == 0){
            erro++;
        }
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
function isTime(str){
    var pattern = new RegExp("/([1-2][0-3]|[0-1][1-9]):([0-5][0-9])/");
    alert(pattern.test(str))
    return pattern.test(str);
}
function showImg(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#picture' + input.id).css('background-image', 'url(' + e.target.result + ')');
		};
		reader.readAsDataURL(input.files[0]);
	}
}


