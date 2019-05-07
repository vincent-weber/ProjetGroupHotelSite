<?php


Route::post("/","HotelController@index");

Route::post("/connexion","ClientController@connexion");
Route::post("/inscription","ClientController@inscription");
Route::get("/deconnexion","ClientController@deconnexion");
Route::get("/mesreservations","ClientController@mesreservations");
Route::get("/verification/{reservation}/{hotel}/{type}","ClientController@verification");
Route::get("/confirmation/{reservation}","ClientController@confirmation");
Route::get("/annulation/{reservation}","ClientController@annulation");
Route::get("/moncompte","ClientController@monCompte");




Route::end();
