<?php
echo password_hash("admin123", PASSWORD_DEFAULT);


UPDATE usuarios SET clave = '$2y$10$CwTycUXWue0Thq9StjUM0uJ8byQn3H.1ErwUVoG5qUqMGd0XewAey' WHERE usuario = 'admin';
