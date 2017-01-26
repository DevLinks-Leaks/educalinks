<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a data-toggle="modal" data-target="#modal_tipo_add"
                 class="btn btn-success" onclick="document.getElementById('tipo_deta').value=''">
                    <span class="fa fa-plus" aria-hidden="true"></span> Nuevo Tipo
                    </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_tipos" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Detalle</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_tipo_view()}";
                        $tipo_view = sqlsrv_query($conn, $sql, $params);
                        while($row_tipo_view = sqlsrv_fetch_array($tipo_view)){

                        ?>
                            <tr>
                                <td width="77%"><?= $row_tipo_view['tipo_deta'];?> </td>
                                <td width="23%">
                                    <?php if(!$row_tipo_view['tipo_default']){ ?>
                                    <a  data-toggle="modal" data-target="#modal_tipo_edit"
                                     class="btn btn-primary" onclick="document.getElementById('tipo_deta_edit').value='<?= $row_tipo_view['tipo_deta']?>';document.getElementById('tipo_codi').value='<?= $row_tipo_view['tipo_codi']?>';"
                                    >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_tipo_del"
                                    onclick="document.getElementById('tipo_codi_del').value='<?= $row_tipo_view['tipo_codi']?>';">
                                    <span class="fa fa-trash-o" aria-hidden="true"></span> Eliminar
                                    </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php   } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>