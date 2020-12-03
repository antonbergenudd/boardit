<div class="product default" id="{{$product->id}}">
    @if($product->thumbnail)
        <a href="{{route("product.view", ['product' => $product->id])}}">
            <img class="product-default-img" src="{{ asset('img/games/'.$product->thumbnail) }}" alt="{{$product->name}}">
        </a>
    @endif

    <div class="body">
        <h3 class="product-default-title">{{$product->name}}</h3>

    @if($product->quantity)
        <div style="display: flex; justify-content: space-between;">
            {{-- class="@if(\Cart::content()->where('id', $product->id)->count()) hide @endif" --}}
            <p style="margin:0; font-size:15pt;">{{ $product->price }} kr</p>
            <i class="material-icons link" style="font-size:20pt; line-height:15px" 
                data-cart-item-not-added="{{$product->id}}"
                data-cart-add="{{ $product->id }}">add</i> 
        </div>
    @else
        <p>Tillfälligt slut</p>
    @endif
    </div>
</div>
