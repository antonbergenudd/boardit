<div class="product default" id="{{$product->id}}" style="max-width:30rem;">
    @if($product->thumbnail)
        <img class="product-default-img" src="{{ asset('img/games/'.$product->thumbnail) }}" alt="{{$product->name}}">
    @endif
    <h1 class="product-default-title">{{$product->name}} <span class="price">{{$product->price}} kr</span></h1>

    {{-- @if(boardit\User::where('delivering', 1)->count()) --}}
        @if($product->quantity)
            <div class="add_cart">

                <a class="link" href="{{route("product.view", ['product' => $product->id])}}">Läs mer</a>

                <p data-cart-item-not-added="{{$product->id}}" class="link @if(\Cart::content()->where('id', $product->id)->count()) hide @endif" data-cart-add="{{ $product->id }}">Lägg till i kundvagn</p>

                <p class="link @if(! \Cart::content()->where('id', $product->id)->count()) hide @endif" data-cart-item-added="{{$product->id}}" data-cart-remove="{{ $product->id }}">
                    Ta bort
                </p>

                <p class="hide" data-cart-item-out="{{$product->id}}">Tillfälligt slut</p>
            </div>
        @else
            <a class="link" href="{{route("product.view", ['product' => $product->id])}}">Läs mer</a>

            <p>Tillfälligt slut</p>
        @endif
    {{-- @else
        <a class="link" href="{{route("product.view", ['product' => $product->id])}}">Läs mer</a>

        <p>Levererar ej för tillfället</p>
    @endif --}}
</div>
