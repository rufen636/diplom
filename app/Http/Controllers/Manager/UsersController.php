<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller
{
    /**
     * Отобразить список пользователей
     */
    public function index(Request $request): Response
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Manager/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Показать форму создания пользователя
     */
    public function create(): Response
    {
        return Inertia::render('Manager/Users/Create');
    }

    /**
     * Сохранить нового пользователя
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('manager.users.index')
            ->with('success', 'Пользователь успешно создан.');
    }

    /**
     * Показать форму редактирования пользователя
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Manager/Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Обновить пользователя
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()->route('manager.users.index')
            ->with('success', 'Пользователь успешно обновлен.');
    }

    /**
     * Удалить пользователя
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('manager.users.index')
            ->with('success', 'Пользователь успешно удален.');
    }
}

