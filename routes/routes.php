<?php


Route::post("/","HotelController@index");
Route::get("/hotel/{numh}","HotelController@hotel");
Route::get("/reserver/{numh}","HotelController@reserver");
Route::post("/reservation","HotelController@reservation");

Route::post("/connexion","ClientController@connexion");
Route::post("/inscription","ClientController@inscription");
Route::get("/deconnexion","ClientController@deconnexion");
Route::get("/mesreservations","ClientController@mesreservations");
Route::get("/verification/{reservation}/{hotel}/{type}","ClientController@verification");
Route::get("/confirmation/{reservation}","ClientController@confirmation");
Route::get("/annulation/{reservation}","ClientController@annulation");
Route::get("/services/{reservation}/{hotel}","ClientController@services");
Route::get("/ajoutService/{service}/{reservation}","ClientController@ajoutService");
Route::get("/moncompte","ClientController@monCompte");
Route::get("/editer","ClientController@editer");
Route::post("/modifierprofil","ClientController@modifierprofil");


Route::end();
