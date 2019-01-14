<h1>Order {{$order->code}} bekräftad</h1>
<h3>OBS. Detta fungerar inte som ett kvitto. Kvitto ska finnas på din mail.</h3>

<h4>Leverans Address</h4>
<p>{{$order->address}}</p>

<h2>Förväntad leverans tid innan {{ Carbon\Carbon::now('Europe/Stockholm')->addHours(1)->format('Y-m-d H:i')}}</h2>
<p>Din order blev bekräftad {{ Carbon\Carbon::now('Europe/Stockholm')->format('Y-m-d H:i')}}.</p>

<p>Tack för att ni handlade hos Boardit!</p>
<p>Mvh,<br>Anton Bergenudd CEO Boardit</p>
