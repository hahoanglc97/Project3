<?php
include_once MANAGESTORE_PATH . 'admin/block/list-products-assign-store.php';
$block = new Products_List_Table();
$post_id = $post->ID;
$allProduct = $block->get_all_products();

?>

<!--call lib jquery-->
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
<!--<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>-->


<!--code html-->
<div>
    <?php foreach ($allProduct as $product) : ?>
        <?php $dataProduct = $block->get_data_product_assign($post_id,$product->get_id()) ?>
        <br>
        <button type="button" class="collapsible"><?= $product->get_name() ?></button>
        <div class="content">
            <table class="table-date-product" id=<?= 'dataTable' . $product->get_id() ?>>
                <thead>
                    <tr>
                        <th class="hidden">Product ID</th>
                        <th>Import Date</th>
                        <th>Out Date</th>
                        <th>Qty</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(empty($dataProduct)): ?>
                    <tr id="product-<?= $product->get_id() ?>-row-1">
                        <td class="hidden"><input type="hidden" name="product-id[]" value="<?= $product->get_id() ?>"/></td>
                        <td><input name="import-date[]" class="input-import-date" type="text" /></td>
                        <td><input name="out-date[]" class="input-out-date" type="text" /></td>
                        <td><input name="qty[]" type="number" /></td>
                        <td><input type="button" value="x" class="btn-icon btn-danger" onclick="deleteRow(<?=$product->get_id() ?>,1)"/></td>
                    </tr>
                <?php else: ?>
                    <?php foreach($dataProduct as $key => $data): ?>
                        <tr id="product-<?= $product->get_id() ?>-row-<?=$key+1?>">
                            <td class="hidden"><input type="hidden" name="product-id[]" value="<?= $product->get_id() ?>"/></td>
                            <td><input name="import-date[]" class="input-import-date" type="text" value="<?= $data['import_date']?>"/></td>
                            <td><input name="out-date[]" class="input-out-date" type="text" value="<?= $data['out_date']?>"/></td>
                            <td><input name="qty[]" type="number" value="<?= $data['qty']?>"/></td>
                            <td><input type="button" value="x" class="btn-icon btn-danger" onclick="deleteRow(<?=$product->get_id() ?>, <?=$key+1?>)"/></td>
                        </tr>
                    <?php endforeach;?>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="add-row">
                <input class="button-new-row" type="button" value="Add Row"
                       onclick="addRow('<?=$product->get_id() ?>')"/>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
</div>


<!--call function js/css-->
<script src="<?= MANAGESTORE_URL ?>/admin/view/web/js/table-product-assign.js"></script>
<link rel="stylesheet" href="<?= MANAGESTORE_URL ?>/admin/view/web/css/table-product-assign.css">
