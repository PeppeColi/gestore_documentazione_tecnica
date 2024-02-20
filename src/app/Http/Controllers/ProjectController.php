<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Client;
use App\Project;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * @param int $clientId
     *
     * @return Application|Factory|View
     */
    public function index(int $clientId)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        // @todo failure = an exception, so the handler should be used

        /** @var Client $client */
        $client = Client::query()->where('user_id', $currentUser->id)->findOrFail($clientId);

        /** @var Collection $projects */
        $projects = $client->projects()->get();

        // @todo mixed content

        /** @var array $data */
        $data = [
            'user' => $currentUser->toArray(),
            'client' => $client->toArray(),
            'projects' => $projects,
        ];

        return view('projects', $data);
    }

    /**
     * @param int $projectId
     *
     * @return Application|Factory|View
     */
    public function show(int $projectId)
    {
        // @todo create a static helper to retrieve current user data

        /** @var User $currentUser */
        $currentUser = Auth::user();

        /** @var Project $project */
        $project = Project::query()->findOrFail($projectId);

        /** @var Client $client */
        $client = $project->client()->first();

        /** @var Collection $documents */
        $documents = $project->documents()->get();

        /** @var array $data */
        $data = [
            'user' => $currentUser->toArray(),
            'project' => $project->toArray(),
            'client' => $client->toArray(),
            'documents' => $documents,
        ];

        // @todo here we use a 1<->1 among controller methods and views

        return view('project', $data);
    }
}
