<?php  if ($records) {  ?>
  <div class="blockSidebar">
            <div class="blockSidebarTitle">
                <!--h3>НОВОСТИ</h3-->
                <a class="linkMore" href="/news">все новости</a>
            </div>
            <ul class="blockSidebarContent">
                            <?php foreach ($records as $record) { ?>
                <li class="item">
                    <a href="<?php echo $record['href']; ?>" class="itemTitle"><?php echo $record['name']; ?></a>
                    <div class="itemText"><?php echo $record['description']; ?></div>
                </li>
     <?php } ?>
            </ul>
        </div> 
                <?php } ?>