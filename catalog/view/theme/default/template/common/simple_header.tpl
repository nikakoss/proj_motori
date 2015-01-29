<?php echo $header; ?>
    <?php if (isset($error_warning)) { ?> 
        <?php if ($error_warning) { ?>
            <div class="warning"><?php echo $error_warning; ?></div>
        <?php } ?>
    <?php } ?>
    

	
	<div class="leftColumn">
<?php echo $column_left; ?>

     </div>
	 
	 
	 
	 
	 
	 
	 <div class="rightColumn">    
<?php echo $content_top; ?>
<div class="blockMain">
<div class="blockProduct">
<div class="blockMainTitle line clearfix">
				<h2 style=""><?php echo $heading_title; ?></h2>
            </div>

