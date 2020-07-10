{extends file="parent:frontend/index/sidebar.tpl"}

{block name="frontend_index_left_categories_inner"}
    {$smarty.block.parent}
    {block name="frontend_plugins_product_block"}

        {include file="frontend/plugins/product_block/index.tpl"}
    {/block}
{/block}
