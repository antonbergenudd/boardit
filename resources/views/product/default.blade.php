<div class="product default" id="{{$product->id}}">
    @if($product->thumbnail)
        <img class="product-default-img" src="{{ asset('img/games/'.$product->thumbnail) }}" alt="{{$product->name}}">
    @endif
    <h1 class="product-default-title">{{$product->name}} <span class="price">{{$product->price}} kr</span></h1>
    <p>{{$product->description}}</p>

    @if(boardit\User::where('delivering', 1)->count())
        @if($product->quantity)
            <div class="add_cart">

                <p data-cart-item-not-added="{{$product->id}}" class="link @if(\Cart::content()->where('id', $product->id)->count()) hide @endif" data-cart-add="{{ $product->id }}">Lägg till i kundvagn</p>

                <div data-cart-item-added="{{$product->id}}" class="@if(! \Cart::content()->where('id', $product->id)->count()) hide @endif">
                    <p>Produkt redan tillagd i kundvagn</p>

                    <p class="link" data-cart-remove="{{ $product->id }}" style="margin:0;">
                        Ta bort
                    </p>
                </div>
            </div>
        @else
            <p>Tillfälligt slut</p>
        @endif
    @else
        <p>Levererar ej för tillfället</p>
    @endif
</div>
