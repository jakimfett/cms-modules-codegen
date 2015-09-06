<?php

if (!Route::cache()) {

    Route::set('codegen-generate', 'codegen/generate/<limit>', array(
                'limit' => '\d+'
            ))
            ->defaults(array(
                'controller' => 'codegen',
                'action' => 'generate'
    ));
}