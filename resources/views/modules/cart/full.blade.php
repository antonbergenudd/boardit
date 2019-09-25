<div class="full-cart">
    <i class="material-icons header-icon">shopping_cart</i>

    <hr class="divider">
    <div class="full-cart-items">
        @foreach($cart as $product)
            <div class="full-cart-item" data-cart-item={{$product->id}}>
                <h2 class="full-cart-item-header">{{ $product->name }}</h2>
                <p class="full-cart-item-price"><span data-cart-item-price>{{ $product->price }}</span> kr</p>
                <p class="full-cart-item-remove" data-cart-remove="{{ $product->id }}">
                    Ta bort
                </p>
            </div>

            <hr>
        @endforeach

        @if($cartTotal > 0)
            @if(! \Cart::content()->where('id', 15)->count())
                <div class="full-cart-pickup-wrapper">
                    <a class="link full-cart-pickup" href="{{ route('cart.add', ['product' => 15]) }}">Lägg till upphämtning (30kr)</a>
                    {{-- <a class="link" href="{{ route('cart.add', ['product' => 16]) }}" style="flex:1;">Lägg till utkörning (30kr)</a> --}}
                </div>
            @endif
        @else
            <h4>Kundvagnen är tom</h4>
        @endif
    </div>

    <div class="full-cart-total">
        <p class="full-cart-total-subtitle">Leveransavgift: 30.00 kr</p>
        <h1 class="full-cart-total-title"><b>Totalt</b>: <span class="font-project" data-cart-total>{{ $cartTotal + 30 }}</span> kr</h1>
    </div>
</div>
