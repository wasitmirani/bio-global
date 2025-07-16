<div>

        
        <div class="checkout-wrapp">
            <div class="shipping-address-form-wrapp">
                <div class="shipping-address-form  checkout-form">
                    <div class="row-col-1 row-col">
                        <div class="shipping-address">
                            <h3 class="title-form">
                                Shipping Address
                            </h3>
                            <form wire:submit.prevent="submitOrder">
                                <p class="form-row form-row-first">
                                    <label class="text">First name</label>
                                    <input wire:model.defer="first_name" title="first" type="text" class="input-text" required>
                                    @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">Last name</label>
                                    <input wire:model.defer="last_name" title="last" type="text" class="input-text" required>
                                    @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-first">
                                    <label class="text">Email</label>
                                    <input wire:model.defer="email" title="email" type="email" class="input-text" required>
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">Phone Number</label>
                                    <input wire:model.defer="phone" title="phone" type="tel" class="input-text" required>
                                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-first">
                                    <label class="text">Country</label>
                                    <input wire:model.defer="country" title="country" type="text" class="input-text" required>
                                    @error('country') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">City</label>
                                    <input wire:model.defer="city" title="city" type="text" class="input-text" required>
                                    @error('city') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-first">
                                    <label class="text">State/Province</label>
                                    <input wire:model.defer="state" title="state" type="text" class="input-text" required>
                                    @error('state') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">Zip/Postal Code</label>
                                    <input wire:model.defer="zip" title="zip" type="text" class="input-text" required>
                                    @error('zip') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-first">
                                    <label class="text">Address</label>
                                    <input wire:model.defer="address" title="address" type="text" class="input-text" required>
                                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-last">
                                    <label class="text">Company (optional)</label>
                                    <input wire:model.defer="company" title="company" type="text" class="input-text">
                                    @error('company') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-wide">
                                    <label class="text">Order Notes (optional)</label>
                                    <textarea wire:model.defer="order_notes" title="order_notes" class="input-text"></textarea>
                                    @error('order_notes') <span class="text-danger">{{ $message }}</span> @enderror
                                </p>
                                <p class="form-row form-row-wide">
                                    <label class="text">Upload Proof of Payment</label>
                                    <input type="file" wire:model.defer="payment_proof" class="input-text" accept="image/*">
                                    @error('payment_proof') <span class="text-danger">{{ $message }}</span> @enderror

                                    @if ($payment_proof)
                                        <div class="mt-2">
                                        <img src="{{ $payment_proof->temporaryUrl() }}" alt="Proof of Payment" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </p>
                                <button type="submit" class="button btn-pay-now">Submit Order</button>
                            </form>
                        </div>
                    </div>
                    <div class="row-col-2 row-col">
                        <div class="your-order">
                            <h3 class="title-form">
                                Your Order
                            </h3>
                            <ul class="list-product-order">
                                 @foreach ($cartItems as $item)
                                    <li class="product-item-order">
                                        <div class="product-thumb">
                                            <a href="#">
                                                <img src="{{ getImage(getFilePath('products') . '/' . $item->product->thumbnail, getFileSize('products')) }}" alt="img">
                                            </a>
                                        </div>
                                    <div class="product-order-inner">
                                        <h5 class="product-name">
                                            <a href="#">{{ $item->name }}</a>
                                        </h5>
                                        <span class="attributes-select attributes-color">{{ $item->color }}</span>
                                        <span class="attributes-select attributes-size">{{ $item->size }}</span>
                                        <div class="price">
                                              {{ showAmount($item->price ) }}  
                                            <span class="count">x{{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                
                            </ul>
                            <div class="order-total">
									<span class="title">
										Total Price:
									</span>
                                <span class="total-price">
										{{ showAmount($total) }}
									</span>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
            <div class="payment-method-wrapp">
                <div class="payment-method-form checkout-form">
                    <div class="row-col-1 row-col">
                        <div class="payment-method">
                            <h3 class="title-form">
                                Payment Method (Bank Transfer)
                            </h3>
                        
                            <div class="bank-details">
                                <h4>Bank Account Information</h4>
                                <ul>
                                    <li><strong>Bank Name:</strong> Example Bank Ltd.</li>
                                    <li><strong>Account Name:</strong> John Doe</li>
                                    <li><strong>Account Number:</strong> 1234567890</li>
                                    <li><strong>IBAN:</strong> EX12345678901234567890</li>
                                    <li><strong>SWIFT/BIC:</strong> EXAMPBANK</li>
                                    <li><strong>Branch:</strong> Main Street, City</li>
                                </ul>
                                <p>Please use your Order ID as the payment reference.</p>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <div class="button-control">
                    <a href="{{ route('products.listing') }}" class="button btn-back-to-shipping">Back to shipping</a>

                </div>
            </div>
          
        </div>
    
</div>
