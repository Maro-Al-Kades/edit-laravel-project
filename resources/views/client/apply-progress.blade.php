@extends('layout.client')

@section('content')
    <alert class="alert alert-warning">
        مرحبا
        {{ $client->name }}
        طلبك قيد المتابعة
    </alert>
@endsection
