@extends('layout.client')

@section('content')
    <alert class="alert alert-warning">
        مرحبا
        {{ $client->name }}
        تم تقديم الطلب
    </alert>
@endsection
