<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-smsassistent" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-smsassistent" class="form-horizontal">
          <fieldset>
            <legend><?php echo $text_general; ?></legend>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
              <div class="col-sm-10">
                <select name="smsassistent_status" id="input-status" class="form-control">
                  <?php if ($smsassistent_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-api-username"><?php echo $entry_api_username; ?></label>
              <div class="col-sm-10">
                <input type="text" name="smsassistent_api_username" value="<?php echo $smsassistent_api_username; ?>" placeholder="<?php echo $entry_api_username; ?>" id="input-api-username" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-api-token"><?php echo $entry_api_token; ?></label>
              <div class="col-sm-10">
                <input type="text" name="smsassistent_api_token" value="<?php echo $smsassistent_api_token; ?>" placeholder="<?php echo $entry_api_token; ?>" id="input-api-token" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-api-password"><?php echo $entry_api_password; ?></label>
              <div class="col-sm-10">
                <input type="text" name="smsassistent_api_password" value="<?php echo $smsassistent_api_password; ?>" placeholder="<?php echo $entry_api_password; ?>" id="input-api-password" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-sender-name"><?php echo $entry_sender_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="smsassistent_sender_name" value="<?php echo $smsassistent_sender_name; ?>" placeholder="<?php echo $entry_sender_name; ?>" id="input-sender-name" class="form-control" />
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend><?php echo $text_customer_order_create; ?></legend>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-customer-order-create-status"><?php echo $entry_customer_order_create_status; ?></label>
              <div class="col-sm-10">
                <select name="smsassistent_customer_order_create_status" id="input-customer-order-create-status" class="form-control">
                  <?php if ($smsassistent_customer_order_create_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-customer-order-create-text"><?php echo $entry_customer_order_create_text; ?></label>
              <div class="col-sm-10">
                <textarea name="smsassistent_customer_order_create_text" rows="5" placeholder="<?php echo $smsassistent_customer_order_create_text; ?>" id="input-customer-order-create-text" class="form-control"><?php echo $smsassistent_customer_order_create_text; ?></textarea>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend><?php echo $text_admin_order_create; ?></legend>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-admin-order-create-status"><?php echo $entry_admin_order_create_status; ?></label>
              <div class="col-sm-10">
                <select name="smsassistent_admin_order_create_status" id="input-admin-order-create-status" class="form-control">
                  <?php if ($smsassistent_admin_order_create_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-admin-order-create-phones"><span data-toggle="tooltip" title="<?php echo $help_admin_order_create_phones; ?>"><?php echo $entry_admin_order_create_phones; ?></label>
              <div class="col-sm-10">
                <input type="text" name="smsassistent_admin_order_create_phones" value="<?php echo $smsassistent_admin_order_create_phones; ?>" placeholder="<?php echo $smsassistent_admin_order_create_phones; ?>" id="input-admin-order-create-phones" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-admin-order-create-text"><?php echo $entry_admin_order_create_text; ?></label>
              <div class="col-sm-10">
                <textarea name="smsassistent_admin_order_create_text" rows="5" placeholder="<?php echo $smsassistent_admin_order_create_text; ?>" id="input-admin-order-create-text" class="form-control"><?php echo $smsassistent_admin_order_create_text; ?></textarea>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>