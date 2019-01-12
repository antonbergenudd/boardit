<div class="cart" style="border-radius: 5%; box-shadow:-2px 2px 8px rgba(0,0,0,.3); position:fixed; right: 1rem; top: 4rem; background-color:white; padding:1rem;">
    <a href="{{ route('cart.destroy') }}" style="position:absolute; top:1.3rem; right:1rem; text-decoration: none; color:red;">X</a>

    <h2 style="margin:0;">Cart </h2>

    <hr>

    <div class="" style="text-align:left;">
        @foreach($cart as $row)
            <div class="">
                <h4 style="margin:0;">{{ $row->name }} <a href="{{ route('cart.remove', ['item' => $row->rowId])}}" style="float:right; color:red; font-size:10pt; text-decoration:none;">remove</a></h4>
                <div class="" style="display:flex; width:14rem;">
                    <p style="flex:1;">{{ $row->price }} kr</p>
                    <p style="flex:1;">{{ $row->qty }} st</p>
                    <p style="flex:1;">{{ $row->subtotal }} kr</p>
                </div>
            </div>

            <hr>
        @endforeach
    </div>

    <h1>{{ $cartTotal }} kr</h1>
    <a class="link" href="{{ route('payment.index') }}">Go to payment</a>
</div>
