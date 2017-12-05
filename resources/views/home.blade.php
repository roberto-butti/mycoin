@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns is- is-marginless">
        <div class="column is-4">
            <lasttickerlist currency="{{ $currency }}" ></lasttickerlist>
            
        </div>
        <div class="column is-4">
            <formcalc currency="{{ $currency }}" currentvalue="{{ $lastticker->last }}"></formcalc>
        </div>
       

    </div>
    @include('block.chart')
</div>
@endsection
