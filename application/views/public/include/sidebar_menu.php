<aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <?php
        if (isset($menu)) {
           foreach ($menu as $data) {
              if ($active_page == $data ['page_name']) {
                 ?>
                 <li class="active"><a
                    href="<?= $data['link'] ?>"> <i class="<?= $data['icon'] ?>"></i>
                    <span><?= $data['label'] ?></span>
                </a></li>
                <?php

            } else {
             ?>
             <li><a href="<?= $data['link'] ?>"> <i
                class="<?= $data['icon'] ?>"></i>
                <span><?= $data['label'] ?></span>
            </a></li>
            <?php

        }
    }
}
?>
</ul>
</section>
</aside>
</header>
