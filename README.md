# InkSpace — Portale fumettisti indipendenti

Portale Laravel 10 per pubblicare fumetti, scoprire autori indipendenti e consultare il loro catalogo. L’interfaccia è responsive e utilizza Bootstrap 5.3.

## Funzionalità

- registrazione e autenticazione con Laravel Fortify;
- profilo fumettista aggiornabile, con telefono unico, sede legale facoltativa, immagine e biografia;
- CRUD dei fumetti riservato agli utenti autenticati e protetto per autore;
- copertina, trama, numero, anno, categorie multiple e rivista facoltativa;
- catalogo fumetti, elenco fumettisti e pagine di dettaglio accessibili agli ospiti;
- seed idempotenti per categorie e riviste;
- form contatti con e-mail al gestore e conferma al mittente;
- test automatici delle principali user story.

## Requisiti

- PHP 8.1 o successivo;
- Composer;
- Node.js e npm;
- MySQL 8 (SQLite può essere usato per sviluppo e test).

## Installazione

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Configura il database e `CONTACT_EMAIL` nel file `.env`, poi esegui:

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Per lo sviluppo frontend puoi usare `npm run dev` al posto della build di produzione.

## Test

```bash
php artisan test
```

La suite usa SQLite in memoria e non modifica il database locale.

## Deploy su Vercel

La produzione usa il runtime PHP serverless, PostgreSQL Neon persistente e
Vercel Blob per le immagini. La funzione è eseguita a Francoforte, nella stessa
regione del database, e usa la connessione pooled durante il normale traffico.

Le migrazioni non vengono eseguite durante ogni richiesta HTTP. Per un
aggiornamento controllato dello schema si può impostare temporaneamente
`RUN_DATABASE_MIGRATIONS=true`, effettuare una singola richiesta sul deployment
e riportare subito la variabile a `false`. Il runtime esegue esclusivamente
`migrate --force`: non cancella mai il database con `migrate:fresh`.

Il progetto nasce dalla traccia didattica conservata nella repository
[`Hackademy-141A/Portale-Fumettisti-Federico-Esposito-Tuccillo`](https://github.com/Hackademy-141A/Portale-Fumettisti-Federico-Esposito-Tuccillo).

