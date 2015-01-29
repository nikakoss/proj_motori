<?php echo $header; ?>

<div class="blockMain"><?php echo $content_top; ?>
    <h2 class="comparehead"><?php echo $heading_title; ?></h2>
    <?php if ($products) { ?>
    <table class="compare-info">

        <tbody>
            <tr>
                <td><?php echo $text_name; ?></td>
                <?php foreach ($products as $product) { ?>
                <td class="name">
                    <section class="listProducts">

                        <li class="itemProduct prcompare">
                            <div class="itemWrap">
                                <div class="itemTitle"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                <?php if ($product['thumb']) { ?>
                                <!--div class="image"><a href=""><img src=""  /></a></div-->
                                <div class="itemPic"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>"></a></div>
                                <?php } ?>            

                                <div class="itemDesc"><?php echo $product['description']; ?></div>

                                <div class="itemPrice clearfix">
                                    <div class="itemPriceValue"><span> <?php if (!$product['special']) { ?>
                                        <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                        <?php echo $product['special']; ?>
                                        <?php } ?></span><!--руб.--></div>
                                    <div class="itemPriceIcon cupoin" onclick="addToCart(<?php echo $product['product_id']; ?>,$(this).next('.itemCounter').val());"></div>
                                    <input class="itemCounter" value="1" type="text">
                                </div>
                            </div>
                            <div class="itemdelete"><a class="delhre" href="<?php echo $product['remove']; ?>">Удалить</a></div>
                            <div class="itemProductAction greyPct"></div>
                        </li>

                    </section>

                </td>
                <?php } ?>
            </tr>

        </tbody>
        <?php foreach ($attribute_groups as $attribute_group) { ?>

        <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
        <tbody>
            <tr>
                <td><?php echo $attribute['name']; ?></td>
                <?php foreach ($products as $product) { ?>
                <?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
                <td><?php echo $products[$product['product_id']]['attribute'][$key]; ?></td>
                <?php } else { ?>
                <td></td>
                <?php } ?>
                <?php } ?>
            </tr>
        </tbody>
        <?php } ?>
        <?php } ?>

    </table>

    <?php } else { ?>
    <div class="content"><?php echo $text_empty; ?></div>
    <div class="buttons">
        <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
    </div>
    <?php } ?>
    <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>