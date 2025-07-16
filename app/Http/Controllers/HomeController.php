<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        // return view('home');
         $blogs = Blog::with('user')->latest()->paginate(8);
        return view('home', compact('blogs'));
    }

    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            $data = User::withCount('blogs');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('users.edit', $row->id) . '" class="edit btn btn-primary btn-sm mr-2">Edit</a>';
                    $btn .= '<a onclick="deleteConfirm(' . $row->id . ')" class="edit btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.list');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => ['nullable', 'min:8', 'regex:/^[a-zA-Z0-9]+$/'],
            'mobile' => 'required|digits:10',
            'dob'  => 'required|date',
            'gender' => 'required|in:male,female,other',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->mobile = $request->mobile;
        $user->dob = $request->dob;
        $user->gender = $request->gender;

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('profiles');
        }

        $user->save();

        return redirect()->route('users.data')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function doLogin(Request $r)
    {
        $validated = $r->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ], [
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters'
        ]);

        if (Auth::attempt($validated)) {
            $r->session()->regenerate();

            if (Auth::user()->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is inactive. Please contact administrator.'
                ]);
            }

            return redirect()->intended('/user');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function doRegister(Request $r)
    {
        $r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'min:8', 'regex:/^[a-zA-Z0-9]+$/'],
            'mobile' => 'required|digits:10',
            'dob'  => 'required|date',
            'gender' => 'required|in:male,female,other',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $path = $r->file('profile_image')
            ? $r->file('profile_image')->store('profiles')
            : null;

        $user = User::create([
            'name'          => $r->name,
            'email'         => $r->email,
            'password'      => Hash::make($r->password),
            'mobile'        => $r->mobile,
            'dob'           => $r->dob,
            'gender'        => $r->gender,
            'profile_image' => $path,
        ]);

        // Optional: check status
        // if ($user->status !== 'active') {
        //     return redirect()->route('login')
        //         ->with('msg', 'Account registered but inactive – contact admin.');
        // }

        Auth::login($user);
        return redirect('/user');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect('/');
    }
}
