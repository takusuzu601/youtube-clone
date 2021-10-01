<?php

use App\Http\Controllers\ChannelController;
use App\Http\Livewire\Video\AllVideo;
use App\Http\Livewire\Video\CreateVideo;
use App\Http\Livewire\Video\EditVideo;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/channel/{channel}/edit', [ChannelController::class, 'edit'])->name('channel.edit');
});

Route::middleware('auth')->group(function () {

    Route::get('/videos/{channel}/create', CreateVideo::class)->name('video.create');

    Route::get('/videos/{channel}/{video}/edit', EditVideo::class)->name('video.edit');

    Route::get('/videos_all', AllVideo::class)->name('video.all');
});
