<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Document;

use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\ValidateDocumentRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ValidateDocumentController extends Controller
{
    /**
     * @param ValidateDocumentRequest $request
     * @param int $id
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function __invoke(ValidateDocumentRequest $request, int $id): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->is_admin) {
            throw new \Exception();
        }

        Document::query()
                ->findOrFail($id)
                ->update(['approved' => $request->input('approved')]);

        return response()->json();
    }
}
