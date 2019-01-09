<?php

return [

	/*
    |--------------------------------------------------------------------------
    | End Point Api ( Konfigurasi Server Akun )
    |--------------------------------------------------------------------------
    |
    | Starter : http://api.rajaongkir.com/starter
    | Basic : http://api.rajaongkir.com/basic
    | Pro : http://api.rajaongkir.com/api
    |
    */

	'end_point_api' => env('RAJAONGKIR_ENDPOINTAPI', 'http://api.rajaongkir.com/starter'),

	/*
    |--------------------------------------------------------------------------
    | Api key
    |--------------------------------------------------------------------------
    |
    | Isi dengan api key yang didapatkan dari rajaongkir
    |
    */

	'api_key' => env('RAJAONGKIR_APIKEY', 'fbf6a2ea2c51563bf9aae4f8ecdc5a1a'),
];