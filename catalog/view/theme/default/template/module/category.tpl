<div class="blockSidebar">
    <!--div class="blockSidebarTitle">
    <h3>Каталог</h3>
    </div-->
    <div class="blockSidebarCatalog">

        <?php foreach ($categories as $category) { ?>
        <div class="itemCatalog">
            <div class="itemCatalogTitle">
                <div class="itemCatalogTitleWrap"><?php echo $category['name']; ?></div>
            </div>
            <?php if ($category['children']) { ?>
            <ul class="listSubCatalog" style="<?php if ($category['category_id'] != $category_id) { ?> display: none;<?php }else{ ?> display: block;<?php } ?>">
                <?php foreach ($category['children'] as $child) { ?>
                <?php if ($child['category_id'] == $child_id) { ?>
                <li class="itemSubCatalog"><a href="<?php echo $child['href']; ?>" class="bldr"><?php echo $child['name']; ?></a></li>
                <?php } else { ?>
                <li class="itemSubCatalog"><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                <?php } ?>

                <?php } ?>
            </ul>
            <?php } ?>
        </div>
        <?php } ?>

    </div>
        </div>