@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="card custom--card">
            <div class="card-body">
                <form action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <x-viser-form identifier="act" identifierValue="kyc" />
                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
