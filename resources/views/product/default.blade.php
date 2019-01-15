<div class="product" id="{{$product->id}}" style="width:calc(25% - 2rem); margin:1rem; height:20rem; min-width:20rem;">
    @if($product->thumbnail)
        <img style="max-height: 60%; max-width:100%;" src="{{ asset('img/games/'.$product->thumbnail) }}" alt="{{$product->name}}">
    @endif
    <h1 style="margin-bottom:0; margin-top:.5rem;">{{$product->name}} <span style="font-weight:400;">{{$product->price}} kr</span></h1>
    <p>{{$product->description}}</p>
    <p></p>

    @if($product->in_store)
        @if(! \Cart::content()->where('id', $product->id)->count())
            <div class="add_cart">
                <a class="link" href="{{ route('cart.add', ['product' => $product->id]) }}">Add to cart</a>
            </div>
        @else
            <p>Product added to cart</p>
        @endif
    @else
        <p>Product not in store</p>
    @endif
</div>
