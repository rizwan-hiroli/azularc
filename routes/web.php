<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeAdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task', function () {
    
    $input = new \App\Classes\NumericInput();
    $input->add('1');
    $input->add('a');
    $input->add('0');
    echo "1, a, 0 =>".$input->getValue().'<br>';

    $input = new \App\Classes\NumericInput();
    $input->add('20');
    $input->add('a');
    $input->add('b');
    echo "20, a, b =>".$input->getValue().'<br>';

    $input = new \App\Classes\NumericInput();
    $input->add('c');
    $input->add('a');
    $input->add('b');
    echo "c, a, b =>".$input->getValue().'<br>';
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/employees', [EmployeeAdminController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeAdminController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeAdminController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}/edit', [EmployeeAdminController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeAdminController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeAdminController::class, 'destroy'])->name('employees.destroy');

