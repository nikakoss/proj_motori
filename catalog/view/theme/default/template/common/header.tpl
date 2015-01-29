<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $title; ?></title>
    <base href="http://motori.su/" /><?php //echo $base; ?>
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <?php } ?>
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $og_url; ?>" />
    <?php if ($og_image) { ?>
    <meta property="og:image" content="<?php echo $og_image; ?>" />
    <?php } else { ?>
    <meta property="og:image" content="<?php echo $logo; ?>" />
    <?php } ?>
    <meta property="og:site_name" content="<?php echo $name; ?>" />
    <?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon" />
    <?php } ?>
    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
    <?php foreach ($styles as $style) { ?>
    <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>


    <script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
    <link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
    <script type="text/javascript" src="catalog/view/javascript/common.js"></script>

    <?php foreach ($scripts as $script) { ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script>
    <?php } ?>
    <!--[if IE 7]> 
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
    <![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
    <script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('#logo img');
    </script>
    <![endif]-->




    <link rel="stylesheet" href="catalog/view/theme/default/or/js/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="catalog/view/theme/default/or/css/style.css">
    <!--script type="text/javascript" src="catalog/view/theme/default/or/js/jquery-1.7.2.min.jsaa"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/jquery-ui-1.10.3.custom.min.jsaaa"></script>
    <script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.jsaa"></script-->



    <script type="text/javascript" src="catalog/view/theme/default/or/js/css_browser_selector.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/jquery.placeholder.min.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/jquery.reveal.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/jquery.carouFredSel-6.2.1-packed.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/fancybox/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/slideRunner.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/select.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/script.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <script type="text/javascript" src="catalog/view/theme/default/or/js/ie.js"></script>
    <link rel="stylesheet" href="css/ie.css">
    <![endif]-->

    <?php if ($stores) { ?>
    <script type="text/javascript"><!--
        $(document).ready(function() {
        <?php foreach ($stores as $store) { ?>
        $('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
        <?php } ?>
        });
    //--></script>
    <?php } ?>
</head>
<body <?php if ($home == $og_url) { ?> class="mainPage"<?php } ?>>
<header class="header">
    <div class="headerWrapper">
        <div class="headerMenu w1000">
            <nav class="mainMenu">
                <ul>
                    <li class="item"><a class="linkMenu" href="#">Главная</a></li>
                    <li class="item isSubmenu">
                        <a class="linkMenu" href="#" onclick="return false;">Каталог</a>
                        <ul class="submenu">


                            <?php foreach ($categories as $category) { ?>
                            <li class="itemSub">

                                <a class="itemSubTitle" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                <?php if ($category['children']) { ?>

                                <ul class="itemsSubType">
                                    <?php foreach ($category['children'] as $child) { ?>
                                    <li class="itemType"><a class="itemType" href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>

                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </li>
                            <?php } ?>


                        </ul>
                    </li>
                    <li class="item"><a class="linkMenu" href="pricelist">Прайсы</a></li>
                    <li class="item"><a class="linkMenu" href="dostavka.html">Доставка</a></li>
                    <li class="item"><a class="linkMenu" href="oplata.html">Оплата</a></li>
                    <li class="item"><a class="linkMenu" href="faq.html">Вопрос ответ</a></li>
                    <li class="item"><a class="linkMenu" href="o-kompanii.html">О компании</a></li>
                    <li class="item"><a class="linkMenu" href="contact-us">Контакты</a></li>
                    <li class="item"><a class="linkMenu" href="news">Новости</a></li>

                </ul>
            </nav>
            <div class="search">
                <div id="searchForm" class="searchForm">
                    <input type="text" placeholder="поиск по сайту" value="<?php echo $search; ?>" name="search"/>
                    <p> </p>
                </div>
            </div>
            <div class="blockLink">

                <?php if (!$logged) { ?>
                <span class="linkWrap"><a class="link" href="#" data-reveal-id="SignUpModal" data-animation="fadeAndPop">Вход</a></span>
                <span class="linkWrap"><a class="link" href="index.php?route=account/register">Регистрация</a></span>
                <?php } else { ?>
                <span class="linkWrap" style="border:none"><a class="link" href="logout/"> Выход</a></span>
                <?php } ?>



            </div>
        </div>
    </div>
    <div class="headerTopbar w1000 clearfix <?php if ($home == $og_url) { ?> mainPage <?php } ?>">
        <div class="headerLogo">
            <a class="headerLogoLink" href="/">
                <img src="logo.png" alt="Морской волк"/>
            </a>
        </div>
        <div class="headerTopbarWrapper">
            <div class="itemTopbar blockOrder">
                <div class="itemTopbarTitle"><a href="index.php?route=checkout/simplecheckout" class="order">ОФОРМИТЬ</a></div>
                <div class="itemTopbarContent" id="cart-total">
                    <?php echo $cart; ?>
                </div>
            </div>
            <div class="itemTopbar blockContacts">
                <div class="itemTopbarTitle">Контакты<a class="orderCall" href="#" data-reveal-id="OrderCallModal" data-animation="fadeAndPop">заказать звонок</a></div>
                <div class="itemTopbarContent">
                    <div class="phoneTopbar"><span><?php echo $this->config->get('config_telephoneprefix');?></span><?php echo $this->config->get('config_telephone');?></div>
                    <div class="emailTopbar"><?php echo $this->config->get('config_email');?></div>

                </div>
            </div>
            <div class="itemTopbar blockAddress">
                <div class="itemTopbarTitle">Адрес</div>
                <div class="itemTopbarContent"><?php echo $this->config->get('config_address');?></div>
            </div>
        </div>
    </div>
</header>
 <div style="clear:both"> </div>
<div id="notification"></div>
<section class="mainBlock w1000 clearfix">
