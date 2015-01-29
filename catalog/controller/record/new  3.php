        <div class="blockMain">
            <div class="blockMainTitle line clearfix">
                <h2>С этим товаром покупают</h2>
            </div>
            <ul class="listProducts clearfix">
      <?php foreach ($product_soput as $product_sop) { ?>
                <li class="itemProduct">
                    <div class="itemWrap">
                        <div class="itemTitle"><a href="<?php echo $product_sop['href']; ?>"><?php echo $product_sop['name']; ?></a></div>
                        <?php if ($product['thumb']) { ?>
      <div class="image"><a href=""><img src=""  /></a></div>
      <div class="itemPic"><a href="<?php echo $product_sop['href']; ?>"><img src="<?php echo $product_sop['thumb']; ?>" title="<?php echo $product_sop['name']; ?>" alt="<?php echo $product_sop['name']; ?>"></a></div>
<?php } ?>			

			
						
                        <div class="itemDesc"><?php echo $product_sop['description']; ?></div>
       
                        <div class="itemPrice clearfix">
                            <div class="itemPriceValue"><span> <?php if (!$product['special']) { ?>
          <?php echo $product_sop['price']; ?>
          <?php } else { ?>
       <?php echo $product_sop['special']; ?>
          <?php } ?></span>руб.</div>
							<div class="itemPriceIcon cupoin" onclick="addToCart(<?php echo $product_sop['product_id']; ?>,$(this).next('.itemCounter').val());"></div>
                            <input class="itemCounter" value="1" type="text">
                        </div>
                    </div>
                    <div class="itemCompare"><a onclick="addToCompare('<?php echo $product_sop['product_id']; ?>');">Сравнить</a></div>
                    <div class="itemProductAction greyPct"></div>
                </li>
    <?php } ?>
  

            </ul>
        </div>