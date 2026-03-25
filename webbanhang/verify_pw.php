<?php
$hash = '$2y$10$vIz6SccCISPUgl4r3qR2K.ZYzBgSSyc/LCAAhig/PG7/TN0Ts8UJG';
if (password_verify('123', $hash)) {
    echo "Password 123 is valid\n";
} else {
    echo "Password 123 is invalid\n";
}
