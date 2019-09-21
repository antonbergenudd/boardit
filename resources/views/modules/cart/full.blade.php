<div class="full-cart">
    <i class="material-icons header-icon">shopping_cart</i>

    <hr class="divider">
    <div class="full-cart-items">
        @foreach($cart as $row)
            <div class="full-cart-item">
                <h2 class="full-cart-item-header">{{ $row->name }}</h2>
                <p class="full-cart-item-price">{{ $row->price }} kr</p>
                <a class="full-cart-item-remove" href="{{ route('cart.remove.rowid', ['rowId' => $row->rowId])}}">Ta bort</a>
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
        <h1 class="full-cart-total-title"><b>Totalt</b>: <span class="font-project">{{ $cartTotal + 30 }}</span> kr</h1>
    </div>
</div>
