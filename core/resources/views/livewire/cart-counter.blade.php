<div>
  <div class="block-minicart stelina-mini-cart block-header stelina-dropdown">
                            <a href="javascript:void(0);" class="shopcart-icon" data-stelina="stelina-dropdown">
                                Cart
                                <span class="count">
                                    {{ $count }}
                                </span>
                            </a>
                            <div class="no-product stelina-submenu">
                                <p class="text">
                                    You have
                                    <span>
                                        {{ $count }} item(s)
                                    </span>
                                    in your bag
                                </p>
                                <a href="{{ route('shopping.cart') }}" class="btn btn-primary">
                                    View Cart
                                </a>
                            </div>
                        </div>
</div>
