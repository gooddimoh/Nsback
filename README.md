# Установка

> :warning: Пользовательской частью(папка frontend/) занимается front-end разработчик.
> Пожалуйста, работайте только над backend-частью.

1. Скачать файлы:

   `git clone https://github.com/likont/nsback.git`

2. Переместить в директорию, где удобно хранить файлы.

   **ИЛИ** переходим в созданную с помощью git директорию: `cd nsback`

4. Установить зависимости:

   `composer install`

   **ИЛИ** при локальном размещении:

   `php composer.phar install`

> :information_source: Если нет Composer - установите его:
>- Глобально (Рекомендуется): [Как установить Composer в Windows](https://www.hostinger.ru/rukovodstva/kak-ustanovit-composer#-Composer-Windows)
>- Локально: [Command-line installation](https://getcomposer.org/download/)

4. Запустите настройку окружения с помощью команды:

   `php init`

   Выберите: `[0] Development`

5. Задайте настройки в файлах: 
- `common/config/main-local.php`
- `common/config/params-local.php`
- `frontend/config/params-local.php`

> :warning: Необязательно заполнять все настройки. 
> 
> Достаточно указать настройки для тех модулей, с которыми Вы будете проводить работу.
> 
> Например: обязательно для следующего шага будет заполнение настроек подключения к базе данных.


7. Теперь необходимо произвести миграции:

- `php yii migrate --migrationPath=@vendor/yii2mod/yii2-settings/migrations`
- `php yii migrate --migrationPath=@yii/rbac/migrations`
- `php yii migrate`

7. Выполняем команду
- `php yii tools/rbac/init`
