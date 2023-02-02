<?php

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('genxbe/k3-fragments', [
    'options' => [
        'autoPopulate' => false,
        'resourcesPath' => 'resources'
    ],
    'blueprints' => [
        'tabs/fragments' => __DIR__.'/blueprints/tabs/fragments.yml',
    ],
]);
