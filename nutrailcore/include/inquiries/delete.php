<div class="wrap">
<h1 class="wp-heading-inline"><?php echo esc_html__('It was erased', 'nutrail'); ?></h1>
<hr class="wp-header-end">
<div><a href="<?php echo site_url('/wp-admin/admin.php?page=admin_inquery&type=list'); ?>" class="button"><?php echo esc_html__('Return', 'nutrail'); ?></a></div>
</div>
<?php
wp_delete_post( @$_GET['id'] );
?>