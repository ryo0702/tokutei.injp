<?php
echo '<div class="wrap">';
echo '<h2>テーマセットアップ</h2>';

echo '<form method="POST" action="" enctype="multipart/form-data">';
echo '<table class="form-table" role="presentation">';
foreach ($array_adminform as $inpts) {
    echo nutrail_admin_input($inpts);
}
echo '</table>';
echo '<div style="margin-top:20px;"><button type="submit" name="submit" id="submit" class="button button-primary" value="on">セットアップする</button></div>';
echo '</form>';

echo '</div>';