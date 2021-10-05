<?php
    $statusId = ${"smsassistent_{$mod}_{$rec}_status_{$osId}"};
    if($statusId != 'sms' && $statusId != 'viber') $statusId = 'disabled';
?>

<legend><?= ${"text_{$mod}_{$rec}"} ?></legend>
<!--поле Уведомления->Активен-->
<div class="form-group">
    <div class="row">
        <div class="col-sm-2 text-right">
            <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-status-<?=$osId; ?>"><?= ${"entry_{$mod}_{$rec}_status"} ?></label>
        </div>
        <div class="col-sm-10">
            <select name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_status_<?=$osId; ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-status-<?=$osId; ?>" class="form-control") onchange="selectOption('<?=$mod; ?>', '<?=$rec; ?>', this.value, <?=$osId; ?>)">
                <option value="disabled" <?php if($statusId == "disabled") { ?> selected="selected" <?php } ?>><?=$text_disabled; ?></option>
                <option value="sms" <?php if($statusId == "sms") { ?> selected="selected" <?php } ?>><?= ${"select_{$mod}_messenger_sms"} ?></option>
                <option value="viber"  <?php if($statusId == "viber") { ?> selected="selected" <?php } ?>><?= ${"select_{$mod}_messenger_viber"} ?></option>
            </select>
        </div>
    </div>
</div>
<!--блок полей Уведомления-->
<div class="form-group">
    <!--скрытые вкладки навигации-->
    <div class="row hidden">
        <div class="col-sm-2 text-right"></div>
        <div class="col-sm-10">
            <ul class="nav nav-tabs ">
                <li <?php if($statusId == 'disabled') { ?> class="active" <?php } ?>><a class="btn disabled" tabindex="-1" href="#tab-<?=$mod; ?>-<?=$rec; ?>-disabled-<?=$osId; ?>" data-toggle="tab"><?=$text_disabled; ?></a></li>
                <li <?php if($statusId == 'sms') { ?> class="active" <?php } ?>><a class="btn disabled" tabindex="-1" href="#tab-<?=$mod; ?>-<?=$rec; ?>-sms-<?=$osId; ?>" data-toggle="tab"><?= ${"select_{$mod}_messenger_sms"} ?></a></li>
                <li <?php if($statusId == 'viber') { ?> class="active" <?php } ?>><a class="btn disabled" tabindex="-1" href="#tab-<?=$mod; ?>-<?=$rec; ?>-viber-<?=$osId; ?>" data-toggle="tab"><?= ${"select_{$mod}_messenger_viber"} ?></a></li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <!--блок Уведомления->Отключено-->
        <div class="tab-pane <?php if($statusId == 'disabled') { ?> active <?php } ?>>" id="tab-<?=$mod; ?>-<?=$rec; ?>-disabled-<?=$osId; ?>">
            <div class="row">
                <div class="col-sm-2 text-right"></div>
                <div class="col-sm-10 alert alert-warning" role="alert">
                    <?= ${"entry_{$mod}_{$rec}_text_disabled"} ?>
                </div>
            </div>
        </div>
        <!--блок Уведомления->SMS-->
        <div class="tab-pane <?php if($statusId == 'sms') { ?> active <?php } ?>" id="tab-<?=$mod; ?>-<?=$rec; ?>-sms-<?=$osId; ?>">
            <!--поле Уведомления->SMS->Отправитель SMS-->
            <div class="row form-group">
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-sender-sms-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_sender_name"} ?>"><?= ${"entry_{$mod}_sender_sms"} ?></label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_sender_sms_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_sender_sms_{$osId}"} ?>" placeholder="<?= ${"entry_{$mod}_sender_sms"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-sender-sms-<?=$osId; ?>" class="form-control" />
                </div>
            </div>
            <!--поле Уведомления->SMS->Номера телефонов-->
            <?php
            if($rec == 'admin')
            { ?>
            <div class="row form-group">
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-phones-sms-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_{$rec}_phones"} ?>"><?= ${"entry_{$mod}_{$rec}_phones"} ?></label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_phones_sms_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_phones_sms_{$osId}"} ?>" placeholder="<?= ${"entry_{$mod}_{$rec}_phones"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-phones-sms-<?=$osId; ?>" class="form-control" />
                </div>
            </div>
            <?php } ?>
            <!--поле Уведомления->SMS->Шаблон SMS сообщения-->
            <div class="row">
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-text-sms-<?=$osId; ?>"><?= ${"entry_{$mod}_text_sms"} ?></label>
                </div>
                <div class="col-sm-10">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-<?=$mod; ?>-<?=$rec; ?>-text-sms-<?=$osId; ?>" data-toggle="tab"><?= ${"pane_{$mod}_sms_text"} ?></a></li>
                        <li><a href="#tab-<?=$mod; ?>-<?=$rec; ?>-template-sms-<?=$osId; ?>" data-toggle="tab"><?= ${"pane_{$mod}_sms_template"} ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-<?=$mod; ?>-<?=$rec; ?>-text-sms-<?=$osId; ?>">
                            <textarea name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_text_sms_<?=$osId; ?>" rows="5" placeholder="<?= ${"entry_{$mod}_text_sms"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-text-sms-<?=$osId; ?>" class="form-control"><?= ${"smsassistent_{$mod}_{$rec}_text_sms_{$osId}"} ?></textarea>
                        </div>
                        <div class="tab-pane" id="tab-<?=$mod; ?>-<?=$rec; ?>-template-sms-<?=$osId; ?>">
                            <p><?= ${"pane_{$mod}_sms_template_text"} ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--блок Уведомления->Viber-->
        <div class="tab-pane <?php if($statusId == 'viber') { ?> active <?php } ?>" id="tab-<?=$mod; ?>-<?=$rec; ?>-viber-<?=$osId; ?>">
            <!--поле Уведомления->Viber->Отправитель Viber-->
            <div class="row form-group">
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-sender-viber-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_sender_name"} ?>"><?= ${"entry_{$mod}_sender_viber"} ?></label>
                </div>
                <div class="col-sm-10">
                    <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_sender_viber_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_sender_viber_{$osId}"} ?>" placeholder="<?= ${"entry_{$mod}_sender_viber"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-sender-viber-<?=$osId; ?>" class="form-control" />
                </div>
            </div>
            <!--поле Уведомления->Viber->Номера телефонов-->
            <?php
            if($rec == 'admin')
            { ?>
                <div class="row form-group">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-phones-viber-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_{$rec}_phones"} ?>"><?= ${"entry_{$mod}_{$rec}_phones"} ?></label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_phones_viber_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_phones_viber_{$osId}"} ?>" placeholder="<?= ${"entry_{$mod}_{$rec}_phones"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-phones-viber-<?=$osId; ?>" class="form-control" />
                    </div>
                </div>
            <?php }
            ?>
            <!--поле Уведомления->Viber->Шаблон Viber сообщения-->
            <div class="row form-group">
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-text-viber-<?=$osId; ?>"><?= ${"entry_{$mod}_text_viber"} ?></label>
                </div>
                <div class="col-sm-10">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-<?=$mod; ?>-<?=$rec; ?>-text-viber-<?=$osId; ?>" data-toggle="tab"><?= ${"pane_{$mod}_viber_text"} ?></a></li>
                        <li><a href="#tab-<?=$mod; ?>-<?=$rec; ?>-template-viber-<?=$osId; ?>" data-toggle="tab"><?= ${"pane_{$mod}_viber_template"} ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-<?=$mod; ?>-<?=$rec; ?>-text-viber-<?=$osId; ?>">
                            <textarea name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_text_viber_<?=$osId; ?>" rows="5" placeholder="<?= ${"entry_{$mod}_text_viber"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-text-viber-<?=$osId; ?>" class="form-control"><?= ${"smsassistent_{$mod}_{$rec}_text_viber_{$osId}"} ?></textarea>
                            <div class="alert alert-danger" role="alert">
                              <?= ${"pane_{$mod}_viber_promo_alert"} ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-<?=$mod; ?>-<?=$rec; ?>-template-viber-<?=$osId; ?>">
                            <p><?= ${"pane_{$mod}_sms_template_text"} ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--поле Уведомления->Viber->Рекламное сообщение-->
            <div class="row form-group">
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-promo-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_promo"} ?>"><?= ${"entry_{$mod}_promo"} ?></label>
                </div>
                <div class="col-sm-10">
                    <div style="width: 20px; float: left">
                        <input type="checkbox" class="form-check-input position-static" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_promo_<?=$osId; ?>" <?php if(${"smsassistent_{$mod}_{$rec}_promo_{$osId}"} == 1) { ?> checked <?php } ?> value=1 id="input-<?=$mod; ?>-<?=$rec; ?>-promo-<?=$osId; ?>" onclick="visibilityBlock(this,'tab-<?=$mod; ?>-<?=$rec; ?>-promo-<?=$osId; ?>')">
                    </div>
                    <div style="float: left"><?= ${"text_{$mod}_promo"} ?></div>
                </div>
            </div>
            <!--блок Уведомления->Viber->Рекламное сообщение-->
            <div <?php if(${"smsassistent_{$mod}_{$rec}_promo_{$osId}"} == 0) { ?> style="display: none" <?php } ?> id="tab-<?=$mod; ?>-<?=$rec; ?>-promo-<?=$osId; ?>">
                <!--поле Уведомления->Viber->Рекламное сообщение->Ссылка на изображение-->
                <div class="row form-group">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-viber-image-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_viber_image"} ?>"><?= ${"entry_{$mod}_viber_image"} ?></label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_viber_image_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_viber_image_{$osId}"} ?>" placeholder="<?= ${"placeholder_{$mod}_viber_image"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-viber-image-<?=$osId; ?>" class="form-control" />
                    </div>
                </div>
                <!--поле Уведомления->Viber->Рекламное сообщение->Название кнопки-->
                <div class="row form-group">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-viber-button_text-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_viber_button_text"} ?>"><?= ${"entry_{$mod}_viber_button_text"} ?></label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_viber_button_text_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_viber_button_text_{$osId}"} ?>" placeholder="<?= ${"entry_{$mod}_viber_button_text"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-viber-button-text-<?=$osId; ?>" class="form-control" />
                    </div>
                </div>
                <!--поле Уведомления->Viber->Рекламное сообщение->Ссылка-->
                <div class="row form-group">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-viber-button_url-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_viber_button_url"} ?>"><?= ${"entry_{$mod}_viber_button_url"} ?></label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_viber_button_url_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_viber_button_url_{$osId}"} ?>" placeholder="<?= ${"placeholder_{$mod}_viber_button_url"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-viber-button-url-<?=$osId; ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <hr />
            <!--поле Уведомления->Viber->Отправлять SMS-->
            <div class="row form-group">
                <div class="col-sm-2 text-right">
                    <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-else-sms-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_else_sms"} ?>"><?= ${"entry_{$mod}_else_sms"} ?></label>
                </div>
                <div class="col-sm-10">
                    <div style="width: 20px; float: left">
                        <input type="checkbox" class="form-check-input position-static" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_else_sms_<?=$osId; ?>" <?php if(${"smsassistent_{$mod}_{$rec}_else_sms_{$osId}"} == 1) { ?> checked <?php } ?> value=1 id="input-<?=$mod; ?>-<?=$rec; ?>-else-sms-<?=$osId; ?>" onclick="visibilityBlock(this,'tab-<?=$mod; ?>-<?=$rec; ?>-else-sms-<?=$osId; ?>')">
                    </div>
                    <div style="float: left"><?= ${"text_{$mod}_else_sms"} ?></div>
                </div>
            </div>
            <!--блок Уведомления->Viber->Отправлять SMS-->
            <div <?php if(${"smsassistent_{$mod}_{$rec}_else_sms_{$osId}"} == 0) { ?> style="display: none" <?php } ?> id="tab-<?=$mod; ?>-<?=$rec; ?>-else-sms-<?=$osId; ?>">
                <!--поле Уведомления->Viber->Отправлять SMS->Отправитель SMS-->
                <div class="row form-group">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-sender-else-sms-<?=$osId; ?>"><span data-toggle="tooltip" title="<?= ${"help_{$mod}_sender_name"} ?>"><?= ${"entry_{$mod}_sender_sms"} ?></label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_sender_else_sms_<?=$osId; ?>" value="<?= ${"smsassistent_{$mod}_{$rec}_sender_else_sms_{$osId}"} ?>" placeholder="<?= ${"entry_{$mod}_sender_sms"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-sender-else-sms-<?=$osId; ?>" class="form-control" />
                    </div>
                </div>
                <!--поле Уведомления->Viber->Отправлять SMS->Шаблон SMS сообщения-->
                <div class="row">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="input-<?=$mod; ?>-<?=$rec; ?>-text-else-sms-<?=$osId; ?>"><?= ${"entry_{$mod}_text_sms"} ?></label>
                    </div>
                    <div class="col-sm-10">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-<?=$mod; ?>-<?=$rec; ?>-text-else-sms-<?=$osId; ?>" data-toggle="tab"><?= ${"pane_{$mod}_sms_text"} ?></a></li>
                            <li><a href="#tab-<?=$mod; ?>-<?=$rec; ?>-template-else-sms-<?=$osId; ?>" data-toggle="tab"><?= ${"pane_{$mod}_sms_template"} ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-<?=$mod; ?>-<?=$rec; ?>-text-else-sms-<?=$osId; ?>">
                                <textarea name="smsassistent_<?=$mod; ?>_<?=$rec; ?>_text_else_sms_<?=$osId; ?>" rows="5" placeholder="<?= ${"entry_{$mod}_text_sms"} ?>" id="input-<?=$mod; ?>-<?=$rec; ?>-text-else-sms-<?=$osId; ?>" class="form-control"><?= ${"smsassistent_{$mod}_{$rec}_text_else_sms_{$osId}"} ?></textarea>
                            </div>
                            <div class="tab-pane" id="tab-<?=$mod; ?>-<?=$rec; ?>-template-else-sms-<?=$osId; ?>">
                                <p><?= ${"pane_{$mod}_sms_template_text"} ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>