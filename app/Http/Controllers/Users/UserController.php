<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\Users\User;
use App\Models\Rol\Roles;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos el filtro de la URL, por defecto "todo"
        $filter = request()->query('filter', 'activos');

        // Creamos la query base
        $query = User::with('roles');

        // Aplicamos el filtro
        if ($filter === 'activos') {
            $query->whereNull('deleted_at'); // solo activos
        } elseif ($filter === 'inactivos') {
            $query->onlyTrashed(); // solo inactivos
        } else {
            $query->withTrashed(); // todo
        }

        // Ejecutamos la consulta con paginación
        $users = $query->paginate(5)->withQueryString();

        return view('users.index', compact('users', 'filter'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')
            ->with('success', 'Usuario ' . $user->name . ' restaurado correctamente');
    }

    /**
     * Show the form for creating a new resource. when it is viewed.
     */
    public function create()
    {
        //
        $roles = Roles::all();
        $user = new User();
        return view('users.create', compact('roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'roles_id' => 'required|integer|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles_id' => $request->roles_id
        ]);


        return redirect()->route('users.index')
            ->with('success', 'Usuario ' . $request->name . ' ' . $request->last_name . ' creado correctamente');
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
    public function edit(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $roles = Roles::all();

        if ($user->trashed()) {
            return redirect()->route('users.index')
                ->with('error', 'No se puede editar un usuario inactivo');
        }
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->except('password');

        $user->update($data);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuario ' . $user->name . ' ' . $user->last_name . ' actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario ' . $user->name . ' ' . $user->last_name . ' inhabilitado correctamente');
    }
}
