<iframe src="{trigger_remote_image_builder}" hidden="true"></iframe>
<?php
if ($success) {
    echo "Successfully generated {$generated} promo codes";
} else {
    echo "Codes did not successfully generate";
}