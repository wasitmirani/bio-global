@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Trx')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Total Price')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>

                                        <td>
                                            @if(!empty( $order->user))
                                            <span class="fw-bold">{{ $order->user->fullname  }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $order->user_id) }}"><span>@</span>{{ $order->user->username }}</a>
                                            </span>
                                            @else
                                            <span class="fw-bold text-primary">{{ __('Guest') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ '#' . $order->trx }}</td>

                                        <td>{{ showAmount($order->price) }} </td>
                                        <td>{{ showAmount($order->price * $order->quantity) }}</td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>
                                            @php echo $order->statusOrderBadge @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-outline--primary btn-sm orderBtn"
                                                    data-action="{{ route('admin.order.status', $order->id) }}"
                                                    @if ($order->status != 0) disabled @endif>@lang('Order Status')</button>
                                                <button class="btn btn-sm btn-outline--success orderDetailsBtn" data-order='@json($order)'
                                                    data-date="{{ showDateTime($order->created_at) }}" data-status="{{ $order->statusOrderBadge }}"><i
                                                        class="las la-desktop"></i>@lang('Details')</button>
                                               
                                                 <button class="btn btn-sm btn-outline--info orderDetailsBtnItems" data-order='@json($order)'
                                                    data-date="{{ showDateTime($order->created_at) }}" data-status="{{ $order->statusOrderBadge }}">
                                                     <i class="las la-box"></i>@lang('Items & Shipping')
                                                        
                                                        @lang('Details')
                                                    
                                                    </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($orders->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($orders) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
         <div class="modal fade" id="orderStatusModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Order Status')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Order Status')</label>
                            <select class="form-control select2" name="status" data-minimum-results-for-search="-1">
                                <option value="1">@lang('Shipped')</option>
                                <option value="2">@lang('Cancel')</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--dark" data-bs-dismiss="modal" type="button">@lang('Cancel')</button>
                        <button class="btn btn--primary" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Order Items & Shipping Address Modal -->
    <div class="modal fade" id="orderItemsModal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderItemsModalLabel">@lang('Order Items & Shipping Address')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">@lang('Items')</h6>
                    <ul class="list-group mb-4 order-items-list">
                        <!-- Items will be injected by JS -->
                    </ul>
                    <h6 class="mb-3">@lang('Shipping Details')</h6>
                    <div class="shipping-address">
                        <!-- Address will be injected by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    


    <div class="modal fade" id="orderDetailsModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Order Details')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Product')</b> <a class="product" href=""></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Quantity') </b> <span class="quantity"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Price') </b> <span class="price"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Total Price') </b> <span class="total-price"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Username')</b> <span class="username"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Transition No')</b> <span class="trx"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Order Date') </b> <span class="date"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <b>@lang('Status') </b> <span class="status"></span>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.orderBtn').on('click', function() {
                var modal = $('#orderStatusModal');
                modal.find('form').attr('action', $(this).data('action'));
                modal.modal('show');
            });

            $('.orderDetailsBtn').on('click', function() {
                var modal = $('#orderDetailsModal');
                var order = $(this).data('order');
                var date = $(this).data('date');
                var status = $(this).data('status');
                var curSym = `{{ gs('cur_sym') }}`;
                var price = curSym + parseFloat(order.price).toFixed(2);
                var totalPrice = curSym + parseFloat(order.total_price).toFixed(2);
                var url = (`{{ route('admin.product.edit', ':id') }}`).replace(":id", order.product_id);
                modal.find('.username').text(order?.user?.username ? order?.user?.username : 'Guest');
                modal.find('.trx').text(order.trx);
                modal.find('.product').text(order.product?.name);
                modal.find('.product').attr('href', url);
                modal.find('.quantity').text(order.quantity);
                modal.find('.quantity').text(order.quantity);
                modal.find('.price').text(price);
                modal.find('.total-price').text(totalPrice);
                modal.find('.status').html(status);
                modal.find('.date').html(date);
                modal.modal('show');
            });

              $('.orderDetailsBtnItems').on('click', function(e) {
                console.log('Right click detected');
          
                var order = $(this).data('order');
                var modal = $('#orderItemsModal');
                console.log(order);
              
           
                var itemsList = modal.find('.order-items-list');
                var addressDiv = modal.find('.shipping-address');
                itemsList.empty();
                addressDiv.empty();

                // Items
                if(order.order_items && order.order_items.length > 0){
                    order.order_items.forEach(function(item){
                        itemsList.append(
                            `<li class="list-group-item d-flex justify-content-between align-items-center" style="background: #f8f9fa; border-radius: 6px; margin-bottom: 8px;">
                                <span>
                                    <b style="color: #2d3748;">${item.product.name}</b>
                                    <br>
                                    <small style="color: #6c757d;">@lang('Qty'): ${item.quantity}</small>
                                </span>
                                <span style="font-weight: bold; color: #198754;">{{ gs('cur_sym') }}${parseFloat(item.price).toFixed(2)}</span>
                            </li>`
                        );
                    });
                } else {
                    itemsList.append(`<li class="list-group-item text-muted">@lang('No items found')</li>`);
                }

                // Shipping Address
                if(order.shipping_details){

                    let addr = JSON.parse(order.shipping_details);
                    console.log('Parsed Address:', addr);
                    console.log(addr);
                    addressDiv.html(
                        `<div style="background: #f8f9fa; border-radius: 8px; padding: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.04);">
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">Name:</b> <span style="color:#495057;">${addr.first_name ?? ''} ${addr.last_name ?? ''}</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">Email:</b> <span style="color:#495057;">${addr.email ?? ''}</span>
                            </div>
                            ${addr.company ? `<div style="margin-bottom: 8px;"><b style="color:#2d3748;">Company:</b> <span style="color:#495057;">${addr.company}</span></div>` : ''}
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">Address:</b> <span style="color:#495057;">${addr.address ?? ''}</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">City:</b> <span style="color:#495057;">${addr.city ?? ''}</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">State:</b> <span style="color:#495057;">${addr.state ?? ''}</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">ZIP:</b> <span style="color:#495057;">${addr.zip ?? ''}</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">Country:</b> <span style="color:#495057;">${addr.country ?? ''}</span>
                            </div>
                            <div style="margin-bottom: 8px;">
                                <b style="color:#2d3748;">Phone:</b> <span style="color:#495057;">${addr.phone ?? ''}</span>
                            </div>
                            ${addr.order_notes ? `<div style="margin-bottom: 8px;"><b style="color:#2d3748;">Order Notes:</b> <span style="color:#495057;">${addr.order_notes}</span></div>` : ''}
                            ${addr.payment_proof_url ? `<div style="margin-bottom: 8px;"><b style="color:#2d3748;">Payment Proof:</b> <a href="{{ asset('/core/public') }}/${addr.payment_proof_url.replace(/^.*storage[\\/]/, '')}" target="_blank" style="color:#0d6efd;">View Proof</a></div>` : ''}
                        </div>`
                    );
                } else {
                    addressDiv.html(`<span class="text-muted">@lang('No shipping details found')</span>`);
                }

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
