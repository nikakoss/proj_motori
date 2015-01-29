<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
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
    <p><?php echo $text_email; ?></p>


      <table class="form" border="1">
        <tr>
          <td><?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="" /></td>
		  
		 <td> <input type="submit" value="<?php echo $button_continue; ?>" class="button" /></td>
        </tr>
      </table>

  </form>
  
  
  
        </div>   </div>
   

	
	  <?php echo $content_bottom; ?>

</div>


<?php echo $footer; ?>