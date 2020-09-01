<?php

use Simple\Core\Route;

Route::get('.*', CONTROLLRES . 'IndexController@sayHi');