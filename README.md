#### Задание
Необходимо разработать REST API каталога цифровых товаров (файлов) на языке PHP с использованием фреймворка Lumen. 

 API должно предоставлять доступ к следующей информации в формате JSON:
- Список категорий файлов
- Список файлов в категории

Авторизованные пользователи могут совершать следующие действия:
- Загружать файлы в категорию.
- Скачивать файлы из категории.
- Изменять название, категорию файла. Файл одновременно может находится в нескольких категориях.
- Оценивать файлы по шкале от 1 до 10, один раз для каждого файла. Подсчёт рейтинга каждого файла/категории должен происходить асинхронно.

Объекты должны содержать возвращать следующую информацию:
- Файлы:
``` 
Название
Рейтинг
Число скачиваний
```

- Категория:
```
Название
Число файлов
Рейтинг файлов
```

####Технические требования:
- Приложение должно быть написано на PHP в фреймворке Lumen
- Результаты запросов должны быть представлены в формате JSON
- Авторизация должна происходить через заголовок auth-user-id: (int)
- Развертывание приложения должно происходить стандартными средствами фреймворка (структура БД, заполнение первоначальными данными)

### Запуск приложения
```
git clone https://github.com/pavel-lukashevich/lumen-file-manager.git
cd lumen-file-manager
composer install

# для консоли OpenServer
copy .env.example .env
# или для Linux
cp .env.example .env
```
создать базу данных, заполнить в .env файле DB_*
```
php artisan migrate 
php artisan db:seed
```
для работы очередей запустить
```
php artisan queue:work
```
для примера настроить домен "lumen.loc" на папку "lumen-file-manager/public"

## Примеры запросов

```
# get categories 
curl --location --request GET 'http://lumen.loc/api/v1/categories'
или
curl --location --request GET 'http://lumen.loc/api/v1/categories' \
--header 'auth-user-id: 5'

# get files
curl --location --request GET 'http://lumen.loc/api/v1/files'
или
curl --location --request GET 'http://lumen.loc/api/v1/files' \
--header 'auth-user-id: 5'

# upload file
curl --location --request POST 'http://lumen.loc/api/v1/files' \
--header 'auth-user-id: 5' \
--form 'file=@/C:/Users/Администратор/Downloads/samolet.mp3' \
--form 'categories[]=4' \
--form 'categories[]=7' \
--form 'name=zzzzz'

# show file
curl --location --request GET 'http://lumen.loc/api/v1/files/5' \
--header 'auth-user-id: 5'

# download file
curl --location --request POST 'http://lumen.loc/api/v1/files/22' \
--header 'auth-user-id: 6'

# update file
curl --location --request PUT 'http://lumen.loc/api/v1/files/22' \
--header 'auth-user-id: 5' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'categories[]=7' \
--data-urlencode 'categories[]=7' \
--data-urlencode 'name=lllll'

# rate file
curl --location --request POST 'http://lumen.loc/api/v1/files/6/rate' \
--header 'auth-user-id: 8' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--data-urlencode 'rating=8'
```


# ( ͡° ͜ʖ ͡°)