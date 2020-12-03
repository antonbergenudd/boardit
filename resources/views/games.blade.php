@extends('layouts.default')

@section('content')
<div class="games">
    <div class="games-categories">
        <div class="games-categories-header">
            <h1 class="games-categories-header-title">Kategorier</h1>
        </div>
        
        <div class="games-categories-body">
            <ul class="category-list">
                <a class="category-item link" style="display: block;" href="{{ route('games')  }}">Alla</a>
                @foreach($categories as $category)
                <a class="category-item link" style="display: block;" href="{{ route('games', ['category' => $category->id])  }}">{{ $category->name }}</a>
                @endforeach
            </ul>
        </div>
    </div>

    <div style="flex:4">
        <div style="margin-top:2rem; display:flex; padding:2rem; border-bottom: 1px solid rgba(0, 0, 0, 0.2)">
            <form action="{{ route('games') }}" method="get" style="display: flex; justify-content:space-between; width:40rem;">
                <div style="display: flex; flex-direction:column; text-align:left;">
                    <span>Name</span>
                    <input type="text" name="name" />
                </div>

                <div style="display: flex; flex-direction:column; text-align:left;">
                    <span>Price</span>
                    <div>
                        0 <input id="priceRange" type="range" min="0" max="100" value="0" name="price"/> 100
                        <span id="priceRangeVal"></span>
                    </div>
                </div>
                
                <input class="button-link" type="submit" value="Filter">
            </form>
        </div>

        <div class="games-wrapper">
            @foreach($products as $product)
                @include('product.default')
            @endforeach
        </div>
    </div>

    {{-- @if(isset($cart) && $cart->first())
        @include('modules.cart.floating')
    @endif --}}

    @include('modules.cart.floating')

    <script>
        $(document).ready(() => {
            $("#priceRange").on("input", () => {
                $("#priceRangeVal").text($("#priceRange").val())
            })
        })
    </script>
</div>
@stop
