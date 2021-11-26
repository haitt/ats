# ATS

## Server Requirements

- PHP 7.4, Composer is installed as global
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- sqlsrv PHP Extension
- pdo_sqlsrv PHP Extension
- Nginx

## Setup

- Clone source code from git

- Install dependencies (required to install `composer` as global):

```
composer install
```

- Copy `.env.example` to new `.env` file, and update settings with server environment configurations like database connection, App URL, Timezone,...

- Setup write permission on `storage/*` and `bootstrap/cache/`

- Update DB connection environment variables

```

# ATS_Web MSSQL DB
SQLSRV_DB_HOST=127.0.0.1
SQLSRV_DB_PORT=1433
SQLSRV_DB_DATABASE=ATS_Web
SQLSRV_DB_USERNAME=ATSWeb
SQLSRV_DB_PASSWORD=
```

## Task Scheduling

### Daily

No schedules.
