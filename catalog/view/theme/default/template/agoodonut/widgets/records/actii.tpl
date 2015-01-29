<?php if ($records) { ?>
 
      <?php foreach ($records as $record) {     ?>
       <div class="bannerLeftColumn">
            <div class="blockSidebarTitle">
                <!--h3>Акция</h3-->
                <a class="linkMore" href="actions/">все акции</a>
            </div>
                        <div class="bannerTitle"><a href="<?php echo $record['href']; ?>"><?php echo $record['name']; ?></a></div> 
            <div class="bannerImage"><a href="<?php echo $record['href']; ?>"><img src="<?php echo $record['thumb']; ?>" title="<?php echo $record['name']; ?>" alt="<?php echo $record['name']; ?>" /></a></div>
            <div class="bannerText"><?php echo $record['description']; ?></div>
        </div>
        
          <?php } } ?>