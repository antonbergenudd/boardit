<?php

namespace Tests\Unit;

use Tests\TestCase;

class MainControllerTest extends TestCase
{
    /**
     * Test index.
     *
     * @return void
     */
    public function testIndex() {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test about.
     *
     * @return void
     */
    public function testAbout() {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }

    /**
     * Test faq.
     *
     * @return void
     */
    public function testFaq() {
        $response = $this->get('/faq');

        $response->assertStatus(200);
    }

    /**
     * Test policy.
     *
     * @return void
     */
    public function testPolicy() {
        $response = $this->get('/policy');

        $response->assertStatus(200);
    }

    /**
     * Test games.
     *
     * @return void
     */
    public function testGames() {
        $response = $this->get('/games');

        $response->assertStatus(200);
    }
}
