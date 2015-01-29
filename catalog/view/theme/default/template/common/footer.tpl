</section>
<footer class="footer">
    <div class="footerShad"></div>
    <div class="footerCatalog">

        <div class="w1000">
            <div class="footCatheah">Каталог продукции</div>
            <ul class="footsubmenu">
                <?php foreach ($categories as $category) { ?>
                <li class="itemSub">

                    <a class="itemSubTitle" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                </li>
                <?php } ?>
            </ul>
    </div> </div>


    <div class="w1000 nobgr">
        <nav class="mainMenu footli">
            <ul>
                <li class="item"><a class="linkMenu" href="#">Главная</a></li>
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
            <div id="searchForm2" class="searchForm">
                <input type="text" placeholder="поиск по сайту" value="" name="search"/>
                <p> </p>
            </div>
        </div>
        <div class="blockLink">
            <span class="linkWrap"><a class="link" href="#" data-reveal-id="SignUpModal" data-animation="fadeAndPop">Вход</a></span>
            <span class="linkWrap"><a class="link" href="index.php?route=account/register">Регистрация</a></span>
        </div>
        <div style="clear:both"> </div>
    </div>
    <div class="footerCopyright">
        <div class="footerWrapper w1000 clearfix">   
            <div class="blockCopyRight">
                <div class="nameSite">© 2013, Моторы.су. Все права защищены</div>
                <div class="nameSite">Разработка сайта: студия <a href="http://arsenal-media.net/">Arsenal-Media.net</a></div>
            </div>   
            <div class="blockInfo">
                <div class="blockInfoAddress"><span class="bluesp">Адрес:</span><?php echo $this->config->get('config_address');?></div>
                <div class="blockInfoPhone"><span class="bluesp">Телефон:</span><span><?php echo $this->config->get('config_telephoneprefix');?></span><?php echo $this->config->get('config_telephone');?></div>
            </div>
            <div class="blockSocicon">
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

            <div class="blockMetrica">
                <!-- Yandex.Metrika informer -->
                <a href="http://metrika.yandex.ru/stat/?id=23571100&amp;from=informer"
                    target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/23571100/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                        style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:23571100,lang:'ru'});return false}catch(e){}"/></a>
                <!-- /Yandex.Metrika informer -->




                <!-- Yandex.Metrika counter -->
                <script type="text/javascript">
                    (function (d, w, c) {
                    (w[c] = w[c] || []).push(function() {
                    try {
                    w.yaCounter23571100 = new Ya.Metrika({id:23571100,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
                    } catch(e) { }
                    });

                    var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                    if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f, false);
                    } else { f(); }
                    })(document, window, "yandex_metrika_callbacks");
                </script>
                <noscript><div><img src="//mc.yandex.ru/watch/23571100" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                <!-- /Yandex.Metrika counter -->

            </div>

        </div>
    </div>
    <!-- BEGIN JIVOSITE CODE
    {literal}

    -->
    <!--script type='text/javascript'>
     (function() {
             var widget_id = '150335'; 
             var s = document.createElement('script'); 
             s.type = 'text/javascript'; 
             s.async = true; 
             s.src = '//code.jivosite.com/script/widget/'+widget_id; 
             var ss = document.getElementsByTagName('script')[0]; 
             ss.parentNode.insertBefore(s, ss);
     }
     )();
    </script-->
    <!--
    {/literal}

    END JIVOSITE CODE -->
</footer>
<div id="OrderCallModal" class="reveal-modal">
    <div class="backcallsucces">
        <h2>Оставьте запрос и мы вам перезвоним!</h2>
        <form id="backcallform" class="clearfix">
            <div><label><input type="text" name="fio" id="fio" placeholder="Имя"/></label></div>
            <div><label><input type="text" name="bphone"  id="bphone" placeholder="Телефон"/></label></div>
            <input class="submit" type="submit" id="backcall" value="перезвоните мне"/>
        </form></div>
    <div class="backcallfin"></div>
    <a class="close-reveal-modal"></a>
</div>
<div id="SignUpModal" class="reveal-modal">
    <div id="h_login">  <h2>Вход</h2>

        <div><label><input type="text" placeholder="e-mail" name="email"/></label></div>
        <div><label><input type="password" placeholder="Пароль" name="password"/></label></div>
        <?php  $whme=(isset($this->request->server['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
        $whnuj=$this->url->link('checkout/simplecheckout'); ?>
        <input type="hidden" value="<?php if($whme!=$whnuj){?>1<?php }else{?>2<?php }?>" name="redir" />


        <input class="submit" type="submit" value="войти" onclick="head_login()"/>


    </div>


    <a class="close-reveal-modal"></a>
</div>

    <?php echo $google_analytics; ?>


</body>
</html>