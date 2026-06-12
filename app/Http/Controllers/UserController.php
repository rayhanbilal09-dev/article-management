<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->search;

    $users = User::when($search, function ($query) use ($search) {

        $query->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");

    })->paginate(10);

    return view('users.index', compact('users'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('users.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('users.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
{
    return view('users.edit', compact('user'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
    ];

    if ($request->password) {
        $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return redirect()->route('users.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Hapus semua artikel milik user terlebih dahulu untuk menghindari constraint foreign key
        foreach ($user->articles as $article) {
            $article->delete();
        }

        $user->delete();

        return redirect()->route('users.index');
    }
}
