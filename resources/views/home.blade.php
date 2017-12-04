@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is- is-marginless">
            <div class="column is-4">
                @foreach ($tickers as $t)
                    <p>{{ $t->fund_id }}: {{ $t->last }} on {{ $t->date }} </p>
                @endforeach
            </div>
            <div class="column is-4">
                <formcalc currency="{{ $currency }}"></formcalc>
            </div>

        </div>
        
    </div>
@endsection
