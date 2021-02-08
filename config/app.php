<?php

return [

    'name' => 'myschool',

    'root_url' => $_SERVER['SERVER_ADMIN'] === 'localhost' ? '/myschool/' : '/',

    'document_root' => $_SERVER['SERVER_ADMIN'] === 'localhost' ? '/myschool/public/' : '/'
];
