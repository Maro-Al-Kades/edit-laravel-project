@extends('layout.client')

@section('content')
@if (Session::has('message'))
<div class="alert alert-success">{{ Session::get('message') }}</div>
@else
<form action="{{ route('apply') }}" method="post">
    @csrf
    {{-- اسم العميل --}}
    <div class="mb-3">
        <label for="name" class="form-label">اسم العميل</label>
        <input name="name" value="{{ old('name') }}" type="text" class="form-control" id="name"
            aria-describedby="nameHelp">
        @error('name')
        <div style="color: red; padding-top: 2px;">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">البريد الالكتروني</label>
        <input name="email" value="{{ old('email') }}" type="text" class="form-control" id="email"
            aria-describedby="emailHelp">
        @error('email')
        <div style="color: red; padding-top: 2px;">{{ $message }}</div>
        @enderror
    </div>

    {{-- رقم العميل --}}
    <div class="mb-3">
        <label for="phone" class="form-label">رقم العميل</label>
        <div class="d-flex">
            <input dir="ltr" name="phone" value="{{ old('phone') }}" type="text" class="form-control" id="phone"
                aria-describedby="phoneHelp">
            <style>
                #code-country {
                    width: 100px;
                }

                @media only screen and (max-width: 600px) {
                    #code-country {
                        width: 40vw;
                    }
                }
            </style>
            <div id="code-country" dir="ltr" class="flex-grow-1">
                <select class="form-select" name="code">
                    @foreach ($codes as $code)
                    <option value="{{ $code->name }}" @selected($code->name == old('code'))>{{ $code->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @error('phone')
        <div style="color: red; padding-top: 2px;">{{ $message }}</div>
        @enderror
    </div>

    {{-- عدد الأسهم --}}
    <div class="mb-3">
        <label for="n_shares" class="form-label">عدد الأسهم التي ترغب في شرائها</label>
        <input name="n_shares" value="{{ old('n_shares') }}" type="number" class="form-control" id="n_shares"
            aria-describedby="n_sharesHelp">
        @error('n_shares')
        <div style="color: red; padding-top: 2px;">{{ $message }}</div>
        @enderror
        <div id="n_sharesHelp" class="form-text" style="color: white;">سعر السهم 3 ريال</div>
        <div id="n_sharesHelp" class="form-text" style="color: white;">عدد الأسهم المطلوبة لا تقل عن 3350 سهم</div>
        <input class="form-control mt-2" id="n_shares_total" type="text" readonly placeholder="اجمالي قيمة الأسهم">
    </div>

    {{-- المنطقة --}}
    <div class="mb-3">
        <label for="area" class="form-label">المنطقة</label>
        <select id="area" name="area" class="form-select" aria-label="Default select example">
            <option value="" @selected(null==old('area'))>اختر المنطقة</option>
            @foreach ($areas as $area)
            <option value="{{ $area->id }}" @selected($area->id == old('area'))>{{ $area->name }}</option>
            @endforeach
        </select>
        @error('area')
        <div style="color: red; padding-top: 2px;">{{ $message }}</div>
        @enderror
    </div>

    {{-- المدينة --}}
    <div id="city-area" class="mb-3 @if (!old('city')) d-none @endif">
        <label for="city" class="form-label">المدينة</label>
        <select id="city" name="city" class="form-select" aria-label="Default select example">
            @if(old('city'))
            <option value="{{ old('city') }}">{{ old('city') }}</option>
            @endif
        </select>
        @error('city')
        <div style="color: red; padding-top: 2px;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">طلب تقديم</button>
</form>
@endif
@endsection

@section('scripts')
<script>
    $(function() {
            $('#n_shares').on('change', function() {
                var shares = $(this).val();
                var total = 0;
                if (shares < 3350) {
                    alert('عذراً, الاسهم المطلوبة لا تقل عن 3350 سهم لتكون شريك مساهم')
                    $('#n_shares_total').val('');
                } else {
                    total = shares * 3;
                    $('#n_shares_total').val(total + 'ريال ');
                }
            });

            $('#area').on('change', function() {
                $.ajax({
                    type: "GET",
                    url: '/cities/' + $(this).val(),
                    data: '',
                    success: function(html) {
                        $('#city-area').removeClass('d-none');
                        $('#city').html(html);
                    }
                });
            });
        });
</script>
@endsection
