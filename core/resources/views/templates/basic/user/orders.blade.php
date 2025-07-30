@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card p-0 p-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="custom--table table">
                    <thead>
                        <tr>
                            <th>@lang('Items')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Price')</th>
                            <th>@lang('Total Price')</th>
                            <th>@lang('Status')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    @foreach($order->orderItems as $item)
                                        <div>
                                            <strong>{{ $item->product->name }}</strong> ({{ $item->quantity }})
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ showAmount($order->price) }}</td>
                                <td>{{ showAmount($order->total_price) }}</td>
                                <td>
                                    @php echo $order->statusOrderBadge @endphp
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="100%">@lang('No order found')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($orders->hasPages())
        <div class="mt-4">
            {{ paginateLinks($orders) }}
        </div>
    @endif
@endsection
