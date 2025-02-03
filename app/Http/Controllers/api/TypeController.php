<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Requests\TypeRequest;
use App\Http\Resources\Type as TypeResource;
use App\Http\Controllers\api\ResponseController;

class TypeController extends ResponseController {

    public function getTypes() {

        $types = Type::all();

        return $this->sendResponse( TypeResource::collection( $types ), "Típusok betöltve");
    }

    public function getType( Request $request ) {

        $type = Package::where( "type", $request[ "name" ] )->first();

        return $type;
    }

    public function newType( TypeRequest $request ) {

        $request->validated();

        $type = new Type();

        $type->type = $request[ "type" ];

        $type->save();

        return $this->sendResponse( new TypeResource( $type ), "Típus kiírva");
    }

    public function modifyType( TypeRequest $request ) {

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

            return $this->sendError( "Adathiba", [ "Típus nem létezik" ], 405 );

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
