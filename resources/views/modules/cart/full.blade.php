
<div style="position:relative; height:100%; position: relative; width:100%;">
    <h1>Kundvagn</h1>

    <hr style="margin:0;">
    <div class="" style="text-align:left; overflow:scroll; height:80%; position:relative;">
        @foreach($cart as $row)
            <div style="display:flex; align-items: center; padding:1rem;">
                <h2 style="margin:0; flex:1;">{{ $row->name }}</h2>
                <p style="flex:1; margin:0;">{{ $row->price }} kr</p>
                <a href="{{ route('cart.remove', ['item' => $row->rowId])}}" style=" text-align: right;flex:1; color:red; font-size:10pt; text-decoration:none;">remove</a>
            </div>

            <hr>
        @endforeach
    </div>

    <div class="" style="width:100%; background-color:white;">
        <h1><b>Totalt</b>: {{ $cartTotal }} kr</h1>
    </div>
</div>
