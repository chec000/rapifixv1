<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    /*
      |--------------------------------------------------------------------------
      | Pagination Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines are used by the paginator library to build
      | the simple pagination links. You are free to change them to anything
      | you want to customize your views to better match your application.
      |
     */
    'general' => [
        'list_cedis'=>'Lista CEDIS',
        'add_cedis'=>'Agregar CEDIS',
        'name'=>'Nombre',
        'country'=>'País',
        'latitude'=>'Latitud',
        'longitude'=>'Longitud',
        'status'=>'Estado',
        'actions'=>'Acciones',
        'active'=>'CEDIS Activo',
        'inactive'=>'CEDIS Inactivo',
        'edit'=>'Editar CEDIS',
        'delete'=>'Eliminar CEDIS',
        'general_info'=>'Información General',
        'images'=>'Imágenes',
        'save' => 'Guardar'
    ],
    'add' => [
        'new'=>'Agregar CEDIS nuevo',
        'description'=>'Descripción',
        'city'=>'Ciudad',
        'state'=>'Estado',
        'schedule'=>'Horario',
        'banner'=>'Imagen de estandarte',
        'banner_link'=>'Enlace de imagen de estandarte',
        'address'=>'Dirección ',
        'neighborhood'=>'Colonia',
        'postal_code'=>'Codigo Postal',
        'phone_number_01'=>'Numero de telefono 01',
        'phone_number_02'=>'Numero de telefono 02',
        'telemarketing'=>'Numero de telemarketing',
        'fax'=>'Numero de fax',
        'email'=>'Correo electronico',
        'image_01'=>'Imagen 01',
        'image_02'=>'Imagen 02',
        'image_03'=>'Imagen 03',
        'select_country'=>'Seleccionar país',
        'success_save'=>'El CEDIS ha sido creado exitosamente ',
        'success_update'=>'El CEDIS ha sido creado exitosamente ',
        'success_delete'=>'El CEDIS ha sido creado exitosamente ',
        'empty_lang_fields'=>'Deberá llenar por lo menos un idioma con los siguientes campos: nombre, estado, ciudad y horario. ',
    ],
    'edit' => [
        'edit'=>'Editar CEDIS'
    ],
    'validation' => [
        'country'=>'Se requiere país',
        'address'=>'Se requiere domicilio',
        'neighborhood'=>'Se requiere colonia',
        'phone_number_01'=>'El numero de teléfono 01 se requiere',
        'latitude'=>'Se requiere la latitud',
        'longitude'=>'Se requiere la longitud',
        'image_01'=>'La imagen 01 se requiere',
    ],
    'errors' => [
        'not_ajax'=>'La solicitud debe de ser AJAX',
        'not_params'=>'Los parámetros estan incompletos '

    ]
];
