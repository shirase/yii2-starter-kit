<?php
exec('ln -s ../app/frontend/web/assets assets');
exec('ln -s ../app/frontend/web/bundle bundle');
exec('ln -s ../app/frontend/web/ckeditor ckeditor');
exec('ln -s ../app/frontend/web/css css');
exec('ln -s ../app/frontend/web/data data');
exec('ln -s ../app/frontend/web/img img');
exec('ln -s ../app/frontend/web/js js');
exec('ln -s ../app/frontend/web/svg svg');

exec('ln -s ../app/backend/web admin');
exec('ln -s ../app/storage/web storage');