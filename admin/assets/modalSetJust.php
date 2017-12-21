<div class="modal fade" id="setJustModal" data-backdrop='static' tabindex="-1" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Selecione </h4>
            </div>
            <form class="form-horizontal " role="form"  method="post" id="formSetJust" enctype="multipart/form-data" >
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputSelSetJust" class="col-sm-2 col-sm-offset-1 control-label">Razão</label>
                        <div class="col-sm-7">
                            <select class="form-control" id="inputSelSetJust" name="inputSelSetJust">
                                <option value="" disabled selected>Escolha</option>
                                <option value="late" >Advertência ou Notificação</option>
                                <option value="medic" >Atestado Médico</option>
                                <option value="declaration" >Declaração Sem Abono</option>
                                <option value="latemanager" >Atraso de Gerente</option>
                                <option value="holiday" >Feriado</option>
                                <option value="vacation" >Férias</option>
                                <option value="other" >Outro</option>
                            </select>
                        </div>
                    </div>
                    <div id='fieldsJustification'></div>
                </div>
                <div class="modal-footer">
                    <div class='errorMessage'>

                    </div>
                    <button type="submit" class="btn btn-primary">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>