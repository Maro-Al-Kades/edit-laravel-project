@extends('layout.client')

@section('content')
    <alert class="alert alert-success">
        تهانينا تم التعاقد
    </alert>
    <p>{{ $client->name }}</p>
@endsection
