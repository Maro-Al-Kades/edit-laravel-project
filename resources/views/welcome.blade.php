@extends('layout.client')

@section('content')
    <h1 style="color: white;font-size:18px">نظام المساهمين</h1>
    <div class="row"  style="width: 70%;margin-top:25px">
        <div class="col-md-6 col-12" style="background-color:rgb(40, 40, 40) ">
            <div class="d-flex flex-column align-items-center p-4">
                <h2 style="color: white;font-size:15px">تقديم جديد</h2>
                <a href="{{ route('apply') }}" class="btn btn-primary">رابط التقديم</a>
            </div>
        </div>
        <div class="col-md-6 col-12" style="background-color:rgb(76, 67, 67)  ">
            <div class="d-flex flex-column align-items-center p-4">
                <h2 style="color: white;font-size:15px">تتبع حالة التقديم</h2>
                <p style="color: white;font-size:15px">المرجو إدخال رقم الهاتف</p>
                <form action="{{ route('client.progress') }}" method="post">
                    @csrf
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control my-2">
                    @error('phone')
                        <div style="color: red;padding-top:2px">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-success">بحث</button>
                </form>
            </div>
        </div>
    </div>
@endsection
