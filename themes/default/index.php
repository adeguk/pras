<?php echo theme_view('_header'); ?>
<?php echo theme_view('_sitenav'); ?>
<div class="container"> <!-- Start of Main Container -->

    <?php
        echo Template::message();
        echo isset($content) ? $content : Template::yield();
    ?>
</div>
<?php echo theme_view('_footer'); ?>