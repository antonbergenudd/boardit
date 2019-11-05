<?php

namespace Tests\Unit;

use Tests\TestCase;

use Carbon\Carbon;

use Stripe\Customer;

use boardit\User;
use boardit\Order;
use boardit\Product;
use boardit\DiscountCode;

use Twilio\Rest\Client;

use boardit\Http\Requests\PaymentSubmitRequest;

use Gloudemans\Shoppingcart\Cart;

use boardit\Http\Controllers\PaymentController;
use Gloudemans\Shoppingcart\ShoppingcartServiceProvider;

use Illuminate\Http\Request;

use JacobBennett\StripeTestToken;

use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set the package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ShoppingcartServiceProvider::class];
    }

    /**
     * Get an instance of the cart.
     *
     * @return \Gloudemans\Shoppingcart\Cart
     */
    private function getCart()
    {
        $session = $this->app->make('session');
        $events = $this->app->make('events');
        return new Cart($session, $events);
    }

    // /**
    //  * Test index.
    //  *
    //  * @return void
    //  */
    // public function testIndex() {
    //     $response = $this->get('/payment/index');
    //     $response->assertStatus(200);
    // }
    //
    // /**
    //  * Test feedback.
    //  *
    //  * @return void
    //  */
    // public function testFeedback() {
    //     $response = $this->get('/payment/feedback');
    //     $response->assertStatus(200);
    // }

    // /**
    //  * Test check discount.
    //  *
    //  * @return void
    //  */
    // public function testCheckDiscount() {
    //     $code = factory(DiscountCode::class)->create(['amount' => 50]);
    //
    //     $class = new PaymentController;
    //     $this->assertEquals(50, $class->checkDiscount($code->code, 100));
    //     $this->assertEquals(100, $class->checkDiscount(null, 100));
    //     $this->assertEquals(null, $class->checkDiscount(100, null));
    // }

    // /**
    //  * Test control discount.
    //  *
    //  * @return void
    //  */
    // public function testControlDiscount() {
    //     $discount = factory(DiscountCode::class)->create(['amount' => 25]);
    //
    //     $class = new PaymentController;
    //
    //     $request = new Request;
    //
    //     $request->code = $discount->code;
    //     $this->assertEquals(25, $class->controlDiscount($request));
    //
    //     $request->code = '';
    //     $this->assertEquals(null, $class->controlDiscount($request));
    // }

    // /**
    //  * Test remove discount.
    //  *
    //  * @return void
    //  */
    // public function testRemoveDiscountCode() {
    //     $discount = factory(DiscountCode::class)->create();
    //     $class = new PaymentController;
    //
    //     $class->removeDiscountCode($discount->code);
    //
    //     $this->assertDatabaseMissing("discount_codes", ["id" => $discount->id]);
    // }

    // /**
    //  * Test check cart products stock.
    //  * TODO: test with Cart
    //  * @return void
    //  */
    // public function testCheckCartProductStock() {
    //     $class = new PaymentController;
    // }

    /**
     * Test payment submit.
     *
     * @return void
     */
    public function testSubmit() {
        // Setup delivering user
        $user = factory(User::class)->create([
            'delivering' => 1,
            'phone' => '+46708605003'
        ]);

        // Setup cart
        $cart = $this->getCart();
        $product_1 = factory(Product::class)->create(['quantity' => 1]);
        $product_2 = factory(Product::class)->create(['quantity' => 1]);
        $cart->add([$product_1, $product_2]);

        // Construct form request
        $request = new PaymentSubmitRequest;
        $request->city = 'lund';
        $request->payment_by_card = 1;
        $request->date = Carbon::now('Europe/Stockholm')->format('Y-m-d');
        $request->date_hour = Carbon::now('Europe/Stockholm')->addHours('1')->format('h');
        $request->date_minute = Carbon::now('Europe/Stockholm')->format('i');
        $request->email = "a@a.com";

        StripeTestToken::setApiKey(env('STRIPE_TEST_KEY'));
        $request->stripeToken = StripeTestToken::validVisa();

        // Perform test
        $class = new PaymentController;
        $class->submit($request);

        // Check that items has been added and updated
        $this->assertDatabaseHas("orders", ["email" => $request->email]);
        $this->assertDatabaseHas("products", ["id" => $product_1->id, "quantity" => ($product_1->quantity - 1)]);
        $this->assertDatabaseHas("products", ["id" => $product_2->id, "quantity" => ($product_2->quantity - 1)]);
        $this->assertDatabaseHas("product_order", ["product_id" => $product_1->id]);
        $this->assertDatabaseHas("product_order", ["product_id" => $product_2->id]);

        // Control sms delivered
        $client = new Client(env('TWILIO_ACCOUNT_SID_TEST'), env('TWILIO_AUTH_TOKEN_TEST'));
        dd($client->messages->read());
        $this->assertEquals("delivered", $client->messages->read(array(), 1)[0]->status);
        $this->assertEquals(true, strpos($client->messages->read(array(), 1)[0]->body, 'Snabbt ärende') !== false);
    }

    // /**
    //  * Test check discount.
    //  *
    //  * @return void
    //  */
    // public function testNotifyThroughSms() {
    //     $code = DiscountCode::where('code', $discount_code)->first();
    //     $code->delete();
    // }
    //
    // /**
    //  * Test check discount.
    //  *
    //  * @return void
    //  */
    // public function testSendSms() {
    //     $code = DiscountCode::where('code', $discount_code)->first();
    //     $code->delete();
    // }
}
