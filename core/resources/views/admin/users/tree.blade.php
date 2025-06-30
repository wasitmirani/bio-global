@extends('admin.layouts.app')

@section('panel')
    <div class="card custom--card pb-100 overflow-scroll">
        <div class="tree" style="width: 5000px">
            <ul>
                <li>
                    {!!showSingleUserinTree($user)!!}
                    {!! renderUserTree($user->children) !!}
                </li>
            </ul>
        </div>
    </div>

    <div class="modal fade user-details-modal-area" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">@lang('User Details')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="user-details-modal">
                        <div class="user-details-header">
                            <div class="thumb"><img class="w-h-100-p tree_image" src="#" alt="*"></div>
                            <div class="content">
                                <a class="user-name tree_url tree_name" href=""></a>
                                <span class="user-status tree_status"></span>
                                {{-- <span class="user-status tree_plan"></span> --}}
                            </div>
                        </div>
                        <div class="user-details-body text-center">
                            <h6 class="my-3">@lang('Referred By'): <span class="tree_ref"></span></h6>


                        <table class="table table-bordered">
                            <tr>
                                <th>&nbsp;</th>
                                <th>@lang('Detail')</th>
                            </tr>

                            <tr>
                                <td>@lang('Current PV')</td>
                                <td><span class="cpv"></span></td>
                            </tr>
                            <tr>
                                <td>@lang('Group Points')</td>
                                <td><span class="gpv"></span></td>
                            </tr>

                            <tr>
                                <td>@lang('Group Count')</td>
                                <td><span class="guc"></span></td>
                            </tr>
                        </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        'use strict';
        (function($) {
            $('.showDetails').on('click', function() {
                var modal = $('#exampleModalCenter');
                $('.tree_name').text($(this).data('name'));
                $('.tree_url').attr({
                    "href": $(this).data('treeurl')
                });
                $('.tree_status').text($(this).data('status'));
                $('.tree_plan').text($(this).data('plan'));
                $('.tree_image').attr({
                    "src": $(this).data('image')
                });
                $('.user-details-header').removeClass('Paid');
                $('.user-details-header').removeClass('Free');
                $('.user-details-header').addClass($(this).data('status'));
                $('.tree_ref').text($(this).data('refby'));
                $('.lbv').text($(this).data('lbv'));
                $('.lbv').text($(this).data('lbv'));
                $('.lbv').text($(this).data('lbv'));
                $('.rbv').text($(this).data('rbv'));
                $('.lpaid').text($(this).data('lpaid'));
                $('.rpaid').text($(this).data('rpaid'));
                $('.lfree').text($(this).data('lfree'));
                $('.rfree').text($(this).data('rfree'));
                $('.cpv').text($(this).data('cpv'));
                $('.guc').text($(this).data('guc'));
                $('.gpv').text($(this).data('gpv'));
                $('#exampleModalCenter').modal('show');
            });
        })(jQuery)
    </script>
@endpush
@push('breadcrumb-plugins')
    <form class="form-inline bg--white float-right" action="{{ route('admin.users.other.tree.search') }}" method="GET">
        <div class="input-group flex-fill w-auto">
            <input class="form-control" name="username" type="text" placeholder="@lang('Search by username')">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
@endpush

@push('style')
    <link href="{{ asset('assets/global/css/tree.css') }}" rel="stylesheet">
@endpush
