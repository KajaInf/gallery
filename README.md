# Gallery

Aplikacja galerii zdjęć wykonana w Symfony 6 LTS z wykorzystaniem bazy danych MySQL.

## Funkcjonalności

### Gość

* przeglądanie galerii
* przeglądanie zdjęć
* filtrowanie zdjęć po tagach
* przeglądanie komentarzy

### Użytkownik

* logowanie
* edycja własnego profilu
* zmiana hasła
* dodawanie komentarzy do zdjęć

### Administrator

* zarządzanie zdjęciami (CRUD)
* zarządzanie galeriami (CRUD)
* zarządzanie tagami (CRUD)
* zarządzanie użytkownikami
* usuwanie komentarzy

## Wymagania

* PHP 8.1+
* Composer
* MySQL
* Symfony CLI (opcjonalnie)

## Instalacja

Sklonowanie repozytorium:

```bash
git clone https://github.com/KajaInf/gallery.git
cd gallery
```

Instalacja zależności:

```bash
composer install
```

Konfiguracja bazy danych w pliku `.env`:

```env
DATABASE_URL="mysql://USER:PASSWORD@127.0.0.1:3306/gallery"
```

Utworzenie struktury bazy danych:

```bash
php bin/console doctrine:migrations:migrate
```

Załadowanie przykładowych danych:

```bash
php bin/console doctrine:fixtures:load
```

Uruchomienie aplikacji:

```bash
symfony server:start
```

lub

```bash
php -S 127.0.0.1:8000 -t public
```

## Przykładowe konta

Administrator:

```text
email: admin@example.com
hasło: admin123
```

Użytkownik:

```text
email: user@example.com
hasło: user123
```

## Testy

Uruchomienie testów:

```bash
vendor/bin/phpunit
```

Generowanie raportu pokrycia kodu:

```bash
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text
```



## Autor

Kaja Michalik
