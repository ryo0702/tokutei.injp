<div class="page_contact">
    <div class="container_s">
        <?php
        if ( have_posts() ) {
           while ( have_posts() ) {
           the_post();
           echo '<div class="page_title"><h1>'.get_the_title().'</h1></div>';
           }
        }
        echo '<div class="page_content">';
        the_content();
        echo '</div>';
        ?>
    </div>
</div>