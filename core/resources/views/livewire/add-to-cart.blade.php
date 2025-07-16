<!-- resources/views/livewire/add-to-cart.blade.php -->
<div>

   
    
   
 <div class="product-thumb">
                                    <div class="thumb-inner">
                                        <a href="#">
                                            <img src="{{ getImage(getFilePath('products') . '/' . $product->thumbnail, getFileSize('products')) }}" alt="img">
                                        </a>
                                        <div class="thumb-group">
                                            
                           
				 <div class="loop-form-add-to-cart">
    
        <button 
            class="single_add_to_cart_button button" 
            wire:click="addToCart"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Add to cart</span>
            <span wire:loading>Adding...</span>
        </button>
    </div>
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="product-info">
                                    <h5 class="product-name product_title">
                                        <a href="#">
                                            {{ __(shortDescription($product->name, 35)) }}</a>
                                            
                                    </h5>
                                    <div class="input-group mt-2">
                                        <button 
                                            class="btn btn-outline-secondary" 
                                            type="button" 
                                            wire:click="decrementQty" 
                                            wire:loading.attr="disabled"
                                            aria-label="Decrease quantity"
                                        >-</button>
                                        <input 
                                            type="text" 
                                            class="form-control text-center" 
                                            wire:model="quantity" 
                                            readonly 
                                            aria-label="Product quantity"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary" 
                                            type="button" 
                                            wire:click="incrementQty" 
                                            wire:loading.attr="disabled"
                                            aria-label="Increase quantity"
                                        >+</button>
                                    </div>
                                    <div class="group-info mt-2">
                                      
                                        <div class="price">
                                         
                                            <ins>
                                               {{ showAmount($product->price) }}
                                            </ins>
                                        </div>
                                    </div>
                                </div>
</div>