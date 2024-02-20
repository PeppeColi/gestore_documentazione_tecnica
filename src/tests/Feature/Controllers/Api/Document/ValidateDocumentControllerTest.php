<?php

declare(strict_types=1);

use App\Client;
use App\Document;
use App\Project;
use App\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ValidateDocumentControllerTest extends TestCase
{
    /** @var int */
    private const VALID_DOCUMENT_ID = 123;

    /** @var int */
    private const INVALID_DOCUMENT_ID = 321;

    /** @var User */
    private $user;

    /** @var Client  */
    private $client;

    /** @var Project */
    private $project;

    /** @var Document */
    private $document;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create([
            'name' => 'foo',
            'email' => 'foo@bar.com',
            'password' => Hash::make('foo'),
            'is_admin' => false,
        ]);

        $this->user->api_token = Str::random(80);

        $this->user->save();

        $this->client = $this->user->clients()->create(['name' => 'client1']);

        $this->client->save();

        $this->project = $this->client->projects()->create(['name' => 'project1']);

        $this->project->save();

        $this->document = $this->project->documents()->create([
            'name' => 'document1',
            'path' => 'http://localhost:8080/documents/placeholder.pdf',
            'approved' => null,
        ]);

        $this->document->id = self::VALID_DOCUMENT_ID;

        $this->document->save();
    }

    public function dataset(): array
    {
        return [
            [
                false, // is admin
                self::VALID_DOCUMENT_ID, // document id
                Response::HTTP_INTERNAL_SERVER_ERROR, // status code
                1, // value for 'approved'
                null, // db value for 'approved'
            ],
            [
                true,
                self::INVALID_DOCUMENT_ID,
                Response::HTTP_NOT_FOUND,
                1,
                null,
            ],
            [
                true,
                self::VALID_DOCUMENT_ID,
                Response::HTTP_OK,
                1,
                1,
            ],
            [
                true,
                self::VALID_DOCUMENT_ID,
                Response::HTTP_OK,
                0,
                0,
            ],

        ];
    }

    /**
     * @param bool $isAdmin
     * @param int $documentId
     * @param int $statusCode
     * @param int $approved
     * @param ?int $dbValue
     *
     * @dataProvider dataset
     *
     * @test
     *
     * @coversDefaultClass \App\Http\Controllers\Api\Document\ValidateDocumentController
     *
     * @return void
     */
    public function should_update_the_document(bool $isAdmin, int $documentId, int $statusCode, int $approved, ?int $dbValue)
    {
        $this->user->is_admin = $isAdmin;
        $this->user->save();

        /** @var TestResponse $response */
        $response = $this->withHeaders([
                             'Accept' => 'application/json',
                             'Authorization' => "Bearer {$this->user->api_token}" // @todo fix phpunit auth
                         ])
                         ->post(
                             route('api_validate_document', ['id' => $documentId]),
                             ['approved' => $approved]
                         );

        $response->assertStatus($statusCode);

        $this->assertDatabaseHas(
            (new Document())->getTable(),
            [
                'id' => self::VALID_DOCUMENT_ID,
                'name' => 'document1',
                'path' => 'http://localhost:8080/documents/placeholder.pdf',
                'approved' => $dbValue,
            ]
        );
    }
}
