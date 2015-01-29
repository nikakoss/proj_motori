<?php if($products) { ?>  <div class="blockMain slideRunner">
    <div class="blockMainTitle clearfix">
        <h2>Рекомендуемые</h2>
        <div class="slideRunnerControl"></div>
        <a class="linkMore" href="/featured">просмотреть все товары</a>
    </div>
    <ul class="listProducts slideRunnerList clearfix">
        <?php foreach ($products as $product) { ?>
        <li class="itemProduct">
            <div class="itemWrap">
                <div class="itemTitle"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                <div class="itemPic"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"/></a></div>
                <div class="itemDesc"><?php echo $product['description']; ?></div>

                <div class="itemPrice clearfix">
                    <div class="itemPriceValue"><span>
                            <?php if (!$product['special']) { ?>
                            <?php echo $product['price']; ?>
                            <?php } else { ?>
                            <?php echo $product['special']; ?>
                            <?php } ?>

                        </span>руб.</div>

                    <div class="itemPriceIcon cupoin" title="добавить в корзину" onclick="addToCart(<?php echo $product['product_id']; ?>,$(this).next('.itemCounter').val());"></div>
                    <input class="itemCounter" id="polusharie<?php echo $product['product_id']; ?>" type="text" value="1"/>

                </div>
            </div>
            <div class="itemCompare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');">Сравнить</a></div>
            <div class="itemProductAction greyPct"></div>
        </li>
        <?php } ?>
    </ul>
        </div>
                      <?php } ?>