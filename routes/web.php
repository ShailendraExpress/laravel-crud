<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController; // this is the controller named MyController, we build.

Route::get('/', function () {
    return view('index');  //showing the index page
});

Route::post('savedata', [MyController::class, 'savedata'])->name('savedata'); // save data into database
Route::get('getdata', [MyController::class, 'getdata'])->name('getdata'); // retrieve data into database
Route::post('editdata', [MyController::class, 'editdata'])->name('editdata'); // update data
Route::post('deletedata', [MyController::class, 'deletedata'])->name('deletedata'); // delete data