<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mensajes de Validación
    |--------------------------------------------------------------------------
    */

    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'max' => [
        'string' => 'El campo :attribute no debe tener más de :max caracteres.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'digits_between' => 'El campo :attribute debe tener entre :min y :max dígitos.',
    'regex' => 'El formato de :attribute no es válido.',
    'unique' => 'El :attribute ya está en uso.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'confirmed' => 'La confirmación de :attribute no coincide.',

    'attributes' => [
        'name' => 'nombre',
        'last_name' => 'apellido',
        'phone_number' => 'teléfono',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'roles_id' => 'rol',
    ],

];
