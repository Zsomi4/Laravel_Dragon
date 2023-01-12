<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Validator;

class AuthController extends BaseController {

    public function signIn(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $authUser = Auth::user();
            $success["token"] = $authUser->createToken["MyToken"]->plainTextToken;
            $success["name"] = $authUser->name;

            return $this->sendResponse($success, "Sikeres bejelentkezés!");
    } else {
        // return $this->sendError(["Unauthorized!"], ["error" => "Hibás adatok!"]);
        print_r("Unauthorized!");
    }
}
    public function signUp(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'name' =>'required',
            'email' =>'required',
            'password' =>'required',
            'confirm_password' =>'required|same:password',
        ]);

        if($validator->fails()) {
            // return sendError('Error validator!', $validator->errors());
            print_r("Error validator!");
        }

        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        $success["name"] = $user->name;

        // return $this->sendResponse($success, "Sikeres regisztráció!");
        print_r("Sikeres regisztráció!");
    }
}