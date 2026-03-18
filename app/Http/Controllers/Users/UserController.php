<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\Users\User;
use App\Models\Rol\Roles;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index()
    {
        // Validación manual
        if (Gate::denies('gestionar-usuarios')) {
            return redirect()->route('registros.index')
                ->with('error', 'No tienes permisos para acceder');
        }

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
        $users = $query->paginate(8)->withQueryString();

        return view('users.index', compact('users', 'filter'));
    }

    public function restore($id)
    {
        if (Gate::denies('gestionar-usuarios')) {
            return redirect()->route('registros.index')
                ->with('error', 'No tienes permisos para acceder');
        }

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
        // Validación manual
        if (Gate::denies('gestionar-usuarios')) {
            return redirect()->route('registros.index')
                ->with('error', 'No tienes permisos para acceder');
        }
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
        if (Gate::denies('gestionar-usuarios')) {
            return redirect()->route('registros.index')
                ->with('error', 'No tienes permisos para acceder');
        }
        //
        $request->validate([
            'name' => 'required|string|max:50|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|string|max:50|regex:/^[\pL\s]+$/u',
            'phone_number' => 'required|digits_between:7,15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed|regex:/[A-Z]/|regex:/[!@#$%^&*()_\-+=.]/', // Al menos una letra mayúscula y un carácter especial
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
        if (Gate::denies('gestionar-usuarios')) {
            return redirect()->route('registros.index')
                ->with('error', 'No tienes permisos para acceder');
        }

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

        if (Gate::denies('gestionar-usuarios')) {
            return redirect()->route('registros.index')
                ->with('error', 'No tienes permisos para acceder');
        }
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:50|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|string|max:50|regex:/^[\pL\s]+$/u',
            'phone_number' => 'required|digits_between:7,15',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')
            ],

            'roles_id' => 'required|exists:roles,id',

            'password' => [
                'sometimes',
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[!@#$%^&*()_\-+=.]/'
            ],
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Usuario ' . $user->name . ' actualizado correctamente');
    }

    public function destroy(User $user)
    {
        if (Gate::denies('gestionar-usuarios')) {
            return redirect()->route('registros.index')
                ->with('error', 'No tienes permisos para acceder');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario ' . $user->name . ' ' . $user->last_name . ' inhabilitado correctamente');
    }
}
