<?php
echo '<div class="wrap">';
echo '<h2>テーマインポート</h2>';
echo '<p>インポートした情報には画像などのファイルURLが含まれる可能性があります。別サーバにインポートする場合やファイルがなくなっている場合は、再度アップロードし直す必要があります。</p>';

echo '<form method="POST" action="" enctype="multipart/form-data">';
echo '<table class="form-table" role="presentation">';
foreach ($array_adminform as $inpts) {
    echo nutrail_admin_input($inpts);
}
echo '</table>';
echo '<div style="margin-top:20px;"><button type="submit" name="submit" id="submit" class="button button-primary" value="on">インポートする</button></div>';
echo '</form>';

echo '</div>';