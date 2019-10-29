<?php

namespace Tests\Unit;

use Tests\TestCase;
use boardit\User;
use boardit\Product;
use boardit\Order;
use boardit\Http\Controllers\OrderController;

use Twilio\Rest\Client;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    // /**
    //  * Test index.
    //  *
    //  * @return void
    //  */
    // public function testIndex() {
    //     $response = $this->get('/auth/orders');
    //     $response->assertStatus(302);
    //
    //     $user = factory(User::class)->create();
    //
    //     $this->actingAs($user);
    //
    //     $response = $this->get('/auth/orders');
    //     $response->assertStatus(200);
    // }
    //
    // /**
    //  * Test status.
    //  *
    //  * @return void
    //  */
    // public function testStatus() {
    //     $class = new OrderController;
    //
    //     $order = factory(Order::class)->create(['status' => Order::CONFIRMED]);
    //     $this->assertEquals("true", $class->status($order));
    //
    //     $order = factory(Order::class)->create(['status' => Order::PROCESSING]);
    //     $this->assertEquals("false", $class->status($order));
    // }
    //
    // // /**
    // //  * Test quantity.
    // //  *
    // //  * @return void
    // //  */
    // // public function testQuantity() {
    // //     // Cart test
    // // }
    //
    // /**
    //  * Test set failed.
    //  *
    //  * @return void
    //  */
    // public function testSetFailed() {
    //     $class = new OrderController;
    //
    //     $order = factory(Order::class, 1)->create(['status' => Order::CONFIRMED])
    //          ->each(function($u) {
    //              $u->getProducts()->save(factory(Product::class)->make());
    //          })->first();
    //
    //     $class->setFailed($order);
    //
    //     foreach($order->getProducts as $product) {
    //         $this->assertTrue($product->quantity > 0);
    //     }
    //
    //     $this->assertDatabaseHas('orders', [
    //         'id' => $order->id,
    //         'status' => Order::FAILED,
    //         'error' => 1
    //     ]);
    // }
    //
    // public function testNotifyOffline() {
    //     $accountSid = env('TWILIO_ACCOUNT_SID_TEST');
    //     $authToken = env('TWILIO_AUTH_TOKEN_TEST');
    //
    //     $client = new Client($accountSid, $authToken);
    //
    //     $class = new OrderController;
    //
    //     $order = factory(Order::class)->create([
    //         'deliverance_date' => Carbon::now('Europe/Stockholm')->addHours('2'),
    //     ]);
    //
    //     $class->notifyOffline($order);
    //
    //     $this->assertEquals("delivered", $client->messages->read(array(), 1)[0]->status);
    // }
    //
    // // TODO: How to test stripe in unit test
    // // public function testConfirm() {
    // //     $class = new OrderController;
    // //
    // //     $order = factory(Order::class)->create([
    // //         'deliverance_date' => Carbon::now('Europe/Stockholm')->addHours('2'),
    // //     ]);
    // //
    // //     $user = factory(User::class)->create();
    // //
    // //     $class->confirm($user, $order, false);
    // //
    // //     $this->assertEquals(Order::CONFIRMED || Order::CONFIRMED_AND_RESERVED, $order->status);
    // // }
    //
    // public function testReturn() {
    //     $class = new OrderController;
    //
    //     $user = factory(User::class)->create();
    //     $order = factory(Order::class, 1)->create(['status' => Order::CONFIRMED])
    //          ->each(function($u) {
    //              $u->getProducts()->save(factory(Product::class)->create(['quantity' => 0]));
    //          })->first();
    //
    //
    //     $class->return($user, $order);
    //
    //     $this->assertEquals(Order::RETURNED, $order->status);
    //     $this->assertEquals(0, $order->error);
    //     $this->assertEquals(1, $order->getProducts()->first()->quantity);
    // }
    //
    // public function testDeliver() {
    //     $class = new OrderController;
    //
    //     $user = factory(User::class)->create();
    //     $order = factory(Order::class, 1)->create()
    //          ->each(function($u) {
    //              $u->getProducts()->save(factory(Product::class)->create(['quantity' => 0]));
    //          })->first();
    //
    //     $class->deliver($user, $order);
    //
    //     $this->assertEquals(Order::DELIVERED, $order->status);
    //     $this->assertEquals(0, $order->error);
    //     $this->assertNotEquals(null, $order->delivered_at);
    // }

    // TODO: How to test twilio webhook
    // public function testReceiveSms() {
    //     $class = new OrderController;
    //
    //     $accountSid = env('TWILIO_ACCOUNT_SID_TEST');
    //     $authToken = env('TWILIO_AUTH_TOKEN_TEST');
    //
    //     $client = new Client($accountSid, $authToken);
    //
    //     $order = factory(Order::Class)->create();
    //     $user = factory(User::class)->create();
    //
    //     $client->messages->create(
    //         "+46708605003",
    //         array(
    //             'from' => "+16464612551",
    //             'body' => "En order har skapats!" .
    //                 "\r\nSnabbt ärende." .
    //                 "\r\nLevereras inom 2 timmar från svar." .
    //                 "\r\nReferenskod: " . $order->code .
    //                 "\r\nProdukter: " .
    //                 "\r\nAdress: " .
    //                 "\r\nSvara JA för att bekräfta order.",
    //         )
    //     );
    //
    //     $this->call('GET', '/sms/reply', ['Body' => 'ja']);
    //
    //     $message = $client->messages->read(array(), 1)[0];
    //
    //     $this->assertEquals("delivered", $client->messages->read(array(), 1)[0]->status);
    // }
}
