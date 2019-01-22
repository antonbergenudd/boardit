@extends('layouts.default')
@section('content')
    <div class="flex-center about">
        <div class="flex-center about-wrapper">
            <div class="about-wrapper-text">
                <h1>Om mig</h1>
                <p>
                    Mitt namn är Anton Bergenudd och jag studerar på heltid på Karlstads universitet.
                    Utbildningen jag studerar till heter Civilingenjör datateknik och varar i 5 år, varav jag är inne på år 2.
                    På fritiden spenderar jag det mesta av min tid till mina projekt som till exempel denna sida.
                    Med entreprenörskap som intresse har jag valt att starta den här sidan för att bedriva min egna verksamhet och se hur långt jag kan ta det.
                    Har jobbat som webbutvecklare i snart 3 år med glödande passion för ämnet.
                </p>
            </div>
            <div class="flex-center about-wrapper-image">
                <img src="{{ asset('img/me.jpg') }}" alt="Anton Bergenudd">
            </div>
        </div>
    </div>
@stop
