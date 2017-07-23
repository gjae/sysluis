APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:7/V30U5hB7fjsLe77BhM6nrqB19J7Fp7jI/3Yl54Q94=
APP_URL={{$url_app}}

DB_CONNECTION={{$db_driver}}
DB_HOST={{$db_host}}
DB_PORT=3306
DB_DATABASE={{$db_name}}
DB_USERNAME={{$db_user}}
DB_PASSWORD={{$db_password}}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST={{$mail_host}}
MAIL_PORT={{$mail_port}}
MAIL_USERNAME={{$mail_user}}
MAIL_PASSWORD={{$mail_password}}
MAIL_ENCRYPTION={{$mail_encrypt}}

DEFAULT_ACCION = index
IVA = 0.12