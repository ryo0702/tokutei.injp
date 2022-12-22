<?php
$thisid = null;
$thisid = $_GET['id'];
?>
<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo get_the_title($thisid); ?></h1>
    <hr class="wp-header-end">

    <?php
    $thispostarray = get_post_meta($thisid, 'content', true);
    if (!empty($thispostarray['content']) && is_array(@$thispostarray['content'])) {
        echo '<table>';
        foreach ($thispostarray['content'] as $key => $value) {
            echo '<tr>';
            echo '<th>'.@$value['label'].'</th><td>'.nl2br(@$value['value']).'</td>';
            echo '</tr>';
        }
        echo '<table>';
    }

    ?>

</div>