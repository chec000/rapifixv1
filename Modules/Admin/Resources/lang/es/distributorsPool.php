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
        'dist_pool'=>'Grupo de distribuidores ',
        'country'=>'País ',
        'dist_code'=>'Codigo de distribuidor',
        'dist_name'=>'Nombre de distribuidor ',
        'dist_email'=>'Correo electronico del distribuidor ',
        'dist_used'=>'Usado',
        'dist_not_used'=>'No usado',
        'add_dist'=>'Agregar distribuidor',
        'delete_dist'=>'Eliminar distribuidor',
        'edit_dist'=>'Editar distribuidor',
        'load_csv'=>'Cargar CSV ',
        'download_csv'=>'Descargar ejemplo CSV ',
        'yes'=>'Si',
        'no'=>'No',
        'are_sure'=>'¿Esta seguro? ',
        'cancel'=>'Cancelar',
        'delete'=>'Eliminar',
        'success'=>'Éxito',
        'error'=>'Error',
        'close'=>'Cerrar'
    ],
    'add' => [
        'new_dist' => 'Agregar nuevo distribuidor',
        'success_save'=>'El distribuidor ha sido creado exitosamente',
        'success_update'=>'El distribuidor ha sido actualizado exitosamente',
        'success_delete'=>'El distribuidor ha sido eliminado exitosamente'
    ],
    'edit' => [
        'edit_dist'=>'Editar distribuidor'
    ],
    'validation' => [
        'code_req'=>'Se requiere el codigo de distribuidor ',
        'code_uniq'=>'El codigo de distribuidor ya existe',
        'name'=>'Se requiere el nombre',
        'email_req'=>'Se requiere el correo electronico',
        'email_ema'=>'El correo electronico debe de ser valido',
        'client_adm'=>'No se puede agregar a un cliente admirable',
        'country'=>'Se requiere el pais',
        'file'=>'Se requiere el archivo ',
        'file_type'=>'El archivo debe ser CSV ',
        'incomplete'=>'Los datos estan incompletos '
    ],
    'csv' => [
        'dist_file' => 'Archivos de distribuidor por país',
        'file_ext' => 'Subir archivo con una extensión .csv',
        'file_demo' => 'Archivo base',
        'download_base_file' => 'Bajar archivo base',
        'instructions' => 'Instrucciones',
        'inst_01' => 'Bajar archivo demo CSV haciendo click debajo ',
        'inst_02' => 'Llenar con la informacion correspondiente en las columnas de Codigo de Empresario, Nombre y correo electronico. Dependiento de la cantidad de empresarios en el grupo, sera el numero de filas que tendra el archivo.',
        'inst_03' => 'Guardar cambios y subir el archivo actualizado de aquí',
        'upload' => 'Subir'
    ]
];
