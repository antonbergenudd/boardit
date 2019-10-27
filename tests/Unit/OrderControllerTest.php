<?php

namespace Tests\Unit;

use Tests\TestCase;
use boardit\User;
use boardit\Product;
use boardit\Order;
use boardit\Http\Controllers\OrderController;

use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index.
     *
     * @return void
     */
    public function testIndex() {
        $response = $this->get('/auth/orders');
        $response->assertStatus(302);

        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->get('/auth/orders');
        $response->assertStatus(200);
    }

    /**
     * Test status.
     *
     * @return void
     */
    public function testStatus() {
        $class = new OrderController;

        $order = factory(Order::class)->create(['status' => Order::CONFIRMED]);
        $this->assertEquals("true", $class->status($order));

        $order = factory(Order::class)->create(['status' => Order::PROCESSING]);
        $this->assertEquals("false", $class->status($order));
    }

    /**
     * Test set failed.
     *
     * @return void
     */
    public function testSetFailed() {
        $class = new OrderController;

        $order = factory(Order::class, 1)->create(['status' => Order::CONFIRMED])
             ->each(function($u) {
                 $u->getProducts()->save(factory(Product::class)->make());
             })->first();

        $class->setFailed($order);

        foreach($order->getProducts as $product) {
            $this->assertTrue($product->quantity > 0);
        }

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => Order::FAILED,
            'error' => 1
        ]);
    }
}
