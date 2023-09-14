<?php echo $header; ?>
<style>
    .help { padding-top: 5px }
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a><
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>

  <div class="box">
    <div class="heading">
      <span style="background: url(view/image/payment/gercpay.svg) 0 0 no-repeat !important;">
        <img src="view/image/payment/gercpay.png" alt="GercPay" title="GercPay">
      </span>
      <h1 style="display: inline-block; float: none"><?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
      </div>
    </div>
  </div>

  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td>
            <?php echo $entry_status; ?>
          </td>
          <td>
            <select name="gercpay_status" class="form-control">
              <?php $st0 = $st1 = "";
                    if ( $gercpay_status == 0 ) $st0 = 'selected="selected"';
                    else $st1 = 'selected="selected"'; ?>
              <option value="1" <?php echo $st1 ?> ><?php echo $text_enabled; ?></option>
              <option value="0" <?php echo $st0 ?> ><?php echo $text_disabled; ?></option>
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <span class="required">*</span><?php echo $entry_merchant; ?>
          </td>
          <td>
            <input type="text" name="gercpay_merchant"
                   value="<?php echo $gercpay_merchant; ?>" class="form-control"/>
            <?php if ($error_merchant) { ?>
            <div class="text-danger"><?php echo $error_merchant; ?></div>
            <?php } ?>
          </td>
        </tr>

        <tr>
          <td>
            <span class="required">*</span><?php echo $entry_secretkey; ?>
          </td>
          <td>
            <input type="text" name="gercpay_secretkey" value="<?php echo $gercpay_secretkey; ?>" class="form-control"/>
            <?php if ($error_secretkey) { ?>
            <div class="text-danger"><?php echo $error_secretkey; ?></div>
            <?php } ?></td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_order_status; ?>
          </td>
          <td>
            <select name="gercpay_order_status_id" class="form-control">
              <?php foreach ($order_statuses as $order_status) {
                      $st = ($order_status['order_status_id'] == $gercpay_order_status_id) ? ' selected="selected" ' : "";
              ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" <?= $st ?> ><?php echo $order_status['name']; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_order_reverse_status; ?>
          </td>
          <td>
            <select name="gercpay_order_reverse_status_id" class="form-control">
              <?php foreach ($order_statuses as $order_status) {
                      $st = ($order_status['order_status_id'] == $gercpay_order_reverse_status_id) ? ' selected="selected" ' : "";
              ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" <?= $st ?> ><?php echo $order_status['name']; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_currency; ?>
          </td>
          <td>
            <select name="gercpay_currency" class="form-control">
              <?php foreach ($currencies as $currency) {
                      $st = ($currency['code'] == $gercpay_currency) ? ' selected="selected" ' : "";
              ?>
              <option value="<?php echo $currency['code']; ?>" <?= $st ?> ><?php echo $currency['title']; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_approve_url; ?>
          </td>
          <td>
            <input type="text" name="gercpay_approve_url" value="<?php echo $gercpay_approve_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_approve_url ?></span>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_decline_url; ?>
          </td>
          <td>
            <input type="text" name="gercpay_decline_url" value="<?php echo $gercpay_decline_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_decline_url ?></span>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_cancel_url; ?>
          </td>
          <td>
            <input type="text" name="gercpay_cancel_url" value="<?php echo $gercpay_cancel_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_cancel_url ?></span>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_callback_url; ?>
          </td>
          <td>
            <input type="text" name="gercpay_callback_url" value="<?php echo $gercpay_callback_url; ?>" class="form-control"/>
            <span class="help"><?php echo $help_callback_url ?></span>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_language; ?>
          </td>
          <td>
            <select name="gercpay_language" class="form-control">
              <?php foreach ($allowed_payment_page_locales as $payment_page_locale) {
                      $st = ($payment_page_locale == $gercpay_language) ? ' selected="selected" ' : "";
              ?>
              <option value="<?php echo $payment_page_locale; ?>" <?= $st ?> ><?php echo mb_strtoupper($payment_page_locale); ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>

        <tr>
          <td>
            <?php echo $entry_sort_order; ?>
          </td>
          <td>
            <input type="text" name="gercpay_sort_order" value="<?php echo $gercpay_sort_order; ?>" class="form-control"/>
            <span class="help"><?php echo $help_sort_order ?></span>
          </td>
        </tr>

      </table>
    </form>
  </div>
</div>


<?php echo $footer; ?>
