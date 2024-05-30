## How to run

```bash
    npm i
    composer install
    npm run dev
    php artisan serve
```

## Deploy

```bash
    git clone https://github.com/delaynore/special-spoon.git  
    npm i
    npm build
    composer install

    ln -s public public_html

    php artisan migrate
    php artisan key:generate

    //recomended
    php artisan optimize
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    // before migrate to new version
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
```

## ToDo

1. Авторизация
    1. [x] Регистрация
    2. [x] Вход
    3. [x] Восстановление пароля
2. Экспорт и импорт
    1. [x] Экспорт всех понятий словаря (еще есть над чем подумать)
    2. [x] Импорт списка экземпляров понятия
3. Словарь
    1. [x] CRUD операции со словарем (поправить ошибки при изменении словаря)
    2. [x] Добавлять теги к словарю
    3. [x] Добавлять понятия
    4. [x] Добавлять понятия с родителем
    5. [x] Изменять понятие
    6. [x] Изменять родителя понятия
    7. [x] Удалять понятие
    8. [x] Загружать файлы
    9. [x] Отношения между понятиями
    10. [x] Атрибуты понятия
    11. [x] Ссылки на другие понятия
    12. [x] CRUD Атрибутов
    13. [x] CRUD экземпляров
    14. [x] CRUD тегов
    15. [x] Пагинация в "мои словари"
    16. [x] Безопасный просмотр публичных словарей
    17. [x] Фильтрация "мои словари" по видимости
4. Главная страница
    1. [x] Вывод публичных словарей
    2. [x] Пагинация
    3. [x] Поиск
5. Приколюхи

    1. [x] Всплывашки при каких-либо действиях

6. Теги

    1. CRUD для тегов
    2. Подумать над системой для добавления тегов, например, обычный пользователь может предложить новый тег, а потом админ разрешит его использование. До этого он не будет доступен для выбора в настройках словаря.

7. [x] Локализация
