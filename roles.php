<?php

$roleCapabilities = array(
    'admin' => array(
        'edit' => true,
        'add' => true,
        'delete' => true
    ),
    'editor' => array(
        'edit' => true,
        'add' => true,
        'delete' => false
    ),
    'viewer' => array(
        'edit' => false,
        'add' => false,
        'delete' => false
    )
);

?>
