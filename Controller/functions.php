<?php

function clean_string($input): Mixed
{

    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Delete javascript code
        '@<[\/\!]*?[^<>]*?>@si', // Delete HTML tag
        '@<style[^>]*?>.*?</style>@siU', // Delete style tag
        '@<![\s\S]*?--[ \t\n\r]*>@', // Delete multiline comments
    );

    $output = preg_replace($search, '', $input);
    return $output;

}

function sanitize($input): Mixed
{

    if (is_array($input)) {
        foreach ($input as $var => $val) {
            $output[$var] = clean_string($val);
        }
    } else {
        $input = clean_string($input);
    }
    return $output;

}
