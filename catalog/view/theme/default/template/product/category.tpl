<?php //echo  $order; 
echo $header; ?>
<div class="leftColumn"><?php echo $column_left; ?></div>
<div class="rightColumn">
    <?php echo $content_top; ?>
    <div class="blockMain">

        <?php if ($products) { ?>
        <div class="blockMainTitle clearfix product-filter overheght">

            <a class="linkMore" id="compareq" href="<?php echo $compare; ?>" ><?php echo $text_compare; ?></a>

            <ul class="blockSorting"> <li>сортировать по:</li>
                <?php foreach ($sorts as $sortss) { ?>
                <?php if ($sortss['hren'] == "p.price") { ?>
                <li><a class="sorter arrowso" ord="<?php echo $sortss['hrem']; ?>" href="<?php echo $sortss['hren']; ?>"><?php echo $sortss['text']; ?></a></li>
                <?php } else { ?>
                <li><a class="sorter" ord="ASC" id="priceso" href="<?php echo $sortss['hren']; ?>"><?php echo $sortss['text']; ?></a></li>
                <?php } ?>
                <?php } ?>
            </ul>
            <h2><?php echo $heading_title; ?></h2>
        </div>
        <ul class="listProducts clearfix folterprod">
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


        </ul>


        <?php } ?>
        <?php if (!$categories && !$products) { ?>
        <?php echo $text_empty; ?>

        <?php } ?>









        <div class="pagi">
            <?php echo $pagination; ?></div>
        <div style="clear:both"></div>
    </div>
    <br/>
    <?php echo $content_bottom; ?>


  <?php if ($thumb || $description) { ?>
  <div class="contentblock">
    <?php if ($description) { ?>
    <?php echo $description; ?>
    <?php } ?>
  </div>
  <?php } ?>


</div>
<?php echo $footer; ?>