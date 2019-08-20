
<div style="position:relative; height:100%; position: relative; width:100%;">
    <h1>Kundvagn</h1>

    <hr style="margin:0;">
    <div class="" style="text-align:left; overflow:scroll; height:90%; position:relative;">
        @foreach($cart as $row)
            <div style="display:flex; align-items: center; padding:1rem;">
                <h2 style="margin:0; flex:1;">{{ $row->name }}</h2>
                <p style="flex:1; margin:0;">{{ $row->price }} kr</p>
                <a href="{{ route('cart.remove', ['item' => $row->rowId])}}" style=" text-align: right;flex:1; color:red; font-size:10pt; text-decoration:none;">Ta bort</a>
            </div>

            <hr>
        @endforeach

        <a class="link" href="{{ route('cart.add', ['product' => 15]) }}" style="flex:1;">Lägg till upphämtning (30kr)</a>
        {{-- <a class="link" href="{{ route('cart.add', ['product' => 16]) }}" style="flex:1;">Lägg till utkörning (30kr)</a> --}}
    </div>

    <div class="" style="width:100%; background-color:white;">
        <p style="margin:0;">Leveransavgift: 30.00 kr</p>
        <h1 style="margin:0;"><b>Totalt</b>: {{ $cartTotal + 30 }} kr</h1>
    </div>
</div>
