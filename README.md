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
Powyższe powinno zainstalować "doker".

Wymagane komendy i przykłady działania.

Dodanie nowej osoby (wysyła maile na wszystkie adresy)
 ```
 curl -X POST http://localhost:8046/api/persons \
     -H "Content-Type: application/json" \
     -d '{"token": "asdkllll", "request": "store", "data":{"name":"Michał","surname":"Sołtan","phone":"697604778","emails":["michal.soltan@nessico.pl","michal.soltan@avt.pl"]}}'
 ```
 Odpowiedź:
 ```
 ```
