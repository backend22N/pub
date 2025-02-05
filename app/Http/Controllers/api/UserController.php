<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends ResponseController {

    public function register( UserRegisterRequest $request ) {

        $request->validated();

        $user = User::create([

            "name" => $request["name"],
            "email" => $request["email"],
            "password" => bcrypt( $request["password"]),
            "city_id" => ( new CityController )->getCityId( $request[ "city" ]),
            "admin" => $request[ "admin" ]
        ]);

        return $this->sendResponse( $user->name, "Sikeres regisztráció");
    }

    public function login( UserLoginRequest $request ) {

        $request->validated();

        if( Auth::attempt([ "name" => $request["name"], "password" => $request["password"]])) {

            $actualTime = Carbon::now();
            $authUser = Auth::user();
            $bannedTime = ( new BannerController )->getBannedTime( $authUser->name );
            ( new BannerController )->reSetLoginCounter( $authUser->name );

            if( $bannedTime < $actualTime ) {

                ( new BannerController )->resetBannedTime( $authUser->name );
                $token = $authUser->createToken( $authUser->name."Token" )->plainTextToken;
                $data["user"] = [ "user" => $authUser->name ];
                $data[ "time" ] = $bannedTime;
                $data["token"] = $token;

                return $this->sendResponse( $data, "Sikeres bejelentkezés");

            }else {

                return $this->sendError( "Autentikációs hiba", [ "Következő lehetőség: ", $bannedTime ], 401 );
            }
        }else {

            $loginCounter = ( new BannerController )->getLoginCounter( $request[ "name" ]);
            if( $loginCounter < 3 ) {

                ( new BannerController )->setLoginCounter( $request[ "name" ]);

            }else {

                ( new BannerController )->setBannedTime( $request[ "name" ]);
            }
            $error = ( new BannerController )->getBannedTime( $request[ "name" ]);
            $errorMessage = [ "time" => Carbon::now(), "hiba" => "Nem megfelelő felhasználónév vagy jelszó" ];
            return $this->sendError( $error, [$errorMessage], 401 );
        }
    }

    public function logout() {

        auth( "sanctum" )->user()->currentAccessToken()->delete();
        $name = auth( "sanctum" )->user()->name;

        return $this->sendResponse( $name, "Sikeres kijelentkezés");
    }



        public function getTokens() {

        $tokens = DB::table( "personal_access_tokens" )->get();

        return $tokens;
    }
}
