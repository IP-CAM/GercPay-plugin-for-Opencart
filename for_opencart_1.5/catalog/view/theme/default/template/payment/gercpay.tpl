<form action="<?php echo $action ?>" method="post" id="payments">
    <?php
    foreach ($fields as $k => $v) {
      if (is_array($v)) {
        foreach ($v as $vv) {
          echo "<input type=\"hidden\" name=\"{$k}[]\" value=\"{$vv}\"/>";
        }
      } else {
        echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\"/>";
      }
    }
    ?>

    <div class="buttons">
        <div class="pull-right">
            <input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm"
                   data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"/>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#button-confirm").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: 'index.php?route=payment/gercpay/confirm',
                success: function () {
                    $('#payments').submit();
                }
            });
        });
    });
</script>
