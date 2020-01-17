<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Products_List_Table extends WP_List_Table
{
    protected $data = [];

    function get_all_products(){
        $query = new WC_Product_Query(array(
            'orderby' => 'id',
            'order' => 'ASC',
            'return' => '*',
        ));
        return $query->get_products();
    }

    function get_data_product_assign($post_id,$product_id){
        include_once MANAGESTORE_PATH . 'model/manage-store-product-model.php';
        $modelStore = new Manage_Store_Product_Model();
        return $modelStore->get_product_meta_data($post_id,$product_id);
    }

}

$productsListTable = new Products_List_Table();
