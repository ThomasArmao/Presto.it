<?php

use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\RevisorController;
use Illuminate\Auth\Middleware\IsRevisor;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::post('/lingua/{lang}', [HomepageController::class, 'setLanguage'])->name('scegli.lingua');

Route::get('/', [HomepageController::class, 'homepage'])->name('homepage');

Route::middleware("auth")->group(function () {


    Route::get('inserisci/annuncio', [AnnouncementController::class, 'create'])->name('annuncio.create');
    Route::get('i-miei-annunci', [AnnouncementController::class, 'myAnnouncements'])->name('i.tuoi.annunci');
    Route::get('lavora-con-noi', [RevisorController::class, 'workWithUsForm'])->name('diventa.revisore');
    Route::post('lavora-con-noi/mail', [RevisorController::class, 'workWithUs'])->name('invia.mail');
    
});

Route::get('annunci/ricerca', [AnnouncementController::class, 'filter'])->name('annunci.ricerca');
Route::get('annunci', [AnnouncementController::class, 'index'])->name('annunci.index');
Route::get('annuncio/{id}', [AnnouncementController::class, 'show'])->name('annunci.show');
Route::get('annunci/{category}', [HomepageController::class, 'filterAnnouncements'])->name("annunci.filter");

Route::get('/category/show/{category}}', [HomepageController::class, 'filterCategory'])->name('annunci.categoria');


Route::get('accetta/revisore/{user}', [RevisorController::class, 'makeRevisor'])->name('make.revisor');



#Rotte per revisor
Route::middleware("isRevisor")->group(function () {
    Route::get('revisor/', [RevisorController::class, 'index'])->name('revisor.index');
    #Rotta per accettazione annuncio
    Route::patch('accetta/annuncio/{announcement}', [RevisorController::class, 'acceptAnnouncement'])->name('accept_announcement');
    #Rotta per rifiuto annuncio
    Route::patch('rifiuta/annuncio/{announcement}', [RevisorController::class, 'rejectAnnouncement'])->name('reject_announcement');
});
