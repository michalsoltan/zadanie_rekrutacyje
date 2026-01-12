# Zadanie rekrutacyjne
Treść:
```
Aplikaca która ma za zadanie realizować
operacje CRUD
użytkownika (użytkownik powinien mieć co najmniej takie dane jak,
imię , nazwisko, nr telefonu oraz wiele adresów e-mail
przypisanych do każdego użytkownika.

dodatkowo aplikacja powinna mieć takie funkcje jak:

- wysyłki przykładowego „maila" o treści „Witamy użytkownika
XXX (gdzie XXX jest nazwa użytkownika)" na wszystkie adresy danego
użytkownika

wymagania:
- Aplikacja z użyciem framework-a Laravel 12

Proszę napisać API, bez widoków realizujące zadanie z
użyciem  JSON, REST
```
## Wykonanie

Niniejsze repozytorium można pobrać za pomocą komend:
```
git clone https://github.com/michalsoltan/zadanie_rekrutacyje.git
```
lub
```
git clone git@github.com:michalsoltan/zadanie_rekrutacyje.git
```
Następnie:
```
cd zadanie_rekrutacyje
make init-project
```
Powyższe powinno zainstalować "doker", który dostępny jest na porcie 8046.

Wymagane komendy i przykłady działania.

Dodanie nowej osoby (wysyła maile na wszystkie adresy)
 ```
curl -X POST http://localhost:8046/api/persons \
     -H "Content-Type: application/json" \
     -d '{"token": "asdkllll", "request": "store", "data":{"name":"Michał","surname":"Sołtan","phone":"697604778","emails":["michal.soltan@nessico.pl","michal.soltan@avt.pl"]}}'

curl -X POST http://localhost:8046/api/persons \
     -H "Content-Type: application/json" \
     -d '{"token": "asdkllll", "request": "store", "data":{"name":"Katarzyna","surname":"Sołtan","phone":"601334255","emails":["katarzyna.soltan@"]}}'

curl -X POST http://localhost:8046/api/persons \
     -H "Content-Type: application/json" \
     -d '{"token": "asdkllll", "request": "store", "data":{"name":"Katarzyna","surname":"Sołtan","phone":"601334255","emails":["katarzyna.soltan@nessico.pl"]}}'
 ```
 Odpowiedź:
 ```
 {"response":1,"data":{"name":"Micha\u0142","surname":"So\u0142tan","phone":"697604778","emails":"michal.soltan@nessico.pl;michal.soltan@avt.pl","updated_at":"2026-01-12T14:17:49.000000Z","created_at":"2026-01-12T14:17:49.000000Z","id":1}}

 {"response":0,"data":[{"error":"Unproper data"}]}

 {"response":1,"data":{"name":"Katarzyna","surname":"So\u0142tan","phone":"601334255","emails":"katarzyna.soltan@nessico.pl","updated_at":"2026-01-12T14:20:38.000000Z","created_at":"2026-01-12T14:20:38.000000Z","id":2}}

 ```

 Lista osób:

 ```
 curl -X POST http://localhost:8046/api/persons \
     -H "Content-Type: application/json" \
     -d '{"token": "asdkllll", "request": "index", "data":{}}'
```
Odpowiedź:

```
{"response":1,"data":[{"id":1,"name":"Micha\u0142","surname":"So\u0142tan"},{"id":2,"name":"Katarzyna","surname":"So\u0142tan"}]}
```

Update danych:

```
curl -X POST http://localhost:8046/api/persons \
     -H "Content-Type: application/json" \
     -d '{"token": "asdkllll", "request": "update", "data":{"id":1,"name":"Michał Maria","surname":"Sołtan","phone":"697604778","emails":["michal.soltan@nessico.pl","michal.soltan@avt.pl","soltan.michal@gmail.com"]}}'
```

Odpowiedź:

```
{"response":1,"data":{"id":1,"name":"Micha\u0142 Maria","surname":"So\u0142tan","phone":"697604778","emails":"michal.soltan@nessico.pl;michal.soltan@avt.pl;soltan.michal@gmail.com","created_at":"2026-01-12T14:17:49.000000Z","updated_at":"2026-01-12T14:25:41.000000Z"}}
```
Usuwanie:

```
curl -X POST http://localhost:8046/api/persons \
     -H "Content-Type: application/json" \
     -d '{"token": "asdkllll", "request": "delete", "data":{"id":"2"}}'
```

Odpowiedź:

```
{"response":1,"data":[{"info":"Person deleted"}]}
```
"Requesty" zabezpieczone są co do formatu tzn. wymagane są pola: token, request i data.
Pole token zastosowane jest tylko jako zaślepka, w realnej aplikacji powinien być ustawiany oraz weryfikowany co do poprawności.

W czasie testów poza "dokerem" wiadomości email były wysyłane i w logach były widoczne. Z jakichś powodów w "dokerze" plik laravel.log nie powstaje i nie można obserwować tego zjawiska.

Można to ominąć wykonując następujące czynności:
Wyłączyć dokera:
```
docker compose -f docker-compose.yml --env-file .env -p zadanie_rekrutacyje down
```
Przejść do katalogu app i :
```
cd app
npm install && npm run build
composer run dev
```
Wtedy komendy curl trzeba zmodyfikować - port 8046 zamienić na 8000.
Logi wtedy działają i widać wysyłanie maili.
