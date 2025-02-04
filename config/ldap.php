<?php

return [
    'connections' => [
        'default' => [
            'hosts' => explode(',', env('LDAP_HOSTS', '')),
            'port' => env('LDAP_PORT', 389),
            'timeout' => env('LDAP_TIMEOUT', 5),
            'base_dn' => env('LDAP_BASE_DN', 'DC=indonesiapower,DC=corp'),
            'username' => env('LDAP_USERNAME'),  // ✅ Menggunakan variabel yang benar
            'password' => env('LDAP_PASSWORD'),  // ✅ Menggunakan variabel yang benar
            'use_ssl' => env('LDAP_USE_SSL', false),
            'use_tls' => env('LDAP_USE_TLS', false),
        ],
    ],
];