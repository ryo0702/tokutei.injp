<?php
$inline_css = '';
$font       = @$GLOBALS['array_config_common']['font'];
$colors     = @$GLOBALS['array_config_common']['colors'];
$webfont    = nutrail_webfont();

if (!empty($font) && !empty($webfont[$font])) {
    $inline_css .= '--font-body: "'.$webfont[$font].'", sans-serif;';
}
if (!empty($colors)) {
    foreach ($colors as $key => $color) {
        if (!empty($color)) {
            if (!is_array($color)) {
                $inline_css .= "--color-{$key}: {$color};";
            } else {
                foreach ($color as $name => $value) {
                    if ($name == 'default') {
                        $inline_css .= "--color-{$key}: {$value};";
                    } else {
                        $inline_css .= "--color-{$key}-{$name}: {$value};";
                    }
                }
            }
        }
    }
}

return !empty($inline_css) ? ':root{'.$inline_css.'}' : '';