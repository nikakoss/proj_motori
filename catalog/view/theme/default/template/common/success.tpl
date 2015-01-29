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
  <?php echo $text_message; ?>
  <div class="buttons">
<a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a>
  </div>



        </div>   </div>
   

	
	  <?php echo $content_bottom; ?>

</div>


<?php echo $footer; ?>