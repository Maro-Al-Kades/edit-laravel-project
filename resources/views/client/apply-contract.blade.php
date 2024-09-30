@extends('layout.client')

@section('content')
    <form action="{{ route('apply-contract', ['client' => $client]) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="fullname" class="form-label">الاسم الرباعي</label>
            <input name="fullname" type="text" class="form-control" id="fullname" aria-describedby="fullnameHelp">
            {{-- <div id="fullnameHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
            <label for="identity" class="form-label">رقم الهوية الوطنية</label>
            <input name="identity" type="identity" class="form-control" id="identity" aria-describedby="identityHelp">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        {{-- <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">رقم الجوال</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div> --}}
        <div class="mb-3">
            <label for="iban" class="form-label">رقم الايبان</label>
            <input name="iban" type="text" class="form-control" id="iban" aria-describedby="ibanHelp">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
            <label for="bank" class="form-label">البنك</label>
            <input name="bank" type="text" class="form-control" id="bank" aria-describedby="bankHelp">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
            <label for="profession" class="form-label">المهنة</label>
            <input name="profession" type="text" class="form-control" id="profession" aria-describedby="professionHelp">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
            <label for="birth" class="form-label">تاريخ الميلاد</label>
            <input name="birth" type="date" class="form-control" id="birth" aria-describedby="birthHelp">
            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
        </div>
        <div class="mb-3">
            <label for="n_shares" class="form-label">عدد الأسهم</label>
            <select name="n_shares" class="form-select" aria-label="Default select example">
                <option selected>اختر عدد الأسهم</option>
                <option value="1">1</option>
                <option value="2">3</option>
                <option value="3">8</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">إنشاء عقد</button>
    </form>
@endsection
