<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function regUser(Request $request){

        $data = $request->validate([
            'name' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'passConf' => 'required|same:password'
        ],
        [
            'name.required' => "Ime je obavezno",
            'lastName.required' => "Prezime je obavezno ",
            'email.required' => 'Email je obavezan',
            'email.email' => 'Unesite ispravan format email adrese.',
            'password.required' => 'Lozinka je obavezna',
            'password.min' => 'Lozinka mora imati minimalno 5 znakova ',
            'passConf.required' => 'Potvrda lozinke je obavezna',
            'passConf.same' => 'Vasa lozinka i potvrda vase lozinke nisu iste!'
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['passConf'] = Hash::make($data['passConf']);
        $user = new User();
        $user->create($data);

        return response()->json(['poruka' => 'Uspjesna registracija']);
    }
}
