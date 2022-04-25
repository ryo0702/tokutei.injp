<div class="wrap">
<h1 class="wp-heading-inline"><?php echo esc_html__('Status has changed.', 'nutrail'); ?></h1>
<hr class="wp-header-end">
<div><a href="<?php echo site_url('/wp-admin/admin.php?page=admin_inquery&type=list'); ?>" class="button"><?php echo esc_html__('Return', 'nutrail'); ?></a></div>
</div>
<?php
$thisstatus = null;
$thisstatus = get_post_meta( @$_GET['id'], 'status', true );
if($thisstatus == 'untreated'){
    update_post_meta( @$_GET['id'], 'status', 'treated');
}
else{
    update_post_meta( @$_GET['id'], 'status', 'untreated');
}
?>