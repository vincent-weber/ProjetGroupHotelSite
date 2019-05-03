<?php


Route::post("/","HotelController@index");

Route::post("/connexion","ClientController@connexion");
Route::post("/inscription","ClientController@inscription");
Route::get("/deconnexion","ClientController@deconnexion");




Route::end();
