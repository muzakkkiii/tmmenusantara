<?php

return [
    'paths' => [
        resource_path('views'),
    ],
    // Gunakan path string langsung. Jangan pakai realpath() saja karena
    // realpath() mengembalikan false bila folder belum ada -> menyebabkan
    // error "Please provide a valid cache path" pada Blade compiler.
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views')) ?: storage_path('framework/views')
    ),
];
