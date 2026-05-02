<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
class LoginController extends Controller
{
    // Kredensial sementara untuk keperluan pengembangan front-end
    private array $users = [
        [
            'email'    => 'bubungchii27@gmail.com',
            'password' => '123123',
            'role'     => 'pasien',
            'redirect' => '/pasien/dashboard',
        ],
        [
            'email'    => 'feysiber26@gmail.com',
            'password' => '456456',
            'role'     => 'dokter',
            'redirect' => '/dokter/dashboard',
        ],
        [
            'email'    => 'acbdfehhs1@gmail.com',
            'password' => '789789',
            'role'     => 'admin',
            'redirect' => '/admin/dashboard',
        ],
    ];
 
    public function submit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);
 
        foreach ($this->users as $user) {
            if (
                $request->email === $user['email'] &&
                $request->password === $user['password']
            ) {
                // Simpan role di session untuk keperluan front-end
                session(['role' => $user['role'], 'email' => $user['email']]);
 
                return redirect($user['redirect']);
            }
        }
 
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['login' => 'Email atau kata sandi salah.']);
    }
}