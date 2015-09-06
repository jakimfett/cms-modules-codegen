<?php

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=\"{$filename}\"", FALSE);
header("Pragma: no-cache", FALSE);
header("Expires: 0", FALSE);

echo $content;
