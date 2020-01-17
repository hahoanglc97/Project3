<?php
namespace admin\view\order_details;

class AddColumnOption
{
    public function __construct()
    {
        add_action('woocommerce_admin_order_item_headers', array($this,'my_woocommerce_admin_order_item_headers'));
        add_action('woocommerce_admin_order_item_values', array($this,'my_woocommerce_admin_order_item_values'),10,3);
        wp_enqueue_script( 'script', MANAGESTORE_URL . 'admin/view/web/js/load-option-item.js', array ( 'jquery' ), 1.1, true);
        wp_enqueue_style( 'style', MANAGESTORE_URL . 'admin/view/web/css/column-option-item.css');

    }

    function my_woocommerce_admin_order_item_headers() {
        $column_name = 'Assign to Store';
        echo '<th>' . $column_name . '</th>';
    }

    function my_woocommerce_admin_order_item_values($_product, $item, $item_id = null) {
        // get the post meta value from the associated product
        $value = get_post_meta($_product->post->ID, '_custom_field_name', 1);
        $urlAjax = "'".admin_url('admin-ajax.php')."'";
        echo '<td><input class="button-assign-item" type="button" value="Assign"  onclick="assignProduct('.$urlAjax.','.$_product->id.')"/></td>';

    }
}
new AddColumnOption();