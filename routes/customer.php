<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

Route::group(['prefix'=>'customer','middleware'=>'usermiddleware'],function(){


Route::get('home',[UserController::class,'home'])->name('customer#home');
Route::get('product/details/{id}',[UserController::class,'productDetails'])->name('customer#productDetails');
Route::post('comment',[UserController::class,'comment'])->name('customer#comment');
Route::get('comment/delete/{id}',[UserController::class,'commentDelete'])->name('customer#commentDelete');
Route::post('rating',[UserController::class,'payrate'])->name('customer#Rating');

Route::get('cart',[UserController::class,'cart'])->name('customer#Cart');
Route::post('addtoCart',[UserController::class,'addtocart'])->name('customer#addtoCart');
Route::get('cartdelete',[UserController::class,'cartDelete'])->name('customer#CartDelete');
Route::get('paymentPage',[UserController::class,'paymentPage'])->name('customer#paymentPage');
Route::get('tempStorage',[UserController::class,'tempStorage'])->name('customer#tempStorage');
Route::post('order',[UserController::class,'order'])->name('customer#order');
Route::get('orderList',[UserController::class,'orderList'])->name('customer#orderList');

Route::group(['prefix'=>'contact'],function(){
    Route::get('contactAdmin',[ProfileController::class,'contact'])->name('contact#admin');
    Route::post('contactreport',[ProfileController::class,'report'])->name('contact#adminreport');

});



Route::group(['prefix'=>'profile'],function(){
    Route::get('profileEdit',[ProfileController::class,'edit'])->name('profile#customeredit');
    Route::post('profileUpdate',[ProfileController::class,'update'])->name('profile#customerupdate');
    Route::get('profilePassword',[ProfileController::class,'change'])->name('profile#customerPassword');
    Route::post('profilePasswordUpdate',[ProfileController::class,'passwordupdate'])->name('profile#passwordupdate');
});

});
