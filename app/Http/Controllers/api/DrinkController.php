<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;
use App\Http\Requests\DrinkRequest;
use App\Http\Requests\DrinkModRequest;
use App\Http\Resources\Drink as DrinkResource;

class DrinkController extends ResponseController {

    public function getDrinks() {

        $drinks = Drink::with( "package", "type" )->get();

        return $this->sendResponse( DrinkResource::collection( $drinks ), "Sikeres olvasás");
    }

    public function getOneDrink( Request $request ) {


        $drink = Drink::where( "drink", $request["drink"] )->first();

        if( !$drink ){

            return $this->sendError( "Adathiba", "Nincs ilyen ital" );
        }

        return $this->sendResponse( new DrinkResource( $drink ), "Sikeres olvasás");
    }

    public function getAmount( Request $request ) {

        $drinks = Drink::where( "amount", $request["amount"] )->get();

        return $this->sendResponse( $drinks, "Rendelni kell.");
    }

    public function addDrink( DrinkRequest $request ) {

        $drink = new Drink;
        $drink->drink = $request["drink"];
        $drink->amount = $request["amount"];
        $drink->type_id = ( new TypeController )->getTypeId( $request[ "type" ]);
        $drink->package_id = ( new PackageController )->getPackageId( $request[ "package" ]);

        $drink->save();

        return $this->sendResponse( $drink, "Sikeres felírás" );
    }

    public function modifyDrink( DrinkModRequest $request  ) {

        $request->validated();
        $drink = Drink::find( $request[ "id" ]);

        if( is_null( $drink )) {

            $this->sendError( "Adathiba", [ "Nincs ilyen ital" ] );

        }

        $drink->drink = $request[ "drink" ];
        $drink->amount = $request[ "amount" ];
        $drink->type_id = ( new TypeController )->getTypeId( $request[ "type" ]);
        $drink->package_id = ( new PackageController )->getPackageId( $request[ "package" ]);

        $drink->update();

        return $this->sendResponse( $drink, "Sikeres módosítás" );
    }

    public function destroy( Request $request ) {

        $drink = Drink::find( $request[ "id" ] );
        $drink->delete();

        return $this->sendResponse( $drink, "Sikeres törlés" );
    }
}
