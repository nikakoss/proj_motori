<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
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
  
  
  	     
				  <h2 class="accdelimi"><?php echo $text_my_account; ?></h2>

  

	<ul class="accspisok" >
      <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
      <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
      <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
      <!--<li><a href="<?php //echo $wishlist; ?>"><?php //echo $text_wishlist; ?></a></li> -->
    </ul>

			 <h2 class="accdelimi"><?php echo $text_my_orders; ?></h2>

	<ul class="accspdva">
      <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
     <!--  <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>-->
      <?php if ($reward) { ?>
      <!-- <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li> -->
      <?php } ?>
      <!-- <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>-->
      <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
	      </ul>

 <h2 class="accdelimi"><?php echo $text_my_newsletter; ?></h2>

    <ul>
      <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
    </ul>
<br/>
  
  
  
  
  
  
  
  
  
  
  
  
        </div>   </div>
   

	
	  <?php echo $content_bottom; ?>

</div>


<?php echo $footer; ?>