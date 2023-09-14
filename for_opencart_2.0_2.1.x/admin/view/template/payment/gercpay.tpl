<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?>
    <li>
      <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    </li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>

  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-gercpay" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
           class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <h1><i class="fa fa-credit-card"></i> <?php echo $heading_title; ?></h1>
    </div>
  </div>

  <div class="container-fluid">
    <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-gercpay"
            class="form-horizontal">

        <div class="form-group">
          <label class="col-sm-4 control-label" for="gercpay_status">
            <span data-toggle="tooltip" title="<?php echo $help_status; ?>"><?php echo $entry_status; ?></span>
          </label>
          <div class="col-sm-8">
            <select name="gercpay_status" id="gercpay_status" class="form-control">
              <?php $st0 = $st1 = "";
                if ( $gercpay_status == 0 ) {
                 $st0 = 'selected="selected"';
                } else {
                  $st1 = 'selected="selected"';
                }
              ?>
              <option value="1" <?php echo $st1 ?> ><?php echo $text_enabled; ?></option>
              <option value="0" <?php echo $st0 ?> ><?php echo $text_disabled; ?></option>
            </select>
          </div>
        </div>

        <div class="form-group required">
          <label class="col-sm-4 control-label" for="gercpay_merchant">
            <span data-toggle="tooltip" title="<?php echo $help_merchant; ?>"><?php echo $entry_merchant; ?></span>
          </label>
          <div class="col-sm-8">
            <input type="text" name="gercpay_merchant" id="gercpay_merchant"
                   value="<?php echo $gercpay_merchant; ?>" class="form-control"/>
            <?php if ($error_merchant) { ?>
              <div class="text-danger"><?php echo $error_merchant; ?></div>
            <?php } ?>
          </div>
        </div>

        <div class="form-group required">
          <label class="col-sm-4 control-label" for="gercpay_secretkey">
            <span data-toggle="tooltip" title="<?php echo $help_secretkey; ?>"><?php echo $entry_secretkey; ?></span>
          </label>
          <div class="col-sm-8">
            <input type="text" name="gercpay_secretkey" id="gercpay_secretkey"
                   value="<?php echo $gercpay_secretkey; ?>" class="form-control"/>
            <?php if ($error_secretkey) { ?>
              <div class="text-danger"><?php echo $error_secretkey; ?></div>
            <?php } ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label" for="gercpay_currency"><?php echo $entry_currency; ?></label>
          <div class="col-sm-8">
            <select name="gercpay_currency" id="gercpay_currency" class="form-control">
              <?php foreach ($currencies as $currency) {
                      $st = ($currency['code'] == $gercpay_currency) ? ' selected="selected" ' : "";
              ?>
                <option value="<?php echo $currency['code']; ?>" <?= $st ?> ><?php echo $currency['title']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label" for="gercpay_order_status_id">
            <span data-toggle="tooltip" title="<?php echo $help_order_status; ?>"><?php echo $entry_order_status; ?></span>
          </label>
          <div class="col-sm-8">
            <select name="gercpay_order_status_id" id="gercpay_order_status_id" class="form-control">
              <?php foreach ($order_statuses as $order_status) {
                $st = ($order_status['order_status_id'] == $gercpay_order_status_id) ? ' selected="selected" ' : ""; ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" <?= $st ?> ><?php echo $order_status['name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label" for="gercpay_order_reverse_status_id">
            <span data-toggle="tooltip" title="<?php echo $help_order_reverse_status; ?>"><?php echo $entry_order_reverse_status; ?></span>
          </label>
          <div class="col-sm-8">
            <select name="gercpay_order_reverse_status_id" id="gercpay_order_reverse_status_id" class="form-control">
              <?php foreach ($order_statuses as $order_status) {
                      $st = ($order_status['order_status_id'] == $gercpay_order_reverse_status_id) ? ' selected="selected" ' : "";
              ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" <?= $st ?> ><?php echo $order_status['name']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group required">
          <label class="col-sm-4 control-label" for="gercpay_approve_url">
            <?php echo $entry_approve_url; ?>
          </label>
          <div class="col-sm-8">
            <input type="text" name="gercpay_approve_url" id="gercpay_approve_url"
                   value="<?php echo $gercpay_approve_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_approve_url ?></span>
            <?php if ($error_approve_url) { ?>
            <div class="text-danger"><?php echo $error_approve_url; ?></div>
            <?php } ?>
          </div>
        </div>

        <div class="form-group required">
          <label class="col-sm-4 control-label" for="gercpay_decline_url">
            <?php echo $entry_decline_url; ?>
          </label>
          <div class="col-sm-8">
            <input type="text" name="gercpay_decline_url" id="gercpay_decline_url"
                   value="<?php echo $gercpay_decline_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_decline_url ?></span>
            <?php if ($error_decline_url) { ?>
            <div class="text-danger"><?php echo $error_decline_url; ?></div>
            <?php } ?>
          </div>
        </div>

        <div class="form-group required">
          <label class="col-sm-4 control-label" for="gercpay_cancel_url">
            <?php echo $entry_cancel_url; ?>
          </label>
          <div class="col-sm-8">
            <input type="text" name="gercpay_cancel_url" id="gercpay_cancel_url"
                   value="<?php echo $gercpay_cancel_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_cancel_url ?></span>
            <?php if ($error_cancel_url) { ?>
            <div class="text-danger"><?php echo $error_cancel_url; ?></div>
            <?php } ?>
          </div>
        </div>

        <div class="form-group required">
          <label class="col-sm-4 control-label" for="gercpay_callback_url">
            <?php echo $entry_callback_url; ?>
          </label>
          <div class="col-sm-8">
            <input type="text" name="gercpay_callback_url" id="gercpay_callback_url"
                   value="<?php echo $gercpay_callback_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_callback_url ?></span>
            <?php if ($error_callback_url) { ?>
            <div class="text-danger"><?php echo $error_callback_url; ?></div>
            <?php } ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label" for="gercpay_language">
            <span data-toggle="tooltip" title="<?php echo $help_language; ?>"><?php echo $entry_language; ?></span>
          </label>
          <div class="col-sm-8">
            <select name="gercpay_language" id="gercpay_language" class="form-control">
              <?php foreach ($allowed_payment_page_locales as $payment_page_locale) {
                      $st = ($payment_page_locale == $gercpay_language) ? ' selected="selected" ' : "";
              ?>
              <option value="<?php echo $payment_page_locale; ?>" <?= $st ?> ><?php echo mb_strtoupper($payment_page_locale); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-4 control-label" for="gercpay_sort_order">
            <span data-toggle="tooltip" title="<?php echo $help_sort_order; ?>"><?php echo $entry_sort_order; ?></span>
          </label>
          <div class="col-sm-4">
            <input type="text" name="gercpay_sort_order" id="gercpay_sort_order"
                   value="<?php echo $gercpay_sort_order; ?>" class="form-control"/>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>


<?php echo $footer; ?>