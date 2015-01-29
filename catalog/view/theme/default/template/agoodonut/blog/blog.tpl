<?php echo $header; ?>

<div class="leftColumn">
    <?php echo $column_left; ?>
</div>
<?php //echo $column_right; ?>

<div class="rightColumn">
    <div class="blockProduct">
        <div class="blockMain">
            <div class="blockMainTitle line clearfix">
                <h2><?php echo $heading_title; ?></h2>
            </div>
            <?php if ($records) { ?>
            <ul class="blockSidebarContent blog">
                <?php foreach ($records as $record) { ?>
                <li class="item clearfix">
                    <a href="<?php echo $record['href']; ?>" class="itemTitle"><?php echo $record['name']; ?></a>
                    <?php if ($record['thumb']) { ?>

                    <a href="<?php echo $record['href']; ?>" class="itemPic"><img src="<?php echo $record['thumb']; ?>" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" /></a>
                    <?php } ?>

                    <div class="itemText"><?php echo $record['description']; ?></div>
                    <div class="itemLinks">
                        <span class="itemDate"><?php echo $record['date_available_data'];?></span>
                        <a class="itemMore" href="<?php echo $record['href']; ?>">подробнее</a>
                        <a class="itemComments" href="<?php echo $record['href']; ?>">комментарии <?php echo $record['comments']; ?></a>
                    </div>
                </li>

                <?php } ?>
            </ul>
            <?php } ?>

            <?php echo $pagination; ?><br/>
        </div>

    </div>

  <?php echo $content_bottom; ?>        </div>
<?php echo $footer; ?>