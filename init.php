<?php
if (!Route::cache()) {

    Route::set('codegen-generate', 'codegen/generate/<limit>', array(
                'limit' => '\d+'
            ))
            ->defaults(array(
                'controller' => 'codegen',
                'action' => 'generate'
    ));

    Route::set('codegen-get-unprinted', 'codegen/unprinted')
            ->defaults(array(
                'controller' => 'codegen',
                'action' => 'get_unprinted'
    ));
}