<?php

declare(strict_types=1);

use App\Client;
use App\Document;
use App\Http\Controllers\Api\Document\CreateDocumentController;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Project;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateDocumentControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * @test
     *
     * @return void
     * @throws Exception
     */
    public function should_store_the_document()
    {
        /** @var User $user */
        $user = User::query()->create([
            'name' => 'foo',
            'email' => 'foo@bar.com',
            'password' => Hash::make('foo'),
            'is_admin' => false,
        ]);

        $user->save();

        /** @var Client $client */
        $client = $user->clients()->create(['name' => 'client1']);

        $client->save();

        /** @var Project $project */
        $project = $client->projects()->create(['name' => 'project1']);

        $project->save();

        Storage::fake();
        Storage::shouldReceive('putFile')->andReturnTrue();
        Storage::shouldReceive('disk');

        $mockRequest = CreateDocumentRequest::create('', '', [
            'name' => 'document1',
            'project_id' => $project->id,
            'file' => UploadedFile::fake()->create('document.pdf'),
        ]);

        (new CreateDocumentController())->__invoke($mockRequest);

        $this->assertDatabaseHas(
            (new Document())->getTable(),
            [
                'name' => 'document1',
                'path' => 'http://localhost:8080/documents/placeholder.pdf',
                'project_id' => $project->id,
                'approved' => null,
            ]
        );
    }
}
