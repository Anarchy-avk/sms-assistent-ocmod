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
          <ul class="col-sm-12 nav nav-tabs" id="settings-tabs">
            <li class="active"><a href="#tab-ms" data-toggle="tab"><?php echo $pane_ms; ?></a></li>
            <li><a href="#tab-naco" data-toggle="tab"><?php echo $pane_naco; ?></a></li>
            <li><a href="#tab-narc" data-toggle="tab"><?php echo $pane_narc; ?></a></li>
            <li><a href="#tab-logs" data-toggle="tab"><?php echo $pane_logs; ?></a></li>
          </ul>
          <div class="col-sm-12 tab-content">
            <div class="tab-pane active" id="tab-ms">
              <fieldset>
                <legend><?php echo $text_ms_general; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-status"><?php echo $entry_ms_status; ?></label>
                  <div class="col-sm-10">
                    <select name="smsassistent_ms_status" id="input-ms-status" class="form-control">
                      <?php if ($smsassistent_ms_status) { ?>
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
                  <label class="col-sm-2 control-label" for="input-ms-api-username"><?php echo $entry_ms_api_username; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_api_username" value="<?php echo $smsassistent_ms_api_username; ?>" placeholder="<?php echo $entry_ms_api_username; ?>" id="input-ms-api-username" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-api-token"><?php echo $entry_ms_api_token; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_api_token" value="<?php echo $smsassistent_ms_api_token; ?>" placeholder="<?php echo $entry_ms_api_token; ?>" id="input-ms-api-token" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-api-password"><?php echo $entry_ms_api_password; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_api_password" value="<?php echo $smsassistent_ms_api_password; ?>" placeholder="<?php echo $entry_ms_api_password; ?>" id="input-ms-api-password" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-sender-name"><?php echo $entry_ms_sender_name; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_sender_name" value="<?php echo $smsassistent_ms_sender_name; ?>" placeholder="<?php echo $entry_ms_sender_name; ?>" id="input-ms-sender-name" class="form-control" />
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-naco">
              <fieldset>
                <legend><?php echo $text_naco_customer; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-naco-customer-status"><?php echo $entry_naco_customer_status; ?></label>
                  <div class="col-sm-10">
                    <select name="smsassistent_naco_customer_status" id="input-naco-customer-status" class="form-control">
                      <?php if ($smsassistent_naco_customer_status) { ?>
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
                  <label class="col-sm-2 control-label" for="input-naco-customer-text"><?php echo $entry_naco_customer_text; ?></label>
                  <ul class="col-sm-10 nav nav-tabs">
                    <li class="active"><a href="#tab-naco-customer-text" data-toggle="tab"><?php echo $pane_naco_sms_text; ?></a></li>
                    <li><a href="#tab-naco-customer-template" data-toggle="tab"><?php echo $pane_naco_sms_template; ?></a></li>
                  </ul>
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-10 tab-content">
                    <div class="tab-pane active" id="tab-naco-customer-text">
                      <textarea name="smsassistent_naco_customer_text" rows="5" placeholder="<?php echo $entry_naco_customer_text; ?>" id="input-naco-customer-text" class="form-control"><?php echo $smsassistent_naco_customer_text; ?></textarea>
                    </div>
                    <div class="tab-pane" id="tab-naco-customer-template">
                      <p><?php echo $pane_naco_sms_template_text; ?></p>
                    </div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_naco_admin; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-naco-admin-status"><?php echo $entry_naco_admin_status; ?></label>
                  <div class="col-sm-10">
                    <select name="smsassistent_naco_admin_status" id="input-naco-admin-status" class="form-control">
                      <?php if ($smsassistent_naco_admin_status) { ?>
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
                  <label class="col-sm-2 control-label" for="input-naco-admin-phones"><span data-toggle="tooltip" title="<?php echo $help_naco_admin_phones; ?>"><?php echo $entry_naco_admin_phones; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_naco_admin_phones" value="<?php echo $smsassistent_naco_admin_phones; ?>" placeholder="<?php echo $entry_naco_admin_phones; ?>" id="input-naco-admin-phones" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-naco-admin-text"><?php echo $entry_naco_admin_text; ?></label>
                  <ul class="col-sm-10 nav nav-tabs">
                    <li class="active"><a href="#tab-naco-admin-text" data-toggle="tab"><?php echo $pane_naco_sms_text; ?></a></li>
                    <li><a href="#tab-naco-admin-template" data-toggle="tab"><?php echo $pane_naco_sms_template; ?></a></li>
                  </ul>
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-10 tab-content">
                    <div class="tab-pane active" id="tab-naco-admin-text">
                      <textarea name="smsassistent_naco_admin_text" rows="5" placeholder="<?php echo $entry_naco_admin_text; ?>" id="input-naco-admin-text" class="form-control"><?php echo $smsassistent_naco_admin_text; ?></textarea>
                    </div>
                    <div class="tab-pane" id="tab-naco-admin-template">
                      <p><?php echo $pane_naco_sms_template_text; ?></p>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-narc">
              <fieldset>
                <legend><?php echo $text_narc_customer; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-narc-customer-status"><?php echo $entry_narc_customer_status; ?></label>
                  <div class="col-sm-10">
                    <select name="smsassistent_narc_customer_status" id="input-narc-customer-status" class="form-control">
                      <?php if ($smsassistent_narc_customer_status) { ?>
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
                  <label class="col-sm-2 control-label" for="input-narc-customer-text"><?php echo $entry_narc_customer_text; ?></label>
                  <ul class="col-sm-10 nav nav-tabs">
                    <li class="active"><a href="#tab-narc-customer-text" data-toggle="tab"><?php echo $pane_narc_sms_text; ?></a></li>
                    <li><a href="#tab-narc-customer-template" data-toggle="tab"><?php echo $pane_narc_sms_template; ?></a></li>
                  </ul>
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-10 tab-content">
                    <div class="tab-pane active" id="tab-narc-customer-text">
                      <textarea name="smsassistent_narc_customer_text" rows="5" placeholder="<?php echo $entry_narc_customer_text; ?>" id="input-narc-customer-text" class="form-control"><?php echo $smsassistent_narc_customer_text; ?></textarea>
                    </div>
                    <div class="tab-pane" id="tab-narc-customer-template">
                      <p><?php echo $pane_narc_sms_template_text; ?></p>
                    </div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend><?php echo $text_narc_admin; ?></legend>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-narc-admin-status"><?php echo $entry_narc_admin_status; ?></label>
                  <div class="col-sm-10">
                    <select name="smsassistent_narc_admin_status" id="input-narc-admin-status" class="form-control">
                      <?php if ($smsassistent_narc_admin_status) { ?>
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
                  <label class="col-sm-2 control-label" for="input-narc-admin-phones"><span data-toggle="tooltip" title="<?php echo $help_narc_admin_phones; ?>"><?php echo $entry_narc_admin_phones; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_narc_admin_phones" value="<?php echo $smsassistent_narc_admin_phones; ?>" placeholder="<?php echo $entry_narc_admin_phones; ?>" id="input-narc-admin-phones" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-narc-admin-text"><?php echo $entry_narc_admin_text; ?></label>
                  <ul class="col-sm-10 nav nav-tabs">
                    <li class="active"><a href="#tab-narc-admin-text" data-toggle="tab"><?php echo $pane_narc_sms_text; ?></a></li>
                    <li><a href="#tab-narc-admin-template" data-toggle="tab"><?php echo $pane_narc_sms_template; ?></a></li>
                  </ul>
                  <div class="col-sm-2">
                  </div>
                  <div class="col-sm-10 tab-content">
                    <div class="tab-pane active" id="tab-narc-admin-text">
                      <textarea name="smsassistent_narc_admin_text" rows="5" placeholder="<?php echo $entry_narc_admin_text; ?>" id="input-narc-admin-text" class="form-control"><?php echo $smsassistent_narc_admin_text; ?></textarea>
                    </div>
                    <div class="tab-pane" id="tab-narc-admin-template">
                      <p><?php echo $pane_narc_sms_template_text; ?></p>
                    </div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="tab-pane" id="tab-logs">
              <fieldset>
                <legend><?php echo $text_logs; ?></legend>
                <div class="form-group">
                  <div class="panel-body">
                    <textarea wrap="off" rows="20" readonly class="form-control"><?php echo $smsassistent_log; ?></textarea>
                  </div>
                </div>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>