<?php
class HotelController{

	public function index() {

		$hotels = Hotel::findAll();
		return view("welcomePage",["hotels"=> $hotels]);
	}

}