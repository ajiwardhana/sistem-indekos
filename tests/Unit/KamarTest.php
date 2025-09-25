<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Kamar;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KamarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_kamar()
    {
        $kamar = Kamar::factory()->create([
            'nomor_kamar' => '101',
            'harga' => 1000000,
            'status' => 'tersedia',
            'fasilitas' => 'AC, TV',
        ]);

        $this->assertDatabaseHas('kamars', [
            'nomor_kamar' => '101',
        ]);
    }
}
