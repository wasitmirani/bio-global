<div>
   <div class="main-content-cart main-content col-sm-12">
                    <h3 class="custom_blog_title">
                        Shopping Cart
                    </h3>
                    <div class="page-main-content">
                        <div class="shoppingcart-content">
                            <form action="shoppingcart.html" class="cart-form">
                                <table class="shop_table">
                                    <thead>
                                    <tr>
                                        <th class="product-remove"></th>
                                        <th class="product-thumbnail"></th>
                                        <th class="product-name"></th>
                                        <th class="product-price"></th>
                                        <th class="product-quantity"></th>
                                        <th class="product-subtotal"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     
                                    @foreach ($cartItems as $item)
                                        <tr class="cart_item">
                                            <td class="product-remove">
                                                <a href="#" class="remove" wire:click.prevent="removeFromCart({{ $item->id }})"></a>
                                            </td>
                                            <td class="product-thumbnail">
                                                <a href="#">
                                                    <img src="{{ getImage(getFilePath('products') . '/' . $item->product->thumbnail, getFileSize('products')) }}" alt="img" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image">
                                                </a>
                                            </td>
                                            <td class="product-name" data-title="Product">
                                                <a href="#" class="title"> {{ __(shortDescription($item->product->name, 50)) }} </a>
                                                <span class="attributes-select attributes-color">{{ $item->product->color }}</span>
                                                <span class="attributes-select attributes-size">{{ $item->product->size }}</span>
                                            </td>
                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity">
                                                    <div class="control">
                                                        <a class="btn-number qtyminus quantity-minus" href="#">-</a>
                                                        <input type="text" data-step="1" data-min="0" value="{{ $item->quantity }}" title="Qty" class="input-qty qty" size="4">
                                                        <a href="#" class="btn-number qtyplus quantity-plus" wire:click.prevent="increaseQty({{ $item->id }})">+</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-price" data-title="Price">
                                                <span class="woocommerce-Price-amount amount">
                                                    <span class="woocommerce-Price-currencySymbol">
                                                   
                                                    </span>
                                                    {{ showAmount($item->price) }}  
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                              
                                    
                                    <tr>
                                        <td class="actions">
                                            <div class="coupon">
                                                <label class="coupon_code">Coupon Code:</label>
                                                <input type="text" class="input-text" placeholder="Promotion code here">
                                                <a href="#" class="button"></a>
                                            </div>
                                            <div class="order-total">
														<span class="title">
															Total Price:
														</span>
                                                <span class="total-price">
															{{ showAmount($total) }}
														</span>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                            <div class="control-cart">
                                <a href="{{ route('products.listing') }}" class="button btn-continue-shopping">
                                    Continue Shopping
                                </a>
                                <a href="{{ route('checkout.index') }}" class="button btn-cart-to-checkout">
                                    Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
</div>
