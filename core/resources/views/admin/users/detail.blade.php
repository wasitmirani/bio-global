@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ showAmount($user->balance) }}" title="Balance" style="7" link="{{ route('admin.report.transaction', $user->id) }}" icon="las la-money-bill-wave-alt" bg="indigo" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ showAmount($totalDeposit) }}" title="Deposits" style="7" link="{{ route('admin.deposit.list', $user->id) }}" icon="las la-wallet" bg="8" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ showAmount($totalWithdrawals) }}" title="Withdrawals" style="7" link="{{ route('admin.withdraw.data.all', $user->id) }}" icon="la la-bank" bg="6" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ $totalTransaction }}" title="Transactions" style="7" link="{{ route('admin.report.transaction', $user->id) }}" icon="las la-exchange-alt" bg="17" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ showAmount($user->total_invest) }}" title="Total Invest" style="7" link="{{ route('admin.report.invest', $user->id) }}" icon="la la-money" bg="17" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ showAmount($user->total_ref_com) }}" title="Total Referral Commission" style="7" link="{{ route('admin.report.referral.commission', $user->id) }}" icon="la la-user" bg="2" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ showAmount($user->team_sale_amount) }}" title="Total Commission" style="7" link="{{ route('admin.report.binary.commission', $user->id) }}" icon="la la-tree" bg="3" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ getAmount($user->bv_points) }}" title="Total PV" style="7" link="{{ route('admin.report.bvLog', $user->id) }}?type=cutBV" icon="la la-cut" bg="4" />
                </div>
                {{-- <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ getAmount($user->userExtra->bv_left) }}" title="Left PV" style="7" link="{{ route('admin.report.bvLog', $user->id) }}?type=leftBV" icon="las la-arrow-alt-circle-left" bg="1" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ getAmount($user->userExtra->bv_right) }}" title="Right PV" style="7" link="{{ route('admin.report.bvLog', $user->id) }}?type=rightBV" icon="las la-arrow-alt-circle-right" bg="13" />
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ getAmount($user->userExtra->bv_left + $user->userExtra->bv_right) }}" title="Total PV" style="7" link="{{ route('admin.report.bvLog', $user->id) }}" icon="las la-arrow-alt-circle-right" bg="14" />
                </div> --}}
                <div class="col-xxl-3 col-sm-6">
                    <x-widget type="2" value="{{ $totalOrder }}" title="Total Orders" style="7"
                        link="{{ route('admin.order.index', $user->id) }}" icon="las la-question-circle"
                        bg="16" />
                </div>
            </div>

            <div class="d-flex mt-4 flex-wrap gap-3">
                <div class="flex-fill">
                    <button class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-bs-toggle="modal" data-bs-target="#addSubModal" data-act="add">
                        <i class="las la-plus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <button class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-bs-toggle="modal" data-bs-target="#addSubModal" data-act="sub">
                        <i class="las la-minus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <a class="btn btn--primary btn--shadow w-100 btn-lg" href="{{ route('admin.report.login.history') }}?search={{ $user->username }}">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a class="btn btn--secondary btn--shadow w-100 btn-lg" href="{{ route('admin.users.notification.log', $user->id) }}">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                @if ($user->kyc_data)
                    <div class="flex-fill">
                        <a class="btn btn--dark btn--shadow w-100 btn-lg" href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank">
                            <i class="las la-user-check"></i>@lang('KYC Data')
                        </a>
                    </div>
                @endif

                <div class="flex-fill">
                    @if ($user->status == Status::USER_ACTIVE)
                        <button class="btn btn--warning btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal" type="button">
                            <i class="las la-ban"></i>@lang('Ban User')
                        </button>
                    @else
                        <button class="btn btn--success btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal" type="button">
                            <i class="las la-undo"></i>@lang('Unban User')
                        </button>
                    @endif
                </div>

                <div class="flex-fill">
                    <a class="btn btn--primary btn--shadow btn-block w-100 btn-lg" href="{{ route('admin.users.other.tree', $user->username) }}">
                        @lang('User Tree')
                    </a>
                </div>
                <div class="flex-fill">
                    <a class="btn btn--info btn--shadow btn-block btn-lg w-100" href="{{ route('admin.users.referral', $user->id) }}">
                        @lang('User Referrals')
                    </a>
                </div>
            </div>


            <div class="row">
                <div class="col-12 col-md-5 col-xxl-4">
                    <div class="card mt-30">
                        <div class="card-body p-0">
                            <div class="bg--white p-3">
                                <div class="profile-info-top">
                                    <div class="profile-image">
                                        <img id="output"
                                            src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, null, true) }}"
                                            alt="image">
                                    </div>

                                    <div class="plan-info">
                                        <p class="plan-info-name">
                                            <span>@lang('Current plan')</span>
                                            @if($user->plan->name ?? false)
                                            <strong class="text--success">{{__($user->plan->name)}}</strong>
                                            @else
                                            <strong class="text-danger">@lang('N/A')</strong>
                                            @endif
                                        </p>

                                    </div>
                                </div>
                                <ul class="list-group mt-3">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('Name')</span> {{ __($user->fullname) }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Username')</span> {{ $user->username }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Email')</span> {{ $user->email }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Mobile Number')</span> {{ $user->dial_code }}{{ $user->mobile }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Ref By')</span> <a href="{{ route('admin.users.detail', @$user->refBy->id) }}">{{'@'.@$user->refBy->username ?? 'N/A' }}</a>
                                    </li>
                                    {{-- <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Paid Left User ')</span> {{ $user->userExtra->paid_left }}
                                    </li> --}}
                                    {{-- <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Paid Right User ')</span>{{ $user->userExtra->paid_right }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Free Left User')</span>{{ $user->userExtra->free_left }}
                                    </li>
                                    <li class="list-group-item rounded-0 d-flex justify-content-between">
                                        <span>@lang('Free Right User')</span>{{ $user->userExtra->free_right }}
                                    </li> --}}

                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('Joined at')</span> {{ showDateTime($user->created_at) }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7 col-xxl-8">
                    <div class="card mt-30">
                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('First Name')</label>
                                            <input class="form-control" name="firstname" type="text"
                                                value="{{ $user->firstname }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">@lang('Last Name')</label>
                                            <input class="form-control" name="lastname" type="text"
                                                value="{{ $user->lastname }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Email') </label>
                                            <input class="form-control" name="email" type="email"
                                                value="{{ $user->email }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Mobile Number') </label>
                                            <div class="input-group">
                                                <span class="input-group-text mobile-code">+{{ $user->dial_code }}</span>
                                                <input class="form-control checkUser" id="mobile" name="mobile"
                                                    type="number" value="{{ $user->mobile }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('Address')</label>
                                            <input class="form-control" name="address" type="text"
                                                value="{{ @$user->address }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('City')</label>
                                            <input class="form-control" name="city" type="text"
                                                value="{{ @$user->city }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('State')</label>
                                            <input class="form-control" name="state" type="text"
                                                value="{{ @$user->state }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('Zip/Postal')</label>
                                            <input class="form-control" name="zip" type="text"
                                                value="{{ @$user->zip }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xl-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('Country') <span class="text--danger">*</span></label>
                                            <select class="form-control select2" name="country">
                                                @foreach ($countries as $key => $country)
                                                    <option data-mobile_code="{{ $country->dial_code }}"
                                                        value="{{ $key }}" @selected($user->country_code == $key)>
                                                        {{ __($country->country) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('Email Verification')</label>
                                            <input name="ev" data-width="100%" data-onstyle="-success"
                                                data-offstyle="-danger" data-bs-toggle="toggle"
                                                data-on="@lang('Verified')" data-off="@lang('Unverified')"
                                                type="checkbox" @if ($user->ev) checked @endif>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('Mobile Verification')</label>
                                            <input name="sv" data-width="100%" data-onstyle="-success"
                                                data-offstyle="-danger" data-bs-toggle="toggle"
                                                data-on="@lang('Verified')" data-off="@lang('Unverified')"
                                                type="checkbox" @if ($user->sv) checked @endif>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('2FA Verification') </label>
                                            <input name="ts" data-width="100%" data-height="50"
                                                data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                                data-on="@lang('Enable')" data-off="@lang('Disable')"
                                                type="checkbox" @if ($user->ts) checked @endif>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xxl-3">
                                        <div class="form-group">
                                            <label>@lang('KYC') </label>
                                            <input name="kv" data-width="100%" data-height="50"
                                                data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                                data-on="@lang('Verified')" data-off="@lang('Unverified')"
                                                type="checkbox" @if ($user->kv == Status::KYC_VERIFIED) checked @endif>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" name="firstname" type="text" value="{{ $user->firstname }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" name="lastname" type="text" value="{{ $user->lastname }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" name="email" type="email" value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code">+{{ $user->dial_code }}</span>
                                        <input class="form-control checkUser" id="mobile" name="mobile" type="number" value="{{ $user->mobile }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" name="address" type="text" value="{{ @$user->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" name="city" type="text" value="{{ @$user->city }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" name="state" type="text" value="{{ @$user->state }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" name="zip" type="text" value="{{ @$user->zip }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country') <span class="text--danger">*</span></label>
                                    <select class="form-control select2" name="country">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}" @selected($user->country_code == $key)>{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Email Verification')</label>
                                    <input name="ev" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" type="checkbox" @if ($user->ev) checked @endif>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label>@lang('Mobile Verification')</label>
                                    <input name="sv" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" type="checkbox" @if ($user->sv) checked @endif>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <div class="form-group">
                                    <label>@lang('2FA Verification') </label>
                                    <input name="ts" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($user->ts) checked @endif>
                                </div>
                            </div>
                            <div class="col-xl-3 col-12">
                                <div class="form-group">
                                    <label>@lang('KYC') </label>
                                    <input name="kv" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" type="checkbox" @if ($user->kv == Status::KYC_VERIFIED) checked @endif>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}


        </div>
    </div>

    {{-- Add Sub Balance MODAL --}}
    <div class="modal fade" id="addSubModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form class="balanceAddSub disableSubmission" action="{{ route('admin.users.add.sub.balance', $user->id) }}" method="POST">
                    @csrf
                    <input name="act" type="hidden">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input class="form-control" name="amount" type="number" step="any" placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __(gs('cur_text')) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" name="remark" placeholder="@lang('Remark')" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userStatusModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($user->status == Status::USER_ACTIVE)
                            @lang('Ban User')
                        @else
                            @lang('Unban User')
                        @endif
                    </h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == Status::USER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $user->ban_reason }}</p>
                            <h4 class="mt-3 text-center">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($user->status == Status::USER_ACTIVE)
                            <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                        @else
                            <button class="btn btn--dark" data-bs-dismiss="modal" type="button">@lang('No')</button>
                            <button class="btn btn--primary" type="submit">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.users.login', $user->id) }}" target="_blank"><i class="las la-sign-in-alt"></i>@lang('Login as User')</a>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"


            $('.bal-btn').on('click', function() {

                $('.balanceAddSub')[0].reset();

                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');
            $('select[name=country]').on('change', function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

        })(jQuery);
    </script>
@endpush


@push('style')
    <style>
        .profile-info-top {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 16px;
        }

        .profile-image {
            flex-shrink: 0;
        }

        .plan-info {
            flex: 1;
        }

        .plan-info-name {
            display: flex;
            flex-direction: column;
            gap: 6px;
            line-height: 1.3;
            font-size: 20px;
        }

        .plan-info-name span {
            font-size: 24px;
        }

        .profile-image img {
            height: 100px;
            width: 100px;
            border-radius: 50%;
            border: 6px solid #00000010;
        }
        .plan-info{
            background: #fafafa;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
@endpush
