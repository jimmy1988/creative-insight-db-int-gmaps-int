<?php

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


/*
*   FRONTEND AUTHENTICATION ROUTES
*/
// Route::get("/login", "\App\Http\Controllers\Auth\Frontend\FrontendLoginController@showLoginForm")->name("frontend.login.showLoginForm");
// Route::post("/login", "\App\Http\Controllers\Auth\Frontend\FrontendLoginController@login")->name("frontend.login");
// Route::post("/logout", "\App\Http\Controllers\Auth\Frontend\FrontendLoginController@logout")->name("frontend.logout");
// Route::post("/password/email", "\App\Http\Controllers\Auth\Frontend\FrontendForgotPasswordController@sendResetLinkEmail")->name("frontend.password.email");
// Route::get("/password/reset", "\App\Http\Controllers\Auth\Frontend\FrontendForgotPasswordController@showLinkRequestForm")->name("frontend.password.request");
// Route::post("/password/reset", "\App\Http\Controllers\Auth\Frontend\FrontendResetPasswordController@reset")->name("frontend.password.update");
// Route::get("/password/reset/{token}", "\App\Http\Controllers\Auth\Frontend\FrontendResetPasswordController@showResetForm")->name("frontend.password.reset");
// Route::get("/register", "\App\Http\Controllers\Auth\Frontend\FrontendRegisterController@showRegistrationForm")->name("frontend.register.showRegistrationForm");
// Route::post("/register", "\App\Http\Controllers\Auth\Frontend\FrontendRegisterController@register")->name("frontend.register");

/*
*   FRONTEND ROUTES
*/
Route::get('/', "FrontendPagesController@index")->name('index');

/*
*   BACKEND AUTHENTICATION ROUTES
*/
Route::get("/admin/login", "\App\Http\Controllers\Auth\Backend\BackendLoginController@showLoginForm")->name("admin.login.showLoginForm");
Route::post("/admin/login", "\App\Http\Controllers\Auth\Backend\BackendLoginController@login")->name("admin.login");
Route::match(['post', 'get'],"/admin/logout", "\App\Http\Controllers\Auth\Backend\BackendLoginController@logout")->name("admin.logout");
Route::post("/admin/password/email", "\App\Http\Controllers\Auth\Backend\BackendForgotPasswordController@sendResetLinkEmail")->name("admin.password.email");
Route::get("/admin/password/reset", "\App\Http\Controllers\Auth\Backend\BackendForgotPasswordController@showLinkRequestForm")->name("admin.password.request");
Route::post("/admin/password/reset", "\App\Http\Controllers\Auth\Backend\BackendResetPasswordController@reset")->name("admin.password.update");
Route::get("/admin/password/reset/{user}/{token}", "\App\Http\Controllers\Auth\Backend\BackendResetPasswordController@showResetForm")->name("admin.password.reset");
Route::get("/admin/email/verify/{user}/{token}", "\App\Http\Controllers\Auth\Backend\BackendVerificationController@verifyUser")->name("admin.email.verify");

/*
*   BACKEND ROUTES
*/

Route::get('/admin', "AdminPagesController@index")->name('admin.index');

Route::get('/admin/users', "AdminPagesController@allUsers")->name('admin.users');
Route::get('/admin/user/profile', "AdminPagesController@userProfile")->name('admin.user.profile');
Route::get('/admin/user/add', "\App\Http\Controllers\Auth\Backend\BackendRegisterController@showRegistrationForm")->name('admin.user.add.showForm');
Route::post('/admin/user/add', "\App\Http\Controllers\Auth\Backend\BackendRegisterController@register")->name('admin.user.add');
Route::get('/admin/user/edit/{user}', "AdminPagesController@showEditUserForm")->name('admin.user.edit.showForm');
Route::post('/admin/user/edit', "AdminPagesController@updateUser")->name('admin.user.update');
Route::delete('/admin/user/delete/{method}/{user}', "AdminPagesController@deleteUser")->name('admin.user.delete');
Route::get('/admin/users/deleted', "AdminPagesController@deletedUsers")->name('admin.users.deleted');

Route::get('/admin/places', "AdminPagesController@allPlaces")->name('admin.places');
Route::get('/admin/place/add', "AdminPagesController@showAddPlaceForm")->name('admin.place.add.showForm');
Route::post('/admin/place/add', "AdminPagesController@createPlace")->name('admin.place.add');
Route::get('/admin/place/edit/{place}', "AdminPagesController@showEditPlaceForm")->name('admin.place.edit.showForm');
Route::post('/admin/place/edit', "AdminPagesController@updatePlace")->name('admin.place.update');
Route::get('/admin/places/deleted', "AdminPagesController@deletedPlaces")->name('admin.places.deleted');
Route::delete('/admin/place/delete/{method}/{place}', "AdminPagesController@deletePlace")->name('admin.place.delete');
