# HOMEWORK 1

## Zadání

Napište "univerzální" program, který přečte libovolně dlouhý textový soubor. Řádek po řádku bude aplikovat uživatelské filtry a dekorátory. Výstupem programu bude počet stejných (upravených) řádků a jejich četností.

Použijte co nejvíce vlastností moderního PHP. Doporučení:

- Iterables
- Anonymous functions, especially Callables
- Types
- And more

**Bonus**

Upravte program tak, aby vypisoval průběžný stav nekonečného streamu.

## Scripty

Vytvoření služeb

``docker-compose build``

Spuštění příkazové řádky

``docker-compose run --rm php /bin/sh``

Spuštění aplikace

``php index.php app:filter``

Kontrola kódu (PHPStan level 9)

``composer stan``

Kontrola formátu kódu (PSR-12)

``composer phpcs``

Oprava formátu kódu (PSR-12)

``composer phpcbf``

## Technologie a knihovny

- Docker
- PHP 8
- Symfony console
- Nette Utils
- PHPStan
- PHP Codesniffer