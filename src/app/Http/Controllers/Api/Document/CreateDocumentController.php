<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Document;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\CreateDocumentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CreateDocumentController extends Controller
{
    /**
     * @param CreateDocumentRequest $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function __invoke(CreateDocumentRequest $request): JsonResponse
    {
        // @todo check file type before storing it!

        // @todo check project id, client id, user etc

        /** @var string $path */
        $path = Storage::putFile('documents', $request->file('file'));

        if (!$path) {
            throw new \Exception();
        }

        // @todo fix public path, use env and config for public URIs, use a CDN etc

        /** @var string $publicPath */
        //$publicPath = Str::replaceFirst('storage/', 'http://localhost:8080/', $path);
        $publicPath = 'http://localhost:8080/documents/placeholder.pdf';

        Document::query()
                ->create([
                    'name' => $request->input('name'),
                    'path' => $publicPath,
                    'project_id' => $request->input('project_id'),
                ])->save();

        return response()->json();
    }
}
