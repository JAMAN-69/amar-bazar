<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLogin()
    {
        // Ensure admin user Jaman exists with correct password on every visit
        $this->ensureAdminExists();

        if (Auth::check() || session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Ensure the admin user Jaman is seeded and has correct password.
     */
    private function ensureAdminExists()
    {
        $admin = User::where('name', 'Jaman')->orWhere('email', 'amdarbazar@gmail.com')->first();
        if (!$admin) {
            $admin = User::first();
        }

        if ($admin) {
            $admin->name = 'Jaman';
            $admin->email = 'amdarbazar@gmail.com';
            $admin->password = Hash::make('20117914');
            $admin->save();
        } else {
            User::create([
                'name' => 'Jaman',
                'email' => 'amdarbazar@gmail.com',
                'password' => Hash::make('20117914'),
            ]);
        }
    }

    /**
     * Handle the admin login submit.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string',
        ], [
            'email.required' => 'ইউজারনেম অথবা ইমেইল প্রদান করুন।',
            'password.required' => 'পাসওয়ার্ড প্রদান করুন।',
        ]);

        $this->ensureAdminExists();

        $loginInput = trim($request->input('email'));
        $password = trim($request->input('password'));

        // Look up by email or name/username (e.g. 'Jaman' or 'admin')
        $user = User::where('email', $loginInput)
            ->orWhere('name', $loginInput)
            ->first();

        // Case-insensitive username fallback (e.g. jaman, Jaman)
        if (!$user) {
            $user = User::whereRaw('LOWER(name) = ?', [strtolower($loginInput)])
                ->orWhereRaw('LOWER(email) = ?', [strtolower($loginInput)])
                ->first();
        }

        // Direct check for Jaman credentials
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            session(['admin_logged_in' => true]);
            $request->session()->regenerate();

            $intended = session()->pull('url.intended', route('admin.dashboard'));
            return redirect($intended)->with('success', 'স্বাগতম ' . $user->name . '! অ্যাডমিন ড্যাশবোর্ডে সফলভাবে প্রবেশ করেছেন।');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'ভুল ইউজারনেম/ইমেইল অথবা পাসওয়ার্ড! পুনরায় সঠিক তথ্য দিয়ে চেষ্টা করুন।');
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('admin_logged_in');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'অ্যাডমিন প্যানেল থেকে সফলভাবে লগআউট হয়েছে।');
    }
}
