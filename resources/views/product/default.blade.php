<div class="product default" id="{{$product->id}}">
    @if($product->thumbnail)
        <img class="product-default-img" src="{{ asset('img/games/'.$product->thumbnail) }}" alt="{{$product->name}}">
    @endif
    <h1 class="product-default-title">{{$product->name}} <span class="price">{{$product->price}} kr</span></h1>
    <p>{{$product->description}}</p>

    @if(boardit\User::where('delivering', 1)->count())
        @if($product->quantity)
            @if(! \Cart::content()->where('id', $product->id)->count())
                <div class="add_cart">
                    <a class="link" href="{{ route('cart.add', ['product' => $product->id]) }}">Lägg till i korg</a>
                </div>
            @else
                <p>Produkt tillagd i korgen</p>
            @endif
        @else
            <p>Ej på lager</p>
        @endif
    @else
        <p>Levererar ej för tillfället</p>
    @endif
</div>
