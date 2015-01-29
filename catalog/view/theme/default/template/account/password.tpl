<?php echo $header; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<div class="leftColumn"><?php echo $column_left; ?></div>
<div class="rightColumn">

        <div class="blockMain">
<div class="blockProduct">
<div class="productTitle"><?php echo $heading_title; ?></div>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h2><?php echo $text_password; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="errorred"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="errorred"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <div class="buttons">
<a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a>
     <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
    </div>
  </form>
        </div>   </div>
   

	
	  <?php echo $content_bottom; ?>

</div>


<?php echo $footer; ?>