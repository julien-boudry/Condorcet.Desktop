<?php

use App\Livewire\ElectionManager;
use Illuminate\Support\Facades\Route;

Route::get('/', ElectionManager::class)->name('home');
