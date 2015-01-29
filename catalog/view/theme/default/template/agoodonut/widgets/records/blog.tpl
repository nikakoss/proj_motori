<?php
 if ($records) {
?>

       <div class="blockSidebar">
            <div class="blockSidebarTitle">
                <h3>БЛОГ</h3>
                <a class="linkMore" href="/blog">все статьи</a>
            </div>
            <ul class="blockSidebarContent">
			   <?php foreach ($records as $record) { ?>
                <li class="item">
                    <div class="itemDateWrap clearfix">
                        <div class="itemDate">
                            <div class="number"><?php echo $record['date_available_data'];?></div>
							<div class="monthYear"><?php echo $record['date_available_mes'];?> <?php echo $record['date_available_god'];?></div>
                        </div>
                        <a class="itemComment" href="#"><?php echo $record['comments']; ?></a>
                    </div>
                    <a href="<?php echo $record['href']; ?>" class="itemTitle"><?php echo $record['name']; ?></a>
				    <div class="itemText"><?php echo $record['description']; ?></div>
                </li>
       				<?php } ?>
            </ul>
        </div>
          <?php } ?>