      <?php foreach ($products as $product) { ?>
                <li class="itemProduct">
                    <div class="itemWrap">
                        <div class="itemTitle"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                        <?php if ($product['thumb']) { ?>
          <div class="itemPic"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>"></a></div>
<?php } ?>			

			
						
                        <div class="itemDesc"><?php echo $product['description']; ?></div>

                        <div class="itemPrice clearfix">
                            <div class="itemPriceValue"><span> <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
       <?php echo $product['special']; ?>
          <?php } ?></span>руб.</div>
							<div class="itemPriceIcon cupoin" onclick="addToCart(<?php echo $product['product_id']; ?>,$(this).next('.itemCounter').val());"></div>
                            <input class="itemCounter" value="1" type="text">
                        </div>
                    </div>
                    <div class="itemCompare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');">Сравнить</a></div>
                    <div class="itemProductAction greyPct"></div>
                </li>
    <?php } ?>