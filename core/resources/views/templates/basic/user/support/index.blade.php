@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="text-end mb-3">
        <a class="btn btn--base" href="{{ route('ticket.open') }}"> <i class="fas fa-plus"></i> @lang('New Ticket')</a>
    </div>
    <div class="card custom--card p-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="custom--table table">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supports as $support)
                                    <tr>
                                        <td> <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}">
                                                [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                        <td>
                                            @php echo $support->statusBadge; @endphp
                                        </td>
                                        <td>
                                            @if ($support->priority == Status::PRIORITY_LOW)
                                                <span class="badge badge--dark">@lang('Low')</span>
                                            @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                                <span class="badge badge--warning">@lang('Medium')</span>
                                            @elseif($support->priority == Status::PRIORITY_HIGH)
                                                <span class="badge badge--danger">@lang('High')</span>
                                            @endif
                                        </td>
                                        <td>{{ diffForHumans($support->last_reply) }} </td>

                                        <td>
                                            <a class="btn btn--base btn--sm" href="{{ route('ticket.view', $support->ticket) }}">
                                                <i class="las la-desktop"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($supports->hasPages())
        <div class="mt-4">
            {{ paginateLinks($supports) }}
        </div>
    @endif
@endsection
