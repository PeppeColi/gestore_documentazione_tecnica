<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @todo improve form requests, i.e using standard fields for the model
 */
class UserController extends Controller
{
    /**
     * @throws \Exception
     */
    private function checkAdmin()
    {
        // @todo use a proper middleware for admins, or an abstract class, or a trait

        // @todo customize the exception handler

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->is_admin) {
            throw new \Exception();
        }
    }

    /**
     * @param CreateUserRequest $request
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        $this->checkAdmin();

        // @todo show proper errors in the UI

        /** @var bool $userExists */
        $userExists = User::query()
                          ->where('email', $request->post('newUser_email'))
                          ->exists();

        if ($userExists) {
            throw new \Exception();
        }

        $user = new User([
            'name' => $request->post('newUser_name'),
            'email' => $request->post('newUser_email'),
            'password' => Hash::make($request->post('newUser_password')),
            'is_admin' => (bool) $request->post('newUser_admin'),
        ]);

        $user->api_token = Str::random(80);

        $user->save();

        return response()->json([]);
    }

    /**
     * @param EditUserRequest $request
     *
     * @throws \Exception
     * @return JsonResponse
     */
    public function edit(EditUserRequest $request): JsonResponse
    {
        $this->checkAdmin();

        $user = User::query()
                    ->where('email', $request->post('editUser_email'));

        $user->update([
            'name' => $request->post('editUser_name'),
            'email' => $request->post('editUser_email'),
            'is_admin' => (bool) $request->post('editUser_admin'),
        ]);

        if ($request->post('editUser_password') !== '') {
            $user->update([
                'password' => bcrypt($request->post('editUser_password')),
            ]);
        }

        return response()->json([]);
    }

    /**
     * @param DeleteUserRequest $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(DeleteUserRequest $request): JsonResponse
    {
        $this->checkAdmin();

        User::query()
            ->where('name', $request->post('deleteUser_name'))
            ->where('email', $request->post('deleteUser_email'))
            ->delete();

        return response()->json([]);
    }
}
