<?php echo $header; ?><?php //echo $column_right; ?>

<div class="leftColumn">
    <?php echo $column_left; ?>
</div>

<div class="rightColumn">
    <div class="blockProduct">
        <div class="blockMain">

            <div class="blockMainTitle clearfix"><h1 style="float:left"><?php echo $heading_title; ?></h1><?php if($recid==17){?>
                <a class="linkMore" style="margin-top:10px" href="#" data-reveal-id="AskQuestionModal" data-animation="fadeAndPop">задать вопрос</a>
                <?php }?></div>

            <div class="blockContent">

                <?php echo $description; ?>
            </div>
            <?php if ($comment_status) { ?>
            <div class="blockMainTitle line clearfix">
                <!--h2 class="commprav">Комментарии</h2-->
                <span class="commprav">Комментарии</span>
            </div>              

            <div class="comments-pmp" id="commhere" ></div>
            <?php } ?>

            <?php
            if ($comment_status) { ?>
            <div class="tab-contentssss">
            </div>
            <?php } ?>

        </div>

        <?php echo $content_bottom; ?>
    </div></div>        

<?php if($recid==17){?>
<div id="AskQuestionModal" class="reveal-modal">
    <div id="faqsuccess">
        <h2>Задайте свой вопрос и мы обязательно Вам ответим</h2>
        <form id="SingUpForm" class="clearfix" action="#">
            <div><label><input type="text" placeholder="Имя" name="faname" id="faname"/></label></div>
            <div><label><input type="text" placeholder="E-mail"name="famail" id="famail"/></label></div>
            <div><label><textarea placeholder="Ваш вопрос"name="famess" id="famess" ></textarea></label></div>
            <input class="submit" type="submit" value="отправить" id="askquest" />
        </form></div>
    <a class="close-reveal-modal"></a>
</div>
<?php }?>
        

<?php echo $footer; ?>