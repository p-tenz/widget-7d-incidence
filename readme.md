# Wordpress Widget: Covid-19 7-Tage-Inzidenz-Werte eines Landkreises

Dies ist mein erstes Wordpress Plugin. Es enthält ein Widget, das die drei neuesten 7-Tage-Inzidenzen für einen Landkreis als farbige Sechsecke anzeigt.

![widget](widget.PNG)

Die Farben sind abhängig vom Inzidenzwert
* grün: unter 50
* gelb: zwischen 50 und 100
* rot: über 100

Die Einstellungen im Wordpress Backend sind ganz einfach: einmal der Titel für das Widget und dann der gewünschte Landkreis (District):

![backend](backend.PNG)

## Hinter den Kulissen
Die Daten werden mit Hilfe der [RKI Covid API](https://github.com/marlon360/rki-covid-api) geholt. Es sollten idealerweise immer die Werte von heute, gestern und vorgestern angezeigt. Dies ist allerdings abhängig vom Zietpunkt der Abfrage und ob da schon die aktuellen Daten vorliegen.


## Bekannte Probleme

* bisher keine Fehlerbehandlung
* Landkreise unsortiert
* Werte werden nicht gecacht, obwohl sie sich nur einmal am Tag ändern
* unsichbare Hexagons links und rechts
