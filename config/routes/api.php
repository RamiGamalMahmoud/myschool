<?php

use Simple\Core\Route;

Route::get('error', CONTROLLRES . 'Error@error');

Route::post('login', CONTROLLRES . 'Login@authenticate');
