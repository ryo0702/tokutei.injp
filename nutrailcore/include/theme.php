<?php
function nutrail_attr($attributes = array(), $args = array())
{
    $output = '';

    // Cycle through attributes, build tag attribute string.
    foreach ($attributes as $key => $value) {

        if (!$value) {
            continue;
        }

        if (true === $value) {
            $output .= esc_html($key).' ';
        } else {
            $output .= sprintf('%s="%s" ', esc_html($key), esc_attr($value));
        }
    }

    $output = apply_filters("nutrail_attr_output", $output, $attributes, $args);

    return trim($output);
}

function nutrail_is_amp()
{
    return function_exists('amp_is_request') && amp_is_request();
}

function nutrail_background_attr($class, $media, $attr = [])
{
    $attr = wp_parse_args($attr, [
        'class' => $class,
        'style' => null,
    ]);

    if (!empty($media['url'])) {
        $attr['style'] = wp_parse_args($attr['style'], [
            'background-image'    => 'url('.$media['url'].')',
            'background-size'     => 'cover',
            'background-position' => 'center center',
        ]);
        if (strpos($attr['class'], 'parallax-window') !== false) {
            if (!nutrail_is_amp()) {
                unset($attr['style']['background-image']);
                unset($attr['style']['background-size']);

                $attr['data-image-src']      = $media['url'];
                $attr['data-parallax']       = 'scroll';
                $attr['data-position']       = $attr['style']['background-position'];
                $attr['style']['background'] = 'transparent';
            }
        } elseif (@$GLOBALS['array_config_common']['lazyload']) {
            unset($attr['style']['background-image']);

            $attr['class']   .= ' lazyload';
            $attr['data-bg'] = $media['url'];
        }
    }

    $attr['style'] = add_style($attr['style'], true);

    return nutrail_attr($attr);
}

function nutrail_print_schema()
{
    if (!empty($GLOBALS['array_config_schema'])) {
        $schema = wp_json_encode($GLOBALS['array_config_schema']);
        $schema = _wp_specialchars($schema, ENT_NOQUOTES, 'UTF-8', true);
        echo '<script type="application/ld+json">'.$schema.'</script>';
    }
}

function nutrail_webfont()
{
    return array(
        'Noto+Sans+JP:300,400,500,700,900'  => 'Noto Sans JP',
        'Noto+Serif+JP:300,400,500,700,900' => 'Noto Serif JP',
    );
}

function add_class($array = null)
{
    $return = null;
    if (!empty($array) and is_array($array)) {
        foreach ($array as $val) {
            if (!empty($val) and !is_array($val)) {
                $return .= @$val.' ';
            }
        }
        $return = rtrim($return);
    } elseif (!empty($array)) {
        $return = $array;
    }

    if (!empty($return)) {
        $return = ' class="'.$return.'"';
    }

    return $return;
}

function add_style($array = null, $value = false)
{
    $return = null;

    if (!empty($array) and is_array($array)) {
        foreach ($array as $key => $val) {
            $return .= $key.':'.$val.';';
        }
    } elseif (!empty($array)) {
        $return = $array;
    }

    if (!empty($return)) {
        $return = $value ? $return : ' style="'.$return.'"';
    }

    return $return;
}

function add_style_bgset($array = null)
{
    $style_array = null;

    if (!empty($array) and is_array($array)) {
        if (!empty($array['background-color'])) {
            $style_array['background-color'] = $array['background-color'];
        }
        if (!empty($array['background-image']['url'])) {
            $style_array['background-image'] = 'url(\''.$array['background-image']['url'].'\')';
        }
        if (!empty($array['background-position'])) {
            $style_array['background-position'] = $array['background-position'];
        }
        if (!empty($array['background-repeat'])) {
            $style_array['background-repeat'] = $array['background-repeat'];
        }
        if (!empty($array['background-attachment'])) {
            $style_array['background-attachment'] = $array['background-attachment'];
        }
        if (!empty($array['background-size'])) {
            $style_array['background-size'] = $array['background-size'];
        }
    }

    return $style_array;
}

function add_address($pref = null, $city = null, $street = null, $build = null, $wrap_start = null, $wrap_end = null)
{
    $return = null;
    if (!empty($pref)) {
        $return .= $pref;
    }
    if (!empty($city)) {
        $return .= $city;
    }
    if (!empty($street)) {
        $return .= $street;
    }
    if (!empty($build)) {
        $return .= $build;
    }
    if (!empty($return) and !empty($wrap_start) and !empty($wrap_end)) {
        $return = $wrap_start.$return.$wrap_end;
    }

    return $return;
}

function get_media($media = null, $size = 'post-thumbnail', $attr = [])
{
    global $post;

    if ($media == 'post' && has_post_thumbnail($post)) {
        return get_the_post_thumbnail($post, $size, $attr);
    }

    if (empty($media['url'])) {
        $media = [
            'url'    => get_theme_file_uri('dist/images/nophoto.png'),
            'width'  => 631,
            'height' => 407,
            'alt'    => 'Placeholder',
        ];
    }

    $media        = wp_parse_args($attr, $media);
    $media['src'] = $media['url'];

    if (@$GLOBALS['array_config_common']['lazyload']) {
        $media['src']      = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
        $media['data-src'] = $media['url'];
        if (!isset($media['class'])) {
            $media['class'] = 'lazyload';
        } else {
            $media['class'] .= ' lazyload';
        }
    } else {
        $media['loading'] = 'lazy';
    }

    unset($media['id']);
    unset($media['url']);
    unset($media['thumbnail']);
    unset($media['description']);

    $attr = array_map('esc_attr', $media);
    $html = rtrim("<img");

    foreach ($attr as $name => $value) {
        $html .= " $name=".'"'.$value.'"';
    }
    $html .= ' />';

    return $html;
}