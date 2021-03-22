<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\EloquentAlbumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::view('/maintenance', 'maintenance')->name('maintenance');

Route::middleware(['admin-maintenance'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin', [AdminController::class, 'update'])->name('admin.update');
});

Route::middleware(['custom-auth'])->group(function () {
    Route::middleware(['not-blocked'])->group(function () {
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::view('/blocked', 'blocked')->name('blocked');
});


Route::middleware(['maintenance-mode'])->group(function () {
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlist.index');
    Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
    Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
    Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlist.update');

    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
    Route::get('albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
    Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

    Route::get('/eloquent/albums', [EloquentAlbumController::class, 'index'])->name('eloquentalbum.index');
    Route::get('/eloquent/albums/create', [EloquentAlbumController::class, 'create'])->name('eloquentalbum.create');
    Route::post('/eloquent/albums', [EloquentAlbumController::class, 'store'])->name('eloquentalbum.store');
    Route::get('/eloquent/albums/{id}/edit', [EloquentAlbumController::class, 'edit'])->name('eloquentalbum.edit');
    Route::post('/eloquent/albums/{id}', [EloquentAlbumController::class, 'update'])->name('eloquentalbum.update');

    Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
    Route::get('/tracks/new', [TrackController::class, 'new'])->name('track.new');
    Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');

    Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
    Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
});

Route::get('/eloquent', function() {
    // Querying
    //Artist::all();

    // return view('eloquent.artists', [
    //     'artists' => Artist::orderBy('name', 'desc')->get(),
    // ]);

    // return view('eloquent.tracks', [
    //     'tracks' => Track::all(),
    // ]);

    // return view('eloquent.tracks', [
    //     'tracks' => Track::where('unit_price', '>', 0.99)->orderBy('name')->get(),
    // ]);

    // return view('eloquent.artist', [
    //     'artist' => Artist::find(3),
    // ]);

    // $genre = new Genre();
    // $genre->name = 'Hip Hop';
    // $genre->save();

    // $genre = Genre::find(26);
    // $genre->delete();

    // $genre = Genre::where('name', '=', 'Alternative and Punk')->first();
    // $genre->name = "Alternative & Punk";
    // $genre->save;

    //Relationships

    // return view('eloquent.has-many', [
    //     'artist' => Artist::find(50),
    // ]);

    // return view('eloquent.belongs-to', [
    //     'album' => Album::find(152),
    // ]);

    //Eager Loading
    //has the n+1 problem
    // return view('eloquent.eager-loading', [
    //     'tracks' =>Track::where('unit_price', '>', 0.99)
    //         ->orderBy('name')
    //         ->limit(5)
    //         ->get(),
    // ]);

    //fixes the n+1 problem
    return view('eloquent.eager-loading', [
        'tracks' =>Track::with('album')
            ->where('unit_price', '>', 0.99)
            ->orderBy('name')
            ->limit(5)
            ->get(),
    ]);

});

if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}