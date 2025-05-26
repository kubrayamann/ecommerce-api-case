<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DiscountController;

/** Görev 1 - Siparişler
 ** Siparişler için Ekleme / Silme / Listeleme işlemlerinin gerçekleştirilebileceği bir RESTful API servisleri
 */
Route::get('/orders', [OrderController::class, 'list']);
Route::post('/orders', [OrderController::class, 'create']);
Route::delete('/orders/{id}', [OrderController::class, 'delete']);



/** Görev 2 - İndirimler
 ** Verilen siparişler için indirimleri hesaplayan küçük bir RESTful API servisi
 */
Route::get('/discounts/{id}', [DiscountController::class, 'calculateDiscounts']);


