<input type='hidden' id='hd_chan_flag' name='hd_chan_flag' value="{hd_changelog}" />
<!-- Modal CHANGELOG -->
<div class="modal fade" id="modal_changelog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Cambios en Educalinks</h4>
            </div>
            <div class="modal-body">
                {modal_changelog_body}
            </div>

            <div class="modal-footer">
                <label style="padding-right: 5%;" for="chk_mostrar">
                <input type="checkbox" id="chk_mostrar" name="chk_mostrar" /> <strong>No, volver a mostrar esto</strong>
                </label>
                <button id="btn_aceptar" type="button" class="btn btn-success" onclick="cerrar_changelog();">Entendido!</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
        	<div class="col-md-12 bottom_10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    	<h3 class="panel-title">Opciones Principales</h3>
                    </div>
                    <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="../../includes/medic/images/atenciones.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Nueva Atención de Alumnos</h3>
                                    <p class="text-justify">Registro de Informacion de una nueva atención médica de un estudiante de la institución.</p>
                                    <p class="text-center"><a href="../../medic/cons_estudiantes/" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Atención de Alumnos</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="../../includes/medic/images/atenciones_personal.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Nueva Atención de Personal</h3>
                                    <p class="text-justify">Registro de Informacion de una nueva atención médica de personal docente o administrativo.</p>
                                    <p class="text-center"><a href="../../medic/cons_visitas/" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Atención de Personal</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="../../includes/medic/images/reportes.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Reporte de Atenciones</h3>
                                    <p class="text-justify">Reporte detallado de las atenciones realizadas el día especificado por el usuario</p>
                                    <p class="text-center"><a href="../../medic/rep_atenciones/" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Reporte de Atenciones</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="../../includes/medic/images/fichas.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Ingreso de Ficha</h3>
                                    <p class="text-justify">Registro de Informacion médica de una persona para conocimiento del Director del Departamento Médico.</p>
                                    <p class="text-center"><a href="../../medic/ficha_nuevo/" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Ingreso de Ficha</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>