<?php

namespace Tests\Unit;

use Tests\TestCase;

class TranslationTest extends TestCase
{
    /**
     * A basic unit test.
     *
     * @return void
     */
    public function testTranslation()
    {
        $response = $this->postJson("/api/translate", ["text" => "Translation", "language" => "am"]);
        $response->dump();
        $response->assertJsonStructure(["success", "translation"]);
        $response->assertStatus(200)
            ->assertJson(["success" => true]);
    }

    /**
     * Validation Test
     *
     * @return void
     */
    public function testValidation(){
        $errorResponse = $this->postJson("/api/translate", ["text" => "testText", "language" => "asdf"]);
        $errorResponse->assertJsonStructure(["success", "error"]);
        $errorResponse->assertStatus(400)->assertJson(["success" => false]);
    }
}
