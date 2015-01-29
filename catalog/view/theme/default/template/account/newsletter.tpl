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
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td><?php if ($newsletter) { ?>
			<input type="radio" id="newsletyes" name="newsletter" value="1" checked="checked" /> <label class="labelRadio" for="newsletyes"> <?php echo $text_yes; ?>&nbsp;</label>
           
			<input type="radio" id="newsletno" name="newsletter" value="0" /><label class="labelRadio" for="newsletno"> <?php echo $text_no; ?></label>
           
            <?php } else { ?>
			<input type="radio" id="newsletyes" name="newsletter" value="1" /><label class="labelRadio" for="newsletyes"> <?php echo $text_yes; ?>&nbsp;</label>
           
			<input type="radio" id="newsletno" name="newsletter" value="0" checked="checked" /><label class="labelRadio" for="newsletno"> <?php echo $text_no; ?></label>
           
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
