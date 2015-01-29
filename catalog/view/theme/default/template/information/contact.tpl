<?php echo $header; ?>

<div class="leftColumn">
       <?php echo $column_left; ?>
    </div>


<div class="rightColumn">
        <div class="blockMain">
            <div class="contactkMap">

                          <!--script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=ClpVA4v82DrW7oaBT7JeIq3xEBwCrPyW&width=734&height=335"></script-->
                          <script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=Lwt1HFiIpi0CyX_7OHZKQ_D7zZ8lBl4_&width=734&height=335"></script>
        
                          
                         </div>
            <div class="contactWrapper clearfix">
                <div class="contactData">
                    <div class="contactDataTitle">Контактные данные</div>
                    <ul class="contactDataContent">
                        <li class="contactItem">адрес:  <?php echo $address; ?></li>
                        <li class="contactItem"><?php if ($telephoneprefix) {  echo $telephoneprefix;  } if ($telephone) { echo $telephone;  } ?></li>
                        <li class="contactItem"><?php if ($fax) { if ($telephoneprefix) {  echo $telephoneprefix;  echo $fax;}   } ?></li>
                        <li class="contactItem"><?php echo $this->config->get('config_email');?></li>
                    </ul>
                </div>
                <div class="contactForm">
                    <div class="contactFormTitle">Остались вопросы? Напишите нам!</div>
                      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                                                <div class="contform">
                                                <label><input type="text" placeholder="Ваше имя" name="name" value="<?php echo $name; ?>"/></label><?php if ($error_name) { ?> <span class="errorcontact"><?php echo $error_name; ?></span>   <?php } ?>
                                                </div>
                                                <div class="contform">
                                                <label><input type="text" placeholder="Email" name="email" value="<?php echo $email; ?>"></label> 
                                                <?php if ($error_email) { ?>  <span class="errorcontact"><?php echo $error_email; ?></span>   <?php } ?>
                                                </div>
                                                <div class="contform"><textarea name="enquiry" cols="40" rows="10" placeholder="Напиши вопрос" style="width: 99%;"><?php echo $enquiry; ?></textarea>
                                                  <?php if ($error_enquiry) { ?> <span class="errorcontact"><?php echo $error_enquiry; ?></span> <?php } ?>
                                                </div>
                                                <div class="captcha contform">
                                                    <img src="index.php?route=information/contact/captcha" alt="" width="121" height="35"/>
                             <label><input type="text" placeholder="Введите код с картинки" name="captcha" value="<?php echo $captcha; ?>" /></label>
                                                            <?php if ($error_captcha) { ?>
    <span class="errorcontact"><?php echo $error_captcha; ?></span>
    <?php } ?>
                                           </div>
                        <input class="submit" type="submit" value="отправить">
                    </form>
                </div>
            </div>
        </div>
    </div>

 <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>