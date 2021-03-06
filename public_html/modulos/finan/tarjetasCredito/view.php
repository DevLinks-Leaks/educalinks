<?php
session_start();
require_once("../../../core/viewBase.php");

$diccionario = array(
    'subtitle'=>array(
        VIEW_SET=>'Crear una tarjeta de crédito',
        VIEW_SET_GET_ALL=>'Crear y mostrar las tarjetas de crédito',
        VIEW_GET=>'Buscar tarjeta de crédito',
        VIEW_GET_ALL=>'Consultar todas las tarjetas de crédito',                     
        VIEW_DELETE=>'Eliminar una tarjeta de crédito',
        VIEW_EDIT=>'Modificar tarjeta de crédito'
                     ),
    'links_menu'=>array(
        'VIEW_SET'=>MODULO.VIEW_SET.'/',
        'VIEW_SET_GET_ALL'=>MODULO.VIEW_SET_GET_ALL.'/',
        'VIEW_GET'=>MODULO.VIEW_GET.'/',
        'VIEW_GET_ALL'=>MODULO.VIEW_GET_ALL.'/',        
        'VIEW_EDIT'=>MODULO.VIEW_EDIT.'/',
        'VIEW_DELETE'=>MODULO.VIEW_DELETE.'/'
                        ),
    'form_actions'=>array(
        'SET'=>API.MODULO.SET.'/',
        'SET_GET_ALL'=>API.MODULO.SET_GET_ALL.'/',
        'GET'=>API.MODULO.GET.'/',
        'GET_ALL'=>API.MODULO.GET_ALL.'/',
        'DELETE'=>API.MODULO.DELETE.'/',
        'EDIT'=>API.MODULO.EDIT.'/'
                        ),
    'rutas_head'=>array(),
    'active_menu'=>array(
        'submenu'  => '{menu209}',
        'open'  => '{open2}', 
        'mainmenu' => '{menu21}' 
                        ),
    'usua_datos'=>array(
        'usua_nombres'  => $_SESSION['usua_nombres'], 
        'usua_apellidos' => $_SESSION['usua_apellidos'] 
                        )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array()