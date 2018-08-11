<aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <?php
        if (isset($menu)) {
           foreach ($menu as $data) {
            $active = ''; 
            $label = $data['label'];
            $style = "";
            if ($active_page == $data ['page_name']) {
                $active = 'active';             
                $style = "style='color: #3761d6'";   
                $label = "<strong > ".$data['label']." </strong>";
            }
            ?>

            <li class="<?=$active?>"><a
                href="<?= $data['link'] ?>" <?=$style?>> <i class="<?= $data['icon'] ?>"></i>
                <span><?= $label ?></span>
            </a></li>

            <?php
            
        }
    }
    ?>
</ul>
</section>
</aside>
</header>
