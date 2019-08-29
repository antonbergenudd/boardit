<div class="cart-floating">
    <i class="material-icons">shopping_cart</i>
    <a class="cart-floating-close" href="{{ route('cart.destroy') }}">Töm</a>

    <hr style="opacity:.2;">

    <div class="cart-floating-items-wrapper">
        @foreach($cart as $item)
            <div class="" style="display:flex; width:14rem;">
                <h4 style="margin:0; flex:1;">{{ $item->name }}</h4>
                <p style="flex:1; margin:0; text-align:center;">{{ $item->price }} kr</p>
                <a href="{{ route('cart.remove', ['item' => $item->rowId])}}" style="flex:1; color:red; font-size:10pt; text-decoration:none; display: flex; align-items: center;justify-content: flex-end;">Ta bort</a>
            </div>

            <hr style="opacity:.2;">
        @endforeach
    </div>

    <h2>Summerat: {{ $cartTotal }} kr</h2>
    <a class="link" href="{{ route('payment.index') }}">Till betalning</a>
</div>
