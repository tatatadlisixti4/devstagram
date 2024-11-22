<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){
        // dd($request);
        // dd($request->get('username'));

        // Opción [1] de modificar el request para que funcione el unique con el slug
        //$request->request->add(['username' => Str::slug($request->username)]);

        // Validación
        $request->validate([
            'name' => 'required|max:30',
            // [1][2]hacen que se modifique con la linea de abajo 'username' => 'required|unique:users|min:3|max:20',
            'username' => 'required|min:3|max:20',
            'email' => 'required|email|unique:users|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        // Opción [2] modifica los registros para que el duplicado tenga un contador al final
        $originalSlug = Str::slug($request->username);
        $slug = $originalSlug;
        $counter = 1;
        while(User::where('username', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        User::create([
            'name' => $request->name,
            // [1] 'username' => $request->username,
            'username' => $slug, // [2]
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Redireccionar al usuario
        return redirect()->route('post.index');

    }
}
