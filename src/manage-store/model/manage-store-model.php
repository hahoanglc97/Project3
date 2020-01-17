<?php
if (!defined('ABSPATH'))
    exit (); // Exit if accessed directly

require_once WP_PLUGIN_DIR . '/woocommerce/includes/abstracts/abstract-wc-settings-api.php';
require_once WP_PLUGIN_DIR . '/woocommerce/includes/emails/class-wc-email.php';

class Manage_Store_Model
{
    private static function get_data($condition = null)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $rTb = "{$prefix}manage_store_location";
        try{
            if($condition){
                $row = $wpdb->get_results("select * from {$rTb} where {$condition}", ARRAY_A);
            }else{
                $row = $wpdb->get_results("select * from {$rTb}", ARRAY_A);
            }
            if ($row) {
                return $row;
            }
        }catch (\Exception $e){
            throw new \Exception(__('Can\'t get data store', 'managestore'));
            error_log( $e->getMessage());
            return ;
        }
    }

    private function update_data($condition,$data){
        global $wpdb;
        $prefix = $wpdb->prefix;
        $rTb = "{$prefix}manage_store_location";
        try{
            $wpdb->update($rTb,$data,$condition);
        }catch (\Exception $e){
            throw new \Exception(__('Can\'t get data store', 'managestore'));
            error_log( $e->getMessage());
            return ;
        }
    }

    private function get_qty_product_by_store($product_id,$location_id){
        $condition = "post_meta_id like {$location_id} and product_id like {$product_id}";
        return $this->get_data($condition);
    }

    public function get_all_data(){
        return $this->get_data();
    }

    public function get_store_by_post_id($post_id)
    {
        $condition = "post_meta_id like {$post_id}";
        return $this->get_data($condition);
    }

    public function update_qty_product($location_id,$itemsQty){
        $data = [];
        foreach($itemsQty as $itemId => $qty){
            $qtyStore = $this->get_qty_product_by_store($itemId,$location_id);
            $data += [
                $itemId => $qtyStore - $qty
            ];
        }
        $this->update_data("post_meta_id like {$location_id}",$data);
    }
}
return new Manage_Store_Model();

