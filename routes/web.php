<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('api/notes', [NoteController::class, 'index'])->name('notes.index');
Route::post('api/notes', [NoteController::class, 'store'])->name('notes.store');
Route::get('api/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
Route::put('api/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
Route::delete('api/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
