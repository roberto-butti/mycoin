@extends('layouts.app')

@section('content')
<div class="container is-fluid">
    <h1>View {{ $instrument }}</h1>
<viewinstrument instrument="{{ $instrument }}" many="{{ $many }}"></viewinstrument>

    
</div>
@endsection