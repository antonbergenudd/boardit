<div style="position:relative; height:100%; position: relative; width:100%;">
    <h1>Kundvagn</h1>

    <hr style="margin:0;">
    <div class="" style="text-align:left; overflow:scroll; height:75%; position:relative;">
        @foreach($cart as $row)
            <h1 style="padding:1rem; margin-bottom:0;">{{ $row->name }} <a href="{{ route('cart.remove', ['item' => $row->rowId])}}" style="float:right; color:red; font-size:10pt;">remove</a></h1>
            <div class="" style="display:flex; text-align:center;">
                <div class="" style="flex:1;">
                    <p style="flex:1;"><b>Pris</b></p>
                    <p style="flex:1;">{{ $row->price }} kr</p>
                </div>
                <div class="" style="flex:1;">
                    <p style="flex:1;"><b>Antal</b></p>
                    <p style="flex:1;">{{ $row->qty }} st</p>
                </div>
            </div>

            <hr>
        @endforeach
    </div>

    <div class="" style="width:100%; height:5rem; background-color:white;">
        <h1><b>Totalt</b>: {{ $cartTotal }} kr</h1>
    </div>
</div>
