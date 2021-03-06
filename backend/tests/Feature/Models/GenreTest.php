<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Genre::class, 1)->create();
        $genres = Genre::all();
        $this->assertCount(1, $genres);
        $genresKeys = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genresKeys
        );
    }
    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test'
        ]);
        $genre->refresh();
        $this->assertEquals(36, strlen($genre->id));
        $this->assertEquals('test', $genre->name);
        $this->assertTrue((bool)$genre->is_active);

        $genre = Genre::create([
            'name' => 'test',
            'is_active' => false
        ]);
        $this->assertFalse((bool)$genre->is_active);

        $genre = Genre::create([
            'name' => 'test',
            'is_active' => true
        ]);
        $this->assertTrue((bool)$genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'name' => 'test_name',
            'is_active' => false
        ]);

        $data = [
            'name' => 'test_name',
            'is_active' => true
        ];
        $genre->update($data);

        foreach($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();
        $genre->delete();

        $genre->restore();
        $this->assertNotNull(Genre::find($genre->id));
    }
}
