<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\EditClientRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * @param CreateClientRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateClientRequest $request): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $currentUser->clients()
                    ->create(['name' => $request->post('name')]);

        return response()->json();
    }

    /**
     * @param EditClientRequest $request
     *
     * @return JsonResponse
     */
    public function edit(EditClientRequest $request): JsonResponse
    {
        Client::query()
              ->find($request->post('id'))
              ->update(['name' => $request->post('name')]);

        return response()->json();
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(int $id): JsonResponse
    {
        Client::query()
              ->find($id)
              ->delete();

        return response()->json();
    }
}
