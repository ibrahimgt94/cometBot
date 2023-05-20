<?php

use Comet\Face\Atom\Route\Bot as Route;

Route::node("main")
   ->role("user")
   ->sole("back.test", "boot")
   ->bridge("glass");
