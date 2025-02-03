<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller {

    public function addCity( Request $request) {

        $city = new City();
        $city->city = $request[ "city" ];

        $city->save();
    }

    public function getCity( $id ) {

        $city = City::find( $id );

        return $city;
    }

    public function getCityId( $cityName ) {

        $city = City::where( "city", $cityName )->first();
        $id = $city->id;

        return $id;
    }
}
