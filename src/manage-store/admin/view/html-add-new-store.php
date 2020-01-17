<?php
if (!defined('ABSPATH')) {
    exit();
}
$post_id = $post->ID;
include_once MANAGESTORE_PATH . 'model/manage-store-model.php';
$modelStore = new Manage_Store_Model();
$data = $modelStore->get_store_by_post_id($post_id);
$dataStore = $data[0];
$flag = false;
if ($dataStore) $flag = true;

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<p class="form-field">
    <label for="store_status"><?php echo __('Status', 'managestore') ?></label>
    <select name="store_status" id="store_status">
        <option <?php if($flag){echo $dataStore['status'] == 'enable' ? 'selected': null;}?>
                value="enable" style="font-family: 'Acme';"><?= __('Enable', 'managestore') ?></option>
        <option <?php if($flag){ echo $dataStore['status'] == 'disable' ? 'selected': null;} ?>
                value="disable" style="font-family: 'Acme';"><?= __('Disable', 'managestore') ?></option>
    </select>
</p>
<p class="form-field">
    <label for="store_name"><?php echo __('Name Store', 'managestore') ?></label>
    <input type="text" class="short" style="" name="store_name" id="store_name_store"
           value=" <?php if ($flag){ echo isset($dataStore['name']) ? $dataStore['name'] : null; } ?>">
    <p class="error-message manage-store none-active" id="error_name">Please enter less than 100 characters</p>
</p>
<p class="form-field">
    <label for="store_description"><?php echo __('Description', 'managestore') ?></label>
    <input type="text" class="short" style="" name="store_description" id="store_description_store"
           value=" <?php if ($flag){ echo isset($dataStore['description']) ? $dataStore['description'] : null; } ?>">
</p>
<p class="form-field">
    <label for="store_address"><?php echo __('Address Store', 'managestore') ?></label>
    <input type="text" class="short" style="" name="store_address" id="store_address_store"
           value=" <?php if ($flag){ echo isset($dataStore['address']) ? $dataStore['address'] : null; } ?>">
</p>
<p class="form-field">
    <label for="store_phone"><?php echo __('Phone Number', 'managestore') ?></label>
    <input type="text" class="short" style="" name="store_phone" id="store_phone_store"
           value=" <?php if ($flag){ echo isset($dataStore['phone_number']) ? $dataStore['phone_number'] : null; } ?>">
    <p class="error-message manage-store none-active" id="error_phone">Please specify a valid phone number.</p>
</p>


<!--call function js/css-->
<script src="<?=MANAGESTORE_URL?>/admin/view/web/js/validate-form-add-store.js"></script>
<link rel="stylesheet" href="<?=MANAGESTORE_URL?>/admin/view/web/css/add-new-store.css">

