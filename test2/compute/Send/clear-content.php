<?php

$handle = fopen('content.json', 'w') or die();
fwrite($handle, '{}');
fclose($handle);

?>