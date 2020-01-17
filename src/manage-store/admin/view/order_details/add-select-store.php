<?php

namespace admin\view\order_details;

class AddFieldSelectStore
{
    public function __construct()
    {
        add_action('woocommerce_admin_order_data_after_order_details', array($this, 'field_select_store_order_meta'));
        add_action('woocommerce_saved_order_items', array($this, 'field_select_store_save_order_details'));
        add_action('admin_head', array($this, 'misha_fix_wc_tooltips'));
//        include_once MANAGESTORE_PATH.'admin/view/popup-select-item.php';
    }

    // add field select store for assign order
    function field_select_store_order_meta($order)
    {
        // $contactmethod = get_post_meta( $order->id, 'contactmethod', true );
        include_once MANAGESTORE_PATH . 'model/manage-store-model.php';
        $modelStore = new \Manage_Store_Model();
        $allData = $modelStore->get_all_data();
        $option = ['' => 'Select Store'];
        foreach ($allData as $store) {
            $option += [
                $store['post_meta_id'] => $store['name']
            ];
        }
        woocommerce_wp_select(array(
            'id' => 'selectstore',
            'label' => 'List Store:',
            'wrapper_class' => 'form-field-wide select-store-set-tip-style store-select',
            'value' => $order->get_meta('selectstore') != null ? $order->get_meta('selectstore') : 0,
            'selected' => true,
            'required' => true,
            'options' => $option
        ));
    }

    function field_select_store_save_order_details($ord_id, $items)
    {
        if (isset($_POST['selectstore'])) {
            include_once MANAGESTORE_PATH . 'model/manage-store-product-model.php';
            $modelStore = new \Manage_Store_Product_Model();
            $store_id = $_POST['selectstore'];
            $idProduct = $_POST['id-product'];
            $importDate = $_POST['import-date'];
            $outDate = $_POST['out-date'];
            $qty = $_POST['qty-assign'];
            $dataMeta = [];
            foreach($idProduct as $key=> $id){
                if($qty[$key] != 0){
                    $dataMeta[] = array(
                        'product_id' => $id,
                        'import_date' => $importDate[$key],
                        'out_date' => $outDate[$key],
                        'qty' => $qty[$key]
                    );
                    $conditionQty = array(
                        'post_meta_id' => $store_id,
                        'import_date' => $importDate[$key],
                        'out_date' => $outDate[$key],
                        'product_id' => $id
                    );
                    $modelStore->update_qty($conditionQty,$qty[$key]);
                }
            }
            update_post_meta($ord_id, 'selectstore', wc_clean($_POST['selectstore']));
            update_post_meta($ord_id, 'qty-assign-store', json_encode($dataMeta));
        }
    }

    //style for new field in order
    function misha_fix_wc_tooltips()
    {
        echo '<style>
	#order_data .order_data_column .form-field.select-store-set-tip-style label{
		display:inline-block;
	}
	.form-field.select-store-set-tip-style .woocommerce-help-tip{
		margin-bottom:5px;
	}
	</style>';
    }
}

new AddFieldSelectStore();