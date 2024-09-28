<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'account_type' => ['required', 'string', 'max:255'],
            'occupation' => ['required', 'string', 'max:255'],
            'experience' => ['required', 'numeric', 'min:0'],
            'avatar' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'occupation' => $request->occupation,
            'experience' => $request->experience,
            'avatar' => $avatarPath,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->account_type == 'employee') {
            $user->assignRole('employee');
        } elseif ($request->account_type == 'employer') {
            $user->assignRole('employer');
        } else {
            $user->assignRole('super_admin');
        }
        // dd($request->account_type);

        event(new Registered($user));

        Auth::login($user);
        // dd($request);

        return redirect(route('dashboard', absolute: false));
    }
}
