<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProjectRequest;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * @param CreateProjectRequest $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(CreateProjectRequest $request): JsonResponse
    {
        /** @var Client $client */
        $client = Client::query()->find($request->input('client_id'));

        if (!$client) {
            throw new \Exception();
        }

        $client->projects()->create(['name' => $request->input('name')]);

        return response()->json();
    }
}
