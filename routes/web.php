<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\GuestForm;
use App\Livewire\QueueTicket;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/antrian', GuestForm::class)->name('antrian.form');
Route::get('/antrian/{antrian}', QueueTicket::class)->name('antrian.ticket');