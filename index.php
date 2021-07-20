<?php

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('genxbe/fragments', [
    'blueprints' => [
        'tabs/fragments' => __DIR__.'/blueprints/tabs/fragments.yml',
    ],
]);

/**
 * Fragments Helper
 * Retreives a given fragment
 */
if (!function_exists("__")) {
    function __($fragment, $placeholders = [])
    {
        return X\Fragments::fragment($fragment, $placeholders);
    }
}
