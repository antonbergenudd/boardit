@extends('layouts.default')

@section('content')
    <div class="block flex-center" style="flex-direction:column;">
        <h1>{{$product->name}}</h1>
        <h4>{{$product->price}}</h4>
        <p>Skatt och leverans ingår</p>

        <div class="" style="position:relative; display:flex; flex-direction:column;">
            <h3>Choose date</h3>
            <label for="">From</label>
            <input type="text" name="" value="" class="selector" id="from">
            <label for="">To</label>
            <input type="text" name="" value="" class="selector" id="to">
        </div>

        <h3>Kvantitet</h3>
        <input type="number" name="" value="1">

        <button type="button" name="button">Lägg till i varukorg</button>
        <p>{{$product->description}}</p>
    </div>

    <script type="text/javascript">
        $("#from").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        $("#to").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endsection
