<?php
$hashes = [
    'admin' => '$2y$10$vIz6SccCISPUgl4r3qR2K.ZYzBgSSyc/LCAAhig/PG7/TN0Ts8UJG',
    'khachhang' => '$2y$10$Lcr7XWXn8wowyb8vbLWttuYg0hor39bRClsxZvRqyTAxKy5pkh0Ay',
    'kh01' => '$2y$10$5LwenpJ3ROG8S0SU5cK0gevOouoBYR.1hkTVmWrrE0fJlAbKEge7C'
];
foreach ($hashes as $u => $h) {
    if (password_verify('123', $h)) {
        echo "123 is valid for $u\n";
    }
}
