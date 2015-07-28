<?php

if (!Route::cache()) {
    
    Route::set('codegen-generate', 'codegen/generate/<limit>')
            ->defaults(array(
                'controller' => 'codegen',
                'action' => 'generate'
    ));
}