<style>
    .product-in-sale__marker {
        color:red;
    }
</style>
<div class="product-block">
    <h3>Sale</h3>
    <ul class="products-sale">
        {foreach $productList as $item}
            <li class="product-in-sale">
                {$item} <span class="product-in-sale__marker"> Sale!</span>
            </li>
        {/foreach}
    </ul>
</div>
