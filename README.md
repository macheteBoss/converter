# converter

# Инструкция по развёртыванию

- Развернуть git репозиторий
- Поднять контейнеры:
  
  # docker-compose up --build -d

- Выполнить build файл (создаёт юзера для БД, выполняет миграции):

  # ./docker/build.sh


Команда для крона:

# php/bin console converttask:load-rates

По умолчанию берёт предыдущий день на текущий день. Т.к. команда будет запускаться раз в день, то это вполне правильно. Также данная команда поддерживает передачу определённой даты, для этого нужно передать ключ date:

# php/bin console converttask:load-rates --date="2024-06-02"

Для тестирование запускать команду следующим образом:

- Зайти в php контейнер:

  # docker exec -it converttask-php-fpm bash

- Выполнить команду указанную выше


Можно перейти на главную и посмотреть интерфейс:

# http://127.0.0.1:8099/

Текущий курс валют, а также все рассчёты можно посмотреть в админ панели:

# http://127.0.0.1:8099/admin/



Что можно улучшить:

- Создать регистрацию пользователя, чтобы подтягивать его таймзону;
- Дать возможно загружать и обновлять определённые валюты, т.е. доработать код для крона;
- Создать страницу настроек, где выставлять правила округления рассчётов

Некоторый нюанс:
- Для поля ввода значения для конвертации выставлен тип BigInt, который имеет максимальное число в диапазоне: 9223372036854775807. В случае если ввести число больше, то оно возьмёт только максимальное доступное, т.е. 9223372036854775807 и будет работать с ним. Можно было выбрасывать исключение и отдавать ошибку, но тут зависит от определённой задачи, я посчитал, что так будет корректно.


Время выполнения работы: 8 часов
