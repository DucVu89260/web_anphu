<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsultingRequestController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaProxyController;

use App\Http\Controllers\FacebookPostController;
use App\Http\Middleware\CheckSuperAdminMiddleware;


Route::get('/', [CustomerController::class, 'index'])->name('customers.index');

// Media proxy route for serving images (local or Cloudinary)
Route::get('/media/{media}', [MediaProxyController::class, 'serve'])->name('media.serve');

Route::get('/about/{slug}', [CustomerController::class, 'showCustomPage'])
    ->name('customers.custom_page');

Route::get('/dich-vu/{slug}', [CustomerController::class, 'serviceDetail'])->name('customers.service.detail');
Route::get('/bao-gia/{slug}', [CustomerController::class, 'servicePrice'])->name('customers.service.price');
Route::get('/chinh-sach', [CustomerController::class, 'policyDetail'])->name('customers.policy.detail');

Route::get('/du-an/danh-muc/{slug}', [CustomerController::class, 'projectByCategory'])
    ->name('projects.byCategory');
Route::get('/du-an/{slug}', [CustomerController::class, 'projectDetail'])
->name('customers.project.detail');

Route::get('/bai-dang/danh-muc/{slug}', [CustomerController::class, 'blogIndex'])
->name('customers.blog.index');
Route::get('/bai-dang/{slug}', [CustomerController::class, 'blogDetail'])
->name('customers.blog.detail');

Route::get('/tu-van', [CustomerController::class, 'consultant'])
->name('customers.consultant');

Route::get('/lien-he', [CustomerController::class, 'contact'])
->name('customers.contact');

Route::get('/uu-dai', [CustomerController::class, 'voucher'])
->name('customers.voucher');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'processLogin'])->name('process_login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('process_register');
});

Route::post('/consulting-requests/store', [ConsultingRequestController::class, 'store'])
   ->name('consulting_requests.store');

Route::post('/consulting-request/callback', [ConsultingRequestController::class, 'callbackRequest'])
   ->name('consulting_requests.callback');


//Admin
Route::prefix('admin')->name('admin.')
    ->middleware('auth')
    ->group(function () {

   Route::get('logout', [AuthController::class, 'logout'])->name('auths.logout');

   Route::resource('portfolios', PortfolioController::class)->except([
      'destroy'
   ]);

   Route::resource('articles', ArticleController::class)->except([
      'destroy'
   ]);

   Route::post('/media/upload-image', [MediaController::class, 'uploadImage'])
      ->name('media.uploadImage');

   // Fetch remote image via server-side to bypass browser CORS and return stable proxy URL
   Route::post('/media/fetch-remote', [MediaController::class, 'fetchRemote'])
      ->name('media.fetchRemote');


   Route::resource('categories', CategoryController::class)->except([
      'destroy'
   ]);

   Route::resource('partners', PartnerController::class)->except([
      'destroy'
   ]);

   Route::resource('services', ServiceController::class)->except([
      'destroy'
   ]);

   Route::resource('custom_pages', CustomPageController::class)->except([
      'destroy'
   ]);

   Route::resource('users', UserController::class)->except([
      'destroy'
   ]);

   Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])
      ->name('users.resetPassword');
      
   
   Route::get('consulting-requests/index', [ConsultingRequestController::class, 'index'])
   ->name('consulting_requests.index');

   Route::put('consulting-requests/edit', [ConsultingRequestController::class, 'edit'])
   ->name('consulting_requests.edit');

   Route::delete('consulting-requests/{id}', [ConsultingRequestController::class, 'destroy'])
   ->name('consulting_requests.destroy');

   Route::patch('consulting-requests/{id}/status', [ConsultingRequestController::class, 'updateStatus'])
   ->name('consulting_requests.updateStatus');

   Route::prefix('settings')->name('settings.')->group(function () {
      Route::get('company/', [CompanySettingController::class, 'edit'])->name('company.edit');
      Route::put('company/', [CompanySettingController::class, 'update'])->name('company.update');
      Route::get('company/policy', [CompanySettingController::class, 'editPolicy'])->name('company.editPolicy');
      Route::put('company/policy', [CompanySettingController::class, 'updatePolicy'])->name('company.updatePolicy');
      Route::post('company/policy/check-password', [CompanySettingController::class, 'checkAdminPassword'])->name('company.updatePolicy.checkPassword');
   });

   Route::middleware(CheckSuperAdminMiddleware::class)->group(function () {
      Route::delete('portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
      Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
      Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
      Route::delete('partners/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');
      Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
      Route::delete('custom_pages/{custom_page}', [CustomPageController::class, 'destroy'])->name('custom_pages.destroy');
      Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

   });

   
   Route::prefix('facebook')->group(function () {
      Route::get('/', [FacebookPostController::class, 'index'])->name('facebook.index');
      Route::get('/{id}/edit', [FacebookPostController::class, 'edit'])->name('facebook.edit');
   });

});