<?php

class Manage_AddStore_Savemeta
{
    protected $locationId = null;

    public function updateStore($post_id, $post)
    {
        global $wpdb, $woocommerce_errors;

        $data = [
            'location_id' => NULL,
            'post_meta_id' => $post_id,
            'post_title' => NULL,
            'status' => '',
            'name' => '',
            'description' => '',
            'address' => '',
            'phone_number' => '',
            'latitude' => '',
            'longitude' => ''
        ];
        if (!empty($_POST['store_status'])) $data['status'] = $_POST['store_status'];

        if (!empty($_POST['store_name'])) $data['name'] = $_POST['store_name'];

        if (!empty($_POST['store_description'])) $data['description'] = $_POST['store_description'];

        if (!empty($_POST['store_address'])) $data['address'] = $_POST['store_address'];

        if (!empty($_POST['store_phone'])) $data['phone_number'] = $_POST['store_phone'];

        if (!empty($_POST['store_latitude'])) $data['latitude'] = $_POST['store_latitude'];

        if (!empty($_POST['store_longitude'])) $data['longitude'] = $_POST['store_longitude'];

        $list_product = $this->convertDataAssignProduct($post_id);
        $manage_store_table = $wpdb->prefix . 'manage_store_location';
        $manage_store_product_table = $wpdb->prefix . 'manage_store_product';
        if ($data['name'] != '') {
            if (!$this->checkIsUpdate($post_id)) {
                $data['post_title'] = $post->post_title;
                foreach ($list_product as $product) {
                    $this->insertData($manage_store_product_table, $product);
                }
                $this->insertData($manage_store_table, $data);
            } else {
                $condition = array('post_meta_id' => $post_id);
                $data['post_title'] = $post->post_title;
                $data['location_id'] = $this->locationId;
                //clear data product assign
                $this->clear_data_product_store($post_id);
                foreach ($list_product as $product) {
                    $this->insertData($manage_store_product_table, $product);
                }
                $this->updateData($manage_store_table, $data, $condition);
            }
        }
    }

    private function insertData($table, $data)
    {
        global $wpdb;
        try {
            $wpdb->insert($table, $data);
        } catch (\Exception $e) {
            throw new \Exception(__('Can\'t save data store', 'managestore'));
            error_log($e->getMessage());
        }
    }

    private function updateData($table, $data, $condition)
    {
        global $wpdb;
        try {
            $wpdb->update($table, $data, $condition);
        } catch (\Exception $e) {
            throw new \Exception(__('Can\'t save data store', 'managestore'));
            error_log($e->getMessage());
        }
    }

    public function checkIsUpdate($post_id)
    {
        include_once MANAGESTORE_PATH . 'model/manage-store-model.php';
        $modelStore = new \Manage_Store_Model();
        $dataStore = $modelStore->get_store_by_post_id($post_id);
        $this->locationId = $dataStore['location_id'];
        if ($dataStore) return true;
        return false;
    }

    private function convertDataAssignProduct($post_id)
    {
        $data = [];
        $length = isset($_POST['import-date']) ? count($_POST['import-date']) : 0;
        if($length > 0) {
            try {
                for ($i = 0; $i < $length; $i++) {
                    if ($_POST['import-date'][$i] != "" || $_POST['out-date'][$i] != "" || $_POST['qty'][$i] != "") {
                        $data[$i] = [
                            'post_meta_id' => $post_id,
                            'product_id' => $_POST['product-id'][$i],
                            'import_date' => $_POST['import-date'][$i],
                            'out_date' => $_POST['out-date'][$i],
                            'qty' => $_POST['qty'][$i]
                        ];
                    }
                }
            } catch (\Exception $e) {
                throw new \Exception(__('Can\'t save data store', 'managestore'));
                error_log($e->getMessage());
            }
        }
        return $data;
    }

    private function get_all_product_assign($post_id){
        include_once MANAGESTORE_PATH . 'model/manage-store-product-model.php';
        $modelStore = new Manage_Store_Product_Model();
        return $modelStore->get_all_product_assign($post_id);
    }

    private function clear_data_product_store($post_id){
        include_once MANAGESTORE_PATH . 'model/manage-store-product-model.php';
        $modelStore = new Manage_Store_Product_Model();
        $modelStore->delete_data_by_post_id($post_id);
    }


}

return new Manage_AddStore_Savemeta();
