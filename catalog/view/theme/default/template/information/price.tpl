<?php echo $header; ?>
<div class="leftColumn">
      <?php echo $column_left; ?>
    </div>
<div class="rightColumn">
        <div class="blockMain">
            <div class="blockMainTitle line clearfix">
				<h2 style="background: #d7e9ee;">Скачать прайс</h2>
            </div>
            <ul class="table priceTable">
                <li class="tableTitleRow clearfix">
                    <span class="tableTitleCol">Название</span>
                    <span class="tableTitleCol rt">Скачать</span>
                </li>	
				<?php foreach ($products as $product) { ?>
                <li class="tableItem  clearfix">
                    <span class="firstCol"><?php echo $product['name'];?></span>
					<a href="<?php echo $product['link'];?>" class="secondCol rt"></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>  
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>
