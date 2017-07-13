<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una nueva categoria',
		VIEW_SET_GET_ALL=>'Crear y mostrar las categorias',
        VIEW_GET=>'Buscar Categoria',
        VIEW_GET_ALL=>'Modificación de factura',					  
        VIEW_DELETE=>'Eliminar una Categoria',
        VIEW_EDIT=>'Modificar Categoria',
		VIEW_CAJA_CERRADA=>'Cobro de Deudas'
                     ),
	'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu313}', 
		    'open'  => '{open3}',
        'mainmenu' => '{menu3}' 
                        ),
	'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()