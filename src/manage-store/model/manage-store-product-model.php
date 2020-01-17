<?php
if (!defined('ABSPATH'))
    exit (); // Exit if accessed directly

require_once WP_PLUGIN_DIR . '/woocommerce/includes/abstracts/abstract-wc-settings-api.php';
require_once WP_PLUGIN_DIR . '/woocommerce/includes/emails/class-wc-email.php';

class Manage_Store_Product_Model
{
    private static function get_data($condition)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $rTb = "{$prefix}manage_store_product";

        try {
            $row = $wpdb->get_results("select * from {$rTb} where {$condition}", ARRAY_A);
        } catch (\Exception $e) {
            throw new \Exception(__('Can\'t get product of store', 'managestore'));
            error_log($e->getMessage());
        }

        if ($row) {
            return $row;
        }
    }

    private static function delete_data($condition)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $rTb = "{$prefix}manage_store_product";

        try {
            $wpdb->delete($rTb, $condition);
        } catch (\Exception $e) {
            throw new \Exception(__('Can\'t delete product of store', 'managestore'));
            error_log($e->getMessage());
        }
    }

    private function update_data($condition, $data)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $rTb = "{$prefix}manage_store_product";
        try {
            $wpdb->update($rTb, $data, $condition);
        } catch (\Exception $e) {
            throw new \Exception(__('Can\'t get data store', 'managestore'));
            error_log($e->getMessage());
            return;
        }
    }

    public function get_product_meta_data($post_id, $product_id)
    {
        $condition = "post_meta_id like {$post_id} and product_id like {$product_id}";
        return $this->get_data($condition);
    }

    public function get_all_product_assign($post_id)
    {
        $condition = "post_meta_id like {$post_id}";
        return $this->get_data($condition);
    }

    public function delete_data_by_post_id($post_id)
    {
        $condition = array('post_meta_id' => $post_id);
        $this->delete_data($condition);
    }

    public function update_qty($conditionQty, $qty)
    {
        $conditionGetQtyStore = "post_meta_id like {$conditionQty['post_meta_id']} and product_id like {$conditionQty['product_id']} and import_date like '{$conditionQty['import_date']}' and out_date like '{$conditionQty['out_date']}'";
        $currentQty = $this->get_data($conditionGetQtyStore);
        if($currentQty){
            $updateQty = intval($currentQty[0]['qty']) - intval($qty);
            $data = array('qty' => $updateQty);
            $this->update_data($conditionQty, $data);
        }
    }

}

return new Manage_Store_Product_Model();

