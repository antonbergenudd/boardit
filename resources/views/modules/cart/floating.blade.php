<div class="cart-floating">
    <a class="cart-floating-close" href="{{ route('cart.destroy') }}">X</a>

    <h2 class="cart-floating-title">Cart </h2>

    <hr>

    <div class="cart-floating-items-wrapper">
        @foreach($cart as $row)
            <div class="" style="display:flex; width:14rem;">
                <h4 style="margin:0; flex:1;">{{ $row->name }}</h4>
                <p style="flex:1; margin:0;">{{ $row->price }} kr</p>
                <a href="{{ route('cart.remove', ['item' => $row->rowId])}}" style=" text-align: right;flex:1; color:red; font-size:10pt; text-decoration:none;">remove</a>
            </div>

            <hr>
        @endforeach
    </div>

    <h1>{{ $cartTotal }} kr</h1>
    <a class="link" href="{{ route('payment.index') }}">Go to payment</a>
</div>
