<?php

namespace Tests\Feature\Http\Controllers\Api\VideoController;

use App\Models\Video;
use Illuminate\Support\Arr;
use Tests\Traits\TestUpload;
use Tests\Traits\TestValidations;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\TestResponse;

class VideoControllerUploadTest extends BaseVideoControllerTestCase
{
    use TestValidations, TestUpload;

    public function testInvalidationVideoField()
    {
        $this->assertInvalidationFile(
            'video_file',
            'mp4',
            Video::VIDEO_FILE_MAX_SIZE,
            'mimetypes',
            ['values' => 'video/mp4']
        );
    }

    public function testInvalidationThumbField()
    {
        $this->assertInvalidationFile(
            'thumb_file',
            'jpg',
            Video::THUMB_FILE_MAX_SIZE,
            'image'
        );
    }

    public function testInvalidationBannerField()
    {
        $this->assertInvalidationFile(
            'banner_file',
            'jpg',
            Video::BANNER_FILE_MAX_SIZE,
            'image'
        );
    }

    public function testInvalidationTrailerField()
    {
        $this->assertInvalidationFile(
            'trailer_file',
            'mp4',
            Video::TRAILER_FILE_MAX_SIZE,
            'mimetypes',
            ['values' => 'video/mp4']
        );
    }

    public function testStoreWithFiles()
    {
        \Storage::fake();
        $files = $this->getFiles();

        $response = $this->json(
            'POST',
            $this->routeStore(),
            $this->sendData + $files
        );

        $response->assertStatus(201);
        $this->assertFilesOnPersist($response, $files);
        $video = Video::find($response->json('data.id'));
        $this->assertIfFilesUrlExists($video, $response);
    }

    // public function testUpdateWithFiles()
    // {
    //     \Storage::fake();
    //     $files = $this->getFiles();

    //     // $category = factory(Category::class)->create();
    //     // $genre = factory(Genre::class)->create();
    //     // $genre->categories()->sync($category->id);

    //     $response = $this->json(
    //         'PUT',
    //         $this->routeUpdate(),
    //         $this->sendData + $files
    //     );

    //     $response->assertStatus(200);
    //     $this->assertFilesOnPersist($response, $files);

    //     $newFiles = [
    //         'thumb_file' => UploadedFile::fake()->create('thumb_file.jpg'),
    //         'video_file' => UploadedFile::fake()->create('video_file.mp4')
    //     ];

    //     $response = $this->json(
    //         'PUT',
    //         $this->routeUpdate(),
    //         $this->sendData + $newFiles
    //     );

    //     $response->assertStatus(200);
    //     $this->assertFilesOnPersist($response, Arr::except($files, ['thumb_file', 'vide_file']) + $newFiles);

    //     $id = $response->json('id');
    //     $video = Video::find($id);
    //     \Storage::assertMissing($video->relativeFilePath($files['thumb_file']->hashName()));
    //     \Storage::assertMissing($video->relativeFilePath($files['video_file']->hashName()));
    //     // foreach($files as $file) {
    //     //     \Storage::assertExists("$id/{$file->hashName()}");
    //     // }
    // }

    public function getFiles()
    {
        return [
            'video_file' => UploadedFile::fake()->create('video_file.mp4'),
            'banner_file' => UploadedFile::fake()->create('banner_file.jpg'),
            'thumb_file' => UploadedFile::fake()->create('thumb_file.jpg'),
            'trailer_file' => UploadedFile::fake()->create('trailer_file.mp4'),
        ];
    }

    protected  function assertHasCategory($videoId, $categoryId)
    {
        $this->assertDatabaseHas('category_video', [
            "category_id" => $categoryId,
            "video_id" => $videoId
        ]);
    }

    protected  function assertHasGenre($videoId, $genreId)
    {
        $this->assertDatabaseHas('genre_video', [
            "genre_id" => $genreId,
            "video_id" => $videoId
        ]);
    }

    protected function assertFilesOnPersist(TestResponse $response, $files)
    {
        $id = $response->json('id') ?? $response->json('data.id');
        $video = Video::find($id);

        $this->assertFilesExistInStorage($video, $files);
    }

    protected function routeStore()
    {
        return route('videos.store');
    }

    protected function routeUpdate()
    {
        return route('videos.update', ['video' => $this->video->id]);
    }

    protected function model()
    {
        return Video::class;
    }
}
