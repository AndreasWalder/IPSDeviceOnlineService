# TestAndreas

Modul für IP-Symcon ab Version 4.4

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Installation](#3-installation)
4. [Funktionsreferenz](#4-funktionsreferenz)
5. [Konfiguration](#5-konfiguration)
6. [Anhang](#6-anhang)

## 1. Funktionsumfang

1. Test Modul für Ipsymcon von Andreas

## 2. Voraussetzungen

 - IPS 4.x
 

## 3. Installation

### a. Laden des Moduls

Die IP-Symcon (min Ver. 4.x) Konsole öffnen. Im Objektbaum unter Kerninstanzen die Instanz __*Modules*__ durch einen doppelten Mausklick öffnen.

In der _Modules_ Instanz rechts oben auf den Button __*Hinzufügen*__ drücken.

In dem sich öffnenden Fenster folgende URL hinzufügen:

`https://github.com/AndreasWalder/IPSymconTestAndreas.git`

und mit _OK_ bestätigen.

Anschließend erscheint ein Eintrag für das Modul in der Liste der Instanz _Modules_

### b. Einrichtung in IPS

In IP-Symcon nun _Instanz hinzufügen_ (_CTRL+1_) auswählen unter der Kategorie, unter der man die Instanz hinzufügen will, und Hersteller _(sonstiges)_ und als Gerät _TestAndreas_ auswählen.

In dem Konfigurationsdialog den Datenbank-Server eintragen (Name oder IP-Adresse sind zulässig), Datenbank und Zugriffdaten

## 4. Funktionsreferenz

Test 

## 5. Konfiguration:

### Variablen

| Eigenschaft               | Typ      | Standardwert | Beschreibung |
| :-----------------------: | :-----:  | :----------: | :----------------------------------------------------------------------------------------------------------: |
| Server                    | string   |              | Hostname / IP-Adresse des Datenbank-Servers |
| Port                      | integer  | 3306         | Port, unter dem der Datenbank-Server kommuniziert |
| Benutzer                  | string   |              | Datenbank-Benutzer |
| Passwort                  | string   |              | Passwort des Datenbank-Benutzers |
| Datenbank                 | string   |              | zu benutzende Datenbank |

### Schaltflächen

| Bezeichnung                  | Beschreibung |
| :--------------------------: | :------------------------------------------------: |
| Verbindunstest               | Testet die Datenbankverbindung |

## 6. Anhang

GUIDs
- Modul: `{C0E06BF5-D1D1-42018-8CAB-93D161A7CA98}`
- Instanzen:
  - TestAndreas: `{8C110C1C-F011-4C65-925D-6FEE0D8F1A55}`

