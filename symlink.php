<?php
exec('ln -s ../app/frontend/web/assets assets');
exec('ln -s ../app/frontend/web/bundle assets');
exec('ln -s ../app/frontend/web/ckeditor assets');
exec('ln -s ../app/frontend/web/css assets');
exec('ln -s ../app/frontend/web/data assets');
exec('ln -s ../app/frontend/web/img assets');
exec('ln -s ../app/frontend/web/js assets');
exec('ln -s ../app/frontend/web/svg assets');

exec('ln -s ../app/backend/web admin');
exec('ln -s ../app/storage/web storage');