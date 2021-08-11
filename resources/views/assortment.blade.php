@extends('layouts.default')

@section('content')
    <style media="screen">
        .collapsible {
        background-color: #777;
        color: white;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        }

        .active, .collapsible:hover {
        background-color: #555;
        }

        .content {
        padding: 0 18px;
        display: none;
        overflow: hidden;
        background-color: #f1f1f1;
        }
    </style>

    <style media="screen">
    .fa-arrow-down{
  transform: rotate(0deg);
  transition: transform 0.2s linear;
}

.fa-arrow-down.open{
  transform: rotate(180deg);
  transition: transform 0.2s linear;
}

.product {
    margin:1rem;
}

.products > .product:nth-child(1), .product:nth-child(2), .product:nth-child(3) {margin-top: 0}
    </style>

    <div class="block" style="margin:0 10rem; width:auto;">
        <h1 style="text-align:center; margin: 10rem 0; text-decoration:underline;">Sortiment</h1>
        <div class="" style="display:flex;">
            <div class="" style="width:30rem;">
                <div class="collapsible" style="display:flex; justify-content:space-between; width:auto;">
                    Pris
                    <i class="fa fa-arrow-down"></i>
                </div>
                <div class="content" style="height:5rem;">
                    <p>
                      <label for="amount">Pris range:</label>
                      <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    </p>

                    <div id="slider-range"></div>
                </div>
                <div class="collapsible" style="display:flex; justify-content:space-between; width:auto;">
                    Antal spelare
                    <i class="fa fa-arrow-down"></i>
                </div>
                <div class="content">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div class="collapsible" style="display:flex; justify-content:space-between; width:auto;">
                    Kategorier
                    <i class="fa fa-arrow-down"></i>
                </div>
                <div class="content">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div class="collapsible" style="display:flex; justify-content:space-between; width:auto;">
                    Svårighetsgrad
                    <i class="fa fa-arrow-down"></i>
                </div>
                <div class="content">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
            </div>
            <div class="products" style="width:100%; display:flex; flex-wrap:wrap; justify-content:space-between;">
                @foreach($products as $product)
                    <div class="product assortment flex-center" style="width:14rem; height:14rem; flex-direction:column; position:relative;">
                        <h3>{{$product->name}} - {{$product->price}} kr</h3>
                        <a class="product__CTA flex-center" href="{{ route('product', ['product' => $product->id]) }}">
                            <p><i class="fa fa-shopping-cart"></i> Lägg till</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script type="text/javascript">
    var coll = document.getElementsByClassName("collapsible");
    var i;
    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            var arrow = $(this).find(".fa-arrow-down");
            if(!$(arrow).hasClass('open')) {
                $(arrow).addClass("open");
            } else {
                $(arrow).removeClass("open");
            }

            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
              content.style.display = "none";
            } else {
              content.style.display = "block";
            }
        });
    }
    </script>

    <script type="text/javascript">
    $( function() {
        $( "#slider-range" ).slider({
          range: true,
          min: 0,
          step: 25,
          max: 500,
          values: [ 75, 300 ],
          slide: function( event, ui ) {
            $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
          }
        });
        $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) + " - " + $( "#slider-range" ).slider( "values", 1 ) );
    } );
    </script>
@endsection
