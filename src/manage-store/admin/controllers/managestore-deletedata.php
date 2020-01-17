<?php
class ManageStore_DeleteData{
    public function deleteStore($post_id){
        global $wpdb, $woocommerce_errors;
        $manage_store_table = $wpdb->prefix . 'manage_store_location';
        try{
            $wpdb->delete($manage_store_table,array('post_meta_id'=>$post_id));
        }catch (\Exception $e){
            throw new \Exception(__('Can\'t delete data store', 'managestore'));
            error_log( $e->getMessage());
        }
    }
}
return new ManageStore_DeleteData();
