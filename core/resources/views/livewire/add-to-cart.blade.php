<!-- resources/views/livewire/add-to-cart.blade.php -->
<div>

    <div class="loop-form-add-to-cart">
        <div class="quantity">
            <input 
                type="hidden" 
                class="input-text qty text" 
                wire:model="quantity" 
                min="1" 
                max="100"
                value="1"
            >
        </div>
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