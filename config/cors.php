<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

     'allowed_origins' => ['*'],

    // 'allowed_origins' => [
    //     'http://localhost:5173',  // Vue.js web
    //     'http://localhost:19006', // Expo (React Native en dev)
    //     'exp://127.0.0.1',         // Expo Go local
    //     'http://192.168.0.10:3000' // IP si tu testes en réseau local
    // ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // ✅ Obligatoire pour Sanctum, cookies, sessions

];
