<div class="cart-floating" data-cart>
    <h4 class="cart-floating-title">Varukorg</h4>
    <p class="cart-floating-close" data-cart-empty>Töm</p>

    <hr style="opacity:.2;">

    {{-- JS fix --}}
    <div class="hide" data-cart-item-placeholder>
        <div class="" style="display:flex; width:17rem;">
            <img style="margin-right: 0.5rem; width:50px;" src="" alt="">
            <h4 style="margin:0; flex:2; align-items: center; justify-content: center; display: flex;"></h4>
            <p data-cart-item-price style="flex:1; margin:0; text-align:center; align-items: center; justify-content: flex-end; display: flex;"></p>
            <p data-cart-remove="" style="flex:1; color:rgb(236, 102, 102); font-size:10pt; text-decoration:none; display: flex; align-items: center;justify-content: flex-end;">
                <i class="material-icons" style="font-size:15pt; line-height:15px">close</i> 
            </p>
        </div>

        <hr style="opacity:.2;">
    </div>
    {{--  --}}

    <div class="cart-floating-items-wrapper" data-cart-items>
        @foreach($cart as $item)
            <div class="" style="display:flex; width:17rem;">
                <img style="margin-right: 0.5rem; height:50px;" src="{{ asset('img/games/'.$item->model->thumbnail) }}" alt="{{$item->model->name}}">
                <h4 style="margin:0; flex:2; align-items: center; justify-content: center; display: flex;">{{ $item->name }}</h4>
                <p style="flex:1; margin:0; text-align:center; align-items: center; justify-content: flex-end; display: flex;" data-cart-item-price>{{ $item->price }} kr</p>
                <p data-cart-remove="{{$item->rowId}}" style="flex:1; color:rgb(236, 102, 102); font-size:10pt; text-decoration:none; display: flex; align-items: center;justify-content: flex-end;">
                    <i class="material-icons" style="font-size:15pt; line-height:15px; cursor: pointer;">close</i> 
                </p>
            </div>

            <hr style="opacity:.2;">
        @endforeach
    </div>

    <h4 style="margin-top:0;">Summerat: <span data-cart-total>{{ $cartTotal }}</span> kr</h4>
    <a class="button-link button" href="{{ route('payment.index') }}">Visa varukorgen</a>
</div>
