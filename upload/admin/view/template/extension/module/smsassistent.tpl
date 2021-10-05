<?=$header; ?><?=$column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-smsassistent" data-toggle="tooltip" title="<?=$button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?=cancel; ?>" data-toggle="tooltip" title="<?=$button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?=$heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach($breadcrumbs as $breadcrumb)
        { ?>
        <li><a href="<?=$breadcrumb['href']; ?>"><?=$breadcrumb['text']; ?></a></li>
        <? }
        ?>
      </ul>
    </div>
  </div>
  <script>
    function selectOption(module, recipient, messenger, id){
      link = 'a[href="#tab-' + module + '-' + recipient + '-' + messenger + '-' + id + '"]';
      $(link).tab('show');
    }
    function visibilityBlock(checkbox, div){
      if ($(checkbox).is(':checked')){
        $('#' + div).show(100);
      } else{
        $('#' + div).hide(100);
      }
    }
  </script>
  <div class="container-fluid">
    <?php if($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?=$error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?=$text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?=$action; ?>" method="post" enctype="multipart/form-data" id="form-smsassistent" class="form-horizontal">
          <!--навигация по разделам-->
          <ul class="col-sm-12 nav nav-tabs" id="settings-tabs">
            <li class="active"><a href="#tab-ms" data-toggle="tab"><?=$pane_ms; ?></a></li>
            <li><a href="#tab-naco" data-toggle="tab"><?=$pane_naco; ?></a></li>
            <li><a href="#tab-narc" data-toggle="tab"><?=$pane_narc; ?></a></li>
            <li><a href="#tab-logs" data-toggle="tab"><?=$pane_logs; ?></a></li>
          </ul>
          <div class="col-sm-12 tab-content">
            <!--вкладка Настройки-->
            <div class="tab-pane active" id="tab-ms">
              <fieldset>
                <legend><?=$text_ms_general; ?></legend>
                <!--поле Настройки->Активен-->
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-status"><?=$entry_ms_status; ?></label>
                  <div class="col-sm-10">
                    <select name="smsassistent_ms_status" id="input-ms-status" class="form-control">
                      <?php if($smsassistent_ms_status == 0) { ?>
                      <option value="0" selected="selected"><?=$text_disabled; ?></option>
                      <option value="1"><?=$text_enabled; ?></option>
                      <?php } else { ?>
                      <option value="0"><?=$text_disabled; ?></option>
                      <option value="1" selected="selected"><?=$text_enabled; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <!--поле Настройки->Имя пользователя-->
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-api-username"><?=$entry_ms_api_username; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_api_username" value="<?=$smsassistent_ms_api_username; ?>" placeholder="<?=$entry_ms_api_username; ?>" id="input-ms-api-username" class="form-control" />
                  </div>
                </div>
                <!--поле Настройки->Пароль-->
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-api-password"><span data-toggle="tooltip" title="<?=$help_ms_api_password; ?> https://userarea.sms-assistent.by/api_logs.php"><?=$entry_ms_api_password; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_api_password" value="<?=$smsassistent_ms_api_password; ?>" placeholder="<?=$entry_ms_api_password; ?>" id="input-ms-api-password" class="form-control" />
                  </div>
                </div>
                <!--поле Настройки->Токен-->
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-api-token"><?=$entry_ms_api_or; ?> <?=$entry_ms_api_token; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_api_token" value="<?=$smsassistent_ms_api_token; ?>" placeholder="<?=$entry_ms_api_token; ?>" id="input-ms-api-token" class="form-control" />
                  </div>
                </div>
                <!--поле Настройки->Имя отправителя SMS по-умолчанию-->
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-sender-name-sms"><?=$entry_ms_sender_name_sms; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_sender_name_sms" value="<?=$smsassistent_ms_sender_name_sms; ?>" placeholder="<?=$entry_ms_sender_name_sms; ?>" id="input-ms-sender-name-sms" class="form-control" />
                  </div>
                </div>
                <!--поле Настройки->Имя отправителя Viber по-умолчанию-->
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-sender-name-viber"><?=$entry_ms_sender_name_viber; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_sender_name_viber" value="<?=$smsassistent_ms_sender_name_viber; ?>" placeholder="<?=$entry_ms_sender_name_viber; ?>" id="input-ms-sender-name-viber" class="form-control" />
                  </div>
                </div>
                <!--поле Настройки->Адрес API сервера-->
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-ms-base-url"><span data-toggle="tooltip" title="<?=$help_ms_base_url; ?> https://userarea.sms-assistent.by/api/v1/"><?=$entry_ms_base_url; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="smsassistent_ms_base_url" value="<?=$smsassistent_ms_base_url; ?>" placeholder="<?=$entry_ms_base_url; ?>" id="input-ms-base-url" class="form-control" />
                  </div>
                </div>
              </fieldset>
            </div>
            <!--вкладка Новый статус заказа-->
            <div class="tab-pane " id="tab-naco">
              <fieldset>
                <legend><?=$text_naco_order_status; ?></legend>
                <div class="form-group">
                  <ul class="col-sm-12 nav nav-pills">
                    <?php
                    foreach($order_statuses as $order_status)
                    {
                      $osId = $order_status['order_status_id'];
                      $countStatusOn = 0;
                      $custStat = 'smsassistent_naco_customer_status_' . $osId;
                      $adminStat = 'smsassistent_naco_admin_status_' . $osId;
                      if($$custStat == 'sms') $countStatusOn++;
                      if($$custStat == 'viber') $countStatusOn++;
                      if($$adminStat == 'sms') $countStatusOn++;
                      if($$adminStat == 'viber') $countStatusOn++;
                      ?>
                      <li <?php if($osId == 1) echo 'class="active"'; ?> value=<?=$osId; ?>><a href="#tab-naco-status-<?=$osId; ?>" data-toggle="tab"><?php echo $order_status['name'] ?> (<?=$countStatusOn; ?>)</a></li>
                    <?php } ?>
                  </ul>
                </div>
              </fieldset>
              <div class="col-sm-12 tab-content">
                <!-- навигация по статусам-->
                <?php
                foreach($order_statuses as $order_status)
                {
                  $osId = $order_status['order_status_id'];
                ?>
                <div class="tab-pane <?php if($osId == 1) echo 'active'; ?> }}" id="tab-naco-status-<?=$osId; ?>">
                  <!--блок Уведомления пользователю-->
                  <fieldset>
                    <?php
                      $mod = 'naco';
                      $rec = 'customer';
                      include('smsassistent.message.settings.tpl');
                    ?>
                  </fieldset>
                  <!--блок уведомления менеджеру-->
                  <fieldset>
                    <?php
                      $mod = 'naco';
                      $rec = 'admin';
                      include('smsassistent.message.settings.tpl');
                    ?>
                  </fieldset>
                </div>
                <?
                }
                ?>
              </div>
            </div>
            <!--вкладка Новый пользователь-->
            <div class="tab-pane" id="tab-narc">
              <fieldset>
                <!--narc-customer-id-->
                <!--mod-rec-osId-->
                <?php
                  $mod = 'narc';
                  $rec = 'customer';
                  $osId = 0;
                  include('smsassistent.message.settings.tpl');
                ?>
              </fieldset>
              <fieldset>
                <!--narc-admin-id-->
                <!--mod-rec-osId-->
                <?php
                  $mod = 'narc';
                  $rec = 'admin';
                  $osId = 0;
                  include('smsassistent.message.settings.tpl');
                ?>
              </fieldset>
            </div>
            <!--вкладка Логи-->
            <div class="tab-pane" id="tab-logs">
              <fieldset>
                <legend><?=$text_logs; ?></legend>
                <div class="form-group">
                  <div class="panel-body">
                    <textarea wrap="off" rows="20" readonly class="form-control"><?=$smsassistent_log; ?></textarea>
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
<?=$footer; ?>