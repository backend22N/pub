<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Requests\TypeRequest;
use App\Http\Resources\Type as TypeResource;
use App\Http\Controllers\api\ResponseController;
use Illuminate\Support\Facades\Gate;

class TypeController extends ResponseController {

    public function getTypes() {

        $types = Type::all();

        return $this->sendResponse( TypeResource::collection( $types ), "Típusok betöltve");
    }

    public function getType( Request $request ) {

        $type = Type::where( "type", $request[ "type" ] )->first();

        if( is_null( $type )) {

            return $this->sendError( "Hibás adat", [ "Nincs ilyen típus" ], 406 );
        }

        return $this->sendResponse( $type, "Típus betöltve" );
    }

    public function newType( TypeRequest $request ) {

        Gate::before( function(){

            $user = auth( "sanctum" )->user();
            if( $user->admin == 2 ){

                return true;
            }
        });
        if ( !Gate::allows( "admin" )) {

            return $this->sendError( "Autentikációs hiba", "Nincs jogosultság", 401 );
        }

        $request->validated();

        $type = new Type();

        $type->type = $request[ "type" ];

        $type->save();

        return $this->sendResponse( new TypeResource( $type ), "Típus kiírva");
    }

    public function modifyType( TypeRequest $request ) {

        Gate::before( function(){

            $user = auth( "sanctum" )->user();
            if( $user->admin == 2 ){

                return true;
            }
        });
        if ( !Gate::allows( "admin" )) {

            return $this->sendError( "Autentikációs hiba", "Nincs jogosultság", 401 );
        }

        $request->validated();

        $type = Type::find( $request[ "id" ] );
        if( is_null( $type )) {

            return $this->sendError( "Adathiba", [ "A Nincs Ilyen típus" ], 406 );

        }

        $type->type = $request[ "type" ];

        $type->update();

        return $this->sendResponse( new TypeResource( $type ), "Típus módosítva");
    }

    public function destroyType( Request $request ) {

        $type = Type::find( $request[ "id" ]);

        if( is_null( $type )) {

            return $this->sendError( "Adathiba", [ "Típus nem létezik" ], 406 );

        }

        $type->delete();

        return $this->sendResponse( new TypeResource( $type ), "Típus törölve" );
    }

    public function getTypeId( $typeName ) {

        $type = Type::where( "type", $typeName )->first();

        $id = $type->id;

        return $id;
    }
}
