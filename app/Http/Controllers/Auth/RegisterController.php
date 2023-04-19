<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Candidate;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'n_document' => 'required',
            'type_document_id' => 'required',
            'last_names' => 'required',
            'dates_birth' => 'required|date',
        ], [
            'name.required' => 'Porfavor ingrese nombres',
            'email.required' => 'Porfavor ingrese un correo',
            'email.unique' => 'El correo ya se encuentra registrado',
            'password.required' => 'La contraseña es requerida',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'n_document.required' => 'Numero de documento requerido',
            'type_document_id.required' => 'Tipo de documento requerido',
            'last_names.required' => 'Porfavor ingrese apellidos',
            'dates_birth.required' => 'Fecha de nacimiento requerido',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
         $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'n_document' => $data['n_document'],
            'type_document_id' => $data['type_document_id'],
            'last_names' => $data['last_names'],
            'dates_birth' => $data['dates_birth'],

        ]);
        Candidate::create([
            'n_document' => $data['n_document'],
            'type_document_id' => $data['type_document_id'],
            'names' => $data['name'],
            'last_names' => $data['last_names'],
            'dates_birth' => $data['dates_birth'],
            'email' => $data['email'],
            'user_id' => $user->id,
        ]);
        $user->assignRole('POSTULANTE');
        return $user;
    }
}
