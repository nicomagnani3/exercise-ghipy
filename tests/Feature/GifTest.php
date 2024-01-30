<?php

namespace Tests\Feature;

use App\Http\Controllers\GifController;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;

class GifTest extends TestCase
{

    /* @var $GifApiController GifController */
    protected $GifApiController;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->GifApiController = app(GifController::class);
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }


    /**
     * A feature test store gif.
     */
    public function testGifStore(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $gifData = [
            'user_id' => $this->user->id,
        ];

        $response = $this->postJson('/api/gifs', $gifData);

        $response->assertStatus(422);

        $gifDataWithOutUser = [
            'alias'=>Str::random(10),
            'gif_id'=>Str::random(10),       

        ];
        $response = $this->postJson('/api/gifs', $gifDataWithOutUser);
        $response->assertStatus(422);

        $gifDataSave = [
            'user_id' => $this->user->id,
            'alias'=>Str::random(10),
            'gif_id'=>Str::random(10),       
        ];
        $response = $this->postJson('/api/gifs', $gifDataSave);
        $response->assertStatus(200);
    }

     /**
     * A feature test store gif.
     */
    public function testGifshow(): void
    {
        $gifData = [
            'limit' => rand(),
            'offset' =>  rand(),
        ];

        $response = $this->getJson('/api/gifs', $gifData);

        $response->assertStatus(422); 
        $gifData = Str::random(10);
        
        $response = $this->getJson("/api/gifs?query=$gifData");
        $response->assertStatus(200);
    }

    

    
}
