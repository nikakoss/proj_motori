<?php echo $header; ?>
<div class="leftColumn"><?php echo $column_left; ?></div>
<div class="rightColumn">

    <div class="blockMain">
        <div class="blockProduct">
            <div class="productTitle"><?php echo $heading_title; ?></div>
            <div class="productParam clearfix">
                <div class="productParamLeft">
                    <div class="productGallery clearfix">
                        <div class="productGalleryWrap">
                            <div class="productPhotoBig">
                                <?php if ($thumb) { ?>
                                <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
                                <?php } ?>
                            </div>

                            <div class="itemRating clearfix">
                                <a class="itemRatingAmont otzivclick" href="#">отзывы</a>
                            </div>
                            <div class="productMarking">Артикул: <?php echo $model; ?></div>
                        </div>
                        <div class="productPhotosWrap" data-id="#blockBigPhoto">
                            <a style="display: block;" class="prevButton control" href="#"></a>
                            <div class="caroufredsel_wrapper">
                                <ul  id="productPhotos" class="clearfix">


                                    <?php if ($images) { ?>

                                    <?php foreach ($images as $image) { ?>
                                    <li class="item">
                                        <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox itemLink">
                                            <img class="itemPhoto" src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                                        </a></li>
                                    <?php } ?>

                                    <?php } ?>


                                </ul></div>
                            <a style="display: block;" class="nextButton control" href="#"></a>




                        </div>
                    </div>
                </div>
                <div class="productParamRight">
                    <p class="har">Характеристики</p>
                    <ul class="tableProduct">
                        <?php  $delim = $this->config->get('filterpro_setting');?>
                        <?php foreach ($attribute_groups as $attribute_group) { ?>
                        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>


                        <li class="tableItem clearfix">
                            <span class="firstCol"><?php echo $attribute['name']; ?></span>
                            <span class="rt"><?php echo  implode("  ",explode($delim['attr_delimeter'], $attribute['text']));?></span>
                        </li>

                        <?php } ?>

                        <?php } ?>

                    </ul>
                    <div class="productWarranty">
                        <?php if ($waranty) { ?>
                        <span class="warrantyText">Гарантия</span>
                        <span class="warrantyValue"><?php echo $waranty; ?></span>
                        <span class="warrantyText">год<?php if($waranty>1){?>а<?php } ?></span>

                        <?php } ?>
                    </div>
                    <div class="productPrice clearfix">
                        <a class="priceButton">в корзину</a>
                        <input name="quantity" class="itemCounter" value="1" type="text">
                        <div class="priceValue">
                            <div class="priceCurrent"><span> <?php if ($price) {echo $price; }?></span>руб.</div>
                            <div class="priceOld"><?php if ($price && $special ) { ?> <span><?php echo $special; ?></span>руб.<?php }?></div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="product-info">
                <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                <?php if ($options) { ?>




                <?php foreach ($options as $option) { ?>
                <?php if ($option['type'] == 'select') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <div class="optname"><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                        <?php } ?><?php echo $option['name']; ?></div>
                    <select name="option[<?php echo $option['product_option_id']; ?>]">
                        <option value=""><?php echo $text_select; ?></option>
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                        <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                            <?php if ($option_value['price']) { ?>
                            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                            <?php } ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'radio') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <div class="optname"><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                        <?php } ?><?php echo $option['name']; ?></div>
                    <?php foreach ($option['option_value'] as $option_value) { ?>
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                    <label class="labelRadio" for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                        <?php } ?>
                    </label>

                    <?php } ?>
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'checkbox') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <div class="optname"><?php if ($option['required']) { ?>
                        <span class="required">*</span>
                        <?php } ?><?php echo $option['name']; ?></div>
                    <?php foreach ($option['option_value'] as $option_value) { ?>
                    <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                    <label class="labelCheckbox" for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                        <?php } ?>
                    </label>

                    <?php } ?>
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'image') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?></b><br />
                    <table class="option-image">
                        <?php foreach ($option['option_value'] as $option_value) { ?>
                        <tr>
                            <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
                            <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
                            <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                    <?php if ($option_value['price']) { ?>
                                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                    <?php } ?>
                                </label></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'text') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?></b><br />
                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'textarea') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?></b><br />
                    <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'file') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?>:</b><br />
                    <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
                    <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'date') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?>:</b><br />
                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'datetime') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?>:</b><br />
                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
                </div>

                <?php } ?>
                <?php if ($option['type'] == 'time') { ?>
                <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                    <?php if ($option['required']) { ?>
                    <span class="required">*</span>
                    <?php } ?>
                    <b><?php echo $option['name']; ?>:</b><br />
                    <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
                </div>

                <?php } ?>
                <?php } ?>
                <div style="clear:both"> </div>
            </div>
            <?php } ?>


            <div class="productDescr">
                <div class="descrTitle">Описание</div>
                <div class="descrText">
                    <?php echo $description; ?>
                </div>
            </div>
            <div class="productAccordion">
                <?php if($videolink){?> 
                <div class="accordionTitle">Видео<span class="accordionIcon"></span></div>
                <div class="accordionText" style="display: none;">
                    <div class="wrapVideo">

                        <iframe width="710" height="399" src="http://www.youtube.com/embed<?php echo substr ($videolink,strrpos($videolink, '/')); ?>" frameborder="0" allowfullscreen></iframe>

                    </div>
                </div><?php } ?>
                <div class="accordionTitle otzivi">Отзывы<span class="accordionIcon"></span></div>
                <div class="accordionText" id="otzivvisibl" style="display: none;">

                    <div id="commprod">

                    </div>
                    <div class="commentsLinks clearfix">
                        <script type="text/javascript">(function() {
                            if (window.pluso)if (typeof window.pluso.start == "function") return;
                            if (window.ifpluso==undefined) { window.ifpluso = 1;
                            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                            s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                            var h=d[g]('body')[0];
                            h.appendChild(s);
                        }})();</script>
                        <div class="pluso" data-background="#ebebeb" data-options="medium,square,line,horizontal,nocounter,theme=06" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir"></div>

                    </div>
                </div>
            </div>
            <div class="itemProductAction new"></div>
        </div>
    </div>

	
	
	<?php if($products) { ?>  <div class="blockMain slideRunner">
    <div class="blockMainTitle clearfix">
        <h2>С этим товаром покупают</h2>
        <div class="slideRunnerControl"></div>
    </div>
    <ul class="listProducts slideRunnerList clearfix">
        <?php foreach ($products as $product) { ?>
        <li class="itemProduct">
            <div class="itemWrap">
                <div class="itemTitle"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                <div class="itemPic">
                    <a href="<?php echo $product['href']; ?>">
                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"/>
                    </a>
                </div>
                <div class="itemDesc"><?php echo $product['description']; ?></div>

                <div class="itemPrice clearfix">
                    <div class="itemPriceValue"><span>
                            <?php if (!$product['special']) { ?>
                            <?php echo $product['price']; ?>
                            <?php } else { ?>
                            <?php echo $product['special']; ?>
                            <?php } ?>

                        </span>руб.</div>
                    <form>
                        <div class="itemPriceIcon cupoin" title="добавить в корзину" onclick="addToCart(<?php echo $product['product_id']; ?>,$(this).next('.itemCounter').val());"></div>
                        <input class="itemCounter" id="polusharie<?php echo $product['product_id']; ?>" type="text" value="1"/>
                    </form>
                </div>
            </div>
            <div class="itemCompare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>', $(this));">Сравнить</a></div>
            <div class="itemProductAction new"></div>
        </li>
        <?php } ?>
    </ul>
        </div>
                      <?php } ?>


	<?php if($product_soput) { ?>  <div class="blockMain slideRunner">
    <div class="blockMainTitle clearfix">
        <h2>Рекомендуем</h2>
        <div class="slideRunnerControl"></div>
    </div>
    <ul class="listProducts slideRunnerList clearfix">
        <?php foreach ($product_soput as $product_sop) { ?>
        <li class="itemProduct">
            <div class="itemWrap">
                <div class="itemTitle"><a href="<?php echo $product_sop['href']; ?>"><?php echo $product_sop['name']; ?></a></div>
                <div class="itemPic">
                    <a href="<?php echo $product_sop['href']; ?>">
                        <img src="<?php echo $product_sop['thumb']; ?>" alt="<?php echo $product_sop['name']; ?>"/>
                    </a>
                </div>
                <div class="itemDesc"><?php echo $product_sop['description']; ?></div>

                <div class="itemPrice clearfix">
                    <div class="itemPriceValue"><span>
                            <?php if (!$product_sop['special']) { ?>
                            <?php echo $product_sop['price']; ?>
                            <?php } else { ?>
                            <?php echo $product_sop['special']; ?>
                            <?php } ?>

                        </span>руб.</div>
                    <form>
                        <div class="itemPriceIcon cupoin" title="добавить в корзину" onclick="addToCart(<?php echo $product_sop['product_id']; ?>,$(this).next('.itemCounter').val());"></div>
                        <input class="itemCounter" id="polusharie<?php echo $product_sop['product_id']; ?>" type="text" value="1"/>
                    </form>
                </div>
            </div>
            <div class="itemCompare"><a onclick="addToCompare('<?php echo $product_sop['product_id']; ?>', $(this));">Сравнить</a></div>
            <div class="itemProductAction new"></div>
        </li>
        <?php } ?>
    </ul>
        </div>
                      <?php } ?>



    <?php echo $content_bottom; ?>

</div>
<script type="text/javascript"><!--
    $(document).ready(function() {
    $('.colorbox').colorbox({
    overlayClose: true,
    opacity: 0.5,
    rel: "colorbox"
    });
    });
    $('.priceButton').bind('click', function() {
    $.ajax({
    url: 'index.php?route=checkout/cart/add',
    type: 'post',
    data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea , input.itemCounter'),
    dataType: 'json',
    success: function(json) {
    $('.success, .warning, .attention, information, .error').remove();

    if (json['error']) {
    if (json['error']['option']) {
    for (i in json['error']['option']) {
    $('#option-' + i).prepend('<span class="error">выберите</span>');
    }
    }
    } 

    if (json['success']) {
    $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

    $('.success').fadeIn('slow');

    $('#cart-total').html(json['total']);

    $('html, body').animate({ scrollTop: 0 }, 'slow'); 
    }    
    }
    });
    });
//--></script> 

<?php echo $footer; ?>