<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JacobBennett\StripeTestToken;
use Stripe\Charge;

class StripeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test charge.
     *
     * @return void
     */
    public function testCharge() {
        StripeTestToken::setApiKey(env('STRIPE_TEST_KEY'));

        // Success card
        $charge = Charge::create([
                'amount' => 500,
                'currency' => 'sek',
                'source' => StripeTestToken::validVisa(),
        ]);

        // Failed charge (security code)
        try {
            Charge::create([
                    'amount' => 500,
                    'currency' => 'usd',
                    'source' => StripeTestToken::cvcFail(),
            ]);
        } catch (\Exception $e) {
                $this->assertTrue($e->getMessage() == "Your card's security code is incorrect.");
        }

        $this->assertTrue($charge->status == 'succeeded');
    }
}
