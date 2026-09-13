<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectMediaController;
use App\Http\Controllers\Admin\ProposalController as AdminProposalController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Specialist\DashboardController as SpecialistDashboardController;

use App\Http\Controllers\Admin\SpecialistController;
use App\Http\Controllers\PublicServiceController;
use App\Http\Controllers\SpecialistController as ControllersSpecialistController;

use App\Http\Controllers\ProposalController;
use App\Http\Controllers\PublicProjectController;

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


/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/

Route::get('/', [Controller::class, 'home'])->name('home');

Route::get('/vision', [Controller::class, 'vision'])->name('vision');

Route::post('/storeContact', [StoreController::class, 'storeContact'])->name('storeContact');

Route::get('/specialists', [ControllersSpecialistController::class, 'index'])->name('specialists.index');

Route::get('/specialists/{specialist}', [ControllersSpecialistController::class, 'show'])->name('specialists.show');

Route::get('/services', [PublicServiceController::class, 'index'])->name('services.index');

Route::get('/services/{service:slug}', [PublicServiceController::class, 'show'])->name('services.show');

Route::get('/proposals/{token}', [ProposalController::class, 'show'])->name('proposals.public.show');

Route::post('/proposals/{token}/approve', [ProposalController::class, 'approve'])->name('proposals.public.approve');

Route::post('/proposals/{token}/reject', [ProposalController::class, 'reject'])->name('proposals.public.reject');

Route::get('/projects', [PublicProjectController::class, 'index'])->name('projects.index');

Route::get('/projects/{project:slug}', [PublicProjectController::class, 'show'])->name('projects.show');

/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
*/

Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');

Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});


Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('specialists', SpecialistController::class);

        Route::resource('services', ServiceController::class)->except(['show']);

        Route::resource('projects', ProjectController::class);

        Route::resource('proposals', \App\Http\Controllers\Admin\ProposalController::class);

        Route::post('proposals/{proposal}/send', [AdminProposalController::class, 'send'])->name('proposals.send');

        Route::get('projects/create-from-proposal/{proposal}', [ProjectController::class, 'createFromProposal'])->name('projects.create-from-proposal');

        Route::post('projects/{project}/media', [ProjectMediaController::class, 'store'])->name('projects.media.store');

        Route::put('projects/{project}/media/{media}', [ProjectMediaController::class, 'update'])->name('projects.media.update');

        Route::delete('projects/{project}/media/{media}', [ProjectMediaController::class, 'destroy'])->name('projects.media.destroy');
    });


/*
|--------------------------------------------------------------------------
| Specialist
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('specialist')
    ->name('specialist.')
    ->group(function () {
        Route::get('/dashboard', [SpecialistDashboardController::class, 'index'])->name('dashboard');
    });
