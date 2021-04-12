# Animal Translator v0.0.1

Dit project is een assessment opdracht ten behoeve van de sollicitatieprocedure bij Netpresenter.
De opdracht is bekend bij de opdrachtgever en zal niet hier geplaatst worden.

### Het project opstarten

De code is voorzien van een docker-compose.yml file. Hiermee kan het project makkelijk gestart worden.


Bij het eerste keer starten van het project zal eenmaling composer en npm install gedraaid moeten worden.
Dit kan met de volgende commando's:

```bash
$ docker-compose run node npm install
$ docker-compose run fpm composer install
```

Vervolgens kan het project gestart worden met:
```bash
$ docker-compose up -d
```

Hierbij zal de node container automatisch npm run dev starten en zodra deze klaar is, is het project te benaderen via http://localhost. 
Pas eventueel de nginx poort aan in de docker-compose.yml indien poort 80 al in gebruik is.

