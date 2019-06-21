<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 16/04/2018
 * Time: 02:47 PM
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

    'user_list' => [
        'usr_lst'=>'Lista de usuario',
        'user'=>'Usuario',
        'name'=>'Nombre',
        'role'=>'Rol',
        'lang'=>'Idioma',
        'brands'=>'Marca',
        'countries'=>'Paises',
        'actions'=>'Acciones',
        'active'=>'Activo',
        'disabled'=>'Inhabilitado',
        'enable_user'=>'Habilitar usuario',
        'disable_user'=>'Inhabilitar usuario',
        'edit_user'=>'Editar usuario',

        'msg_cant_disabled_own_account'=>'No puede inhabilitar su propia cuenta',
        'msg_cant_disabled_user'=>'No se puede inhabilitar este usuario',
        'msg_cant_delete_own_account'=>'No puede borrar su propia cuenta',

    ],
    'form_add' => [
        'title_form_add' => 'Agregar Nuevo Usuario',
        'account_password' => 'Contraseña de la cuenta:',
        'add_another_user' => 'Agregar otro usuario',
        'back_user_list' => 'Regresar a la lista de usuarios',
        'user_name' => 'Nombre de usuario',
        'user_position' => 'Posición de usuario',
        'user_email' => 'Correo electrónico de usuario',
        'user_role' => 'Rol del usuario',
        'language' => 'Idioma',
        'brands' => 'Marcas',
        'countries' => 'Paises',
        'int_password' => 'Contraseña',
        'confirm_int_password' => 'Confirmar contraseña',
        'send_email' => 'Enviar correo',
        'add_user' => 'Agregar usuario',

        'msg_account_created' => '!La cuenta :email ha sido creado con éxito!',
        'msg_error_bd' => 'Ha ocurrido un error al tratar de guardar su usuario. Por favor notificar el area de TI. ',
        'msg_email_sent' => 'Se ha enviado un correo electronico al nuevo usuario con sus detalles de acceso.',
        'msg_error_email_sent' => 'Hubo un error al enviar los detalles de inicio de sesión al nuevo usuario.',
        'msg_no_permission_create' => 'No tiene permiso para crear usuarios con este rol, o no existe. ',
    ],
    'form_edit' => [
        'title_form_edit'=>'Editar usuario',

        'date_created'=>'Fecha creado',
        'account_status'=>'Estado de cuenta',

        'active'=>'Activo',
        'disabled'=>'Inhabilitado ',

        'account_password'=>'Contraseña de la cuenta:',
        'back_user_list'=>'Regresar a la lista de usuarios',
        'user_name'=>'Nombre de usuario',
        'user_position'=>'Posicion de usuario',
        'user_email'=>'Usuario de correo electronico',
        'user_role'=>'Usuario de rol',
        'language'=>'Idioma',
        'brands'=>'Marcas',
        'countries'=>'Paises',
        'int_password'=>'Contraseña',
        'current_pass'=>'Contraseña actual',
        'new_pass'=>'Nueva contraseña',
        'confirm_int_password'=>'Confirmar contraseña',
        'send_email'=>'Enviar correo ',
        'edit_user'=>'Editar usuario',

        'change_pass'=>'Cambiar contraseña',
        'update_pass'=>'Actualizar contraseña',
        'btn_update'=>'Actualizar',

        'msg_account_updated'=>'La cuenta :email ha sido actualizado exitosamente! ',
        'msg_error_bd'=>'Ocurrio un error al intentar de guardar su usuario, por favor notifique al area de TI.',
        'msg_email_sent'=>'Un correo ha sido enviado al usuario con sus detalles de acceso. ',
        'msg_error_email_sent'=>'Ocurrio un error al mandar los detalles de nuevo usuario.',
        'msg_no_permission_create'=>'No se tiene permiso para crear un usuario con este rol, o no existe. ',
        'msg_cant_edit'=>'No se puede editar a este usuario',
        'msg_user_not_found'=>'No se encontro el usuario',
    ]
];