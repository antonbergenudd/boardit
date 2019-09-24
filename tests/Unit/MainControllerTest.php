<?php

namespace Tests\Unit;

use Tests\TestCase;
use boardit\Order;
use boardit\ProductOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MainControllerTest extends TestCase
{
    use RefreshDatabase;

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
     * AUTH
     * Test orders.
     *
     * @return void
     */
    public function testOrders() {
        $response = $this->get('/auth/orders');

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

    /**
     * Test confirm order.
     *
     * @return void
     */
    public function testConfirmOrder() {

        $order = factory(Order::class)->create();

        $order->confirmed = 1;

        $order->save();

        $this->assertDatabaseHas('orders', [
            'confirmed' => '1',
            'id' => $order->id
        ]);

        // Assert twilio sms works

        // assert email works

        // assert redirect if redirect true

        // public function confirmOrder(User $user, Order $order, $redirect = true) {
        //     $order->confirmed = 1;
        //     $order->user_id = $user->id;
        //     $order->save();
        //
        //     try {
        //         $this->notifyThroughSms($order);
        //     } catch (TwilioException $e) {
        //         echo  $e;
        //     }
        //
        //     $this->email($order);
        //
        //     if($redirect) {
        //         return back();
        //     }
        // }
    }

    /**
     * Test return order.
     *
     * @return void
     */
    public function testReturnOrder() {
        $order = factory(Order::class)->create();

        $relationship = factory(ProductOrder::class)->create($order->id);

        $relationship->product->quantity++;
        $relationship->product->save();

        $order->returned = 1;
        $order->save();

        $this->assertDatabaseHas('orders', [
            'returned' => '1',
            'id' => $order->id
        ]);
    }
}
