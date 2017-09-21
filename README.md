# search-test

1. Константи визначаються в папці /config 
2. Сервер має дивитись в корінь проекту
3. Дамп можна знайти в корені проекту

Завдання

You most likely will need to look up definitions for NOTAM and ICAO code in Wikipedia.
Working for RocketRoute you will often be confronted with new aviation specific abbreviation.

For this task you need to:

1) Read our API documentation at www.rocketroute.com/developers
Note that we provide a sandbox where you can test the API input/output

2) You will need password and MD5 Key. For login name please use your email 

The task is:


- To develop a web page displaying google maps
- Add a button
- Add a user input field for 4 letter ICAO code
- Upon click of that button make API call to our NOTAM API and do a search for the NOTAm for the 4 letter ICAO code that user entered

For example here are some ICAO codes:
EGLL
EGGW
EGLF
EGHI
EGKA
EGMD
EGMC
KLAX 
SBSP

The Geo Location for the NOTAM are held in field ItemQ

Then place an icon on that location
(Use similar icon to this icon: http://www.clker.com/cliparts/H/Z/0/R/f/S/warning-icon-th.png)

When click on such an icon show a  text box onto the position showing the NOTAM string received via our API (ItemE)
You can google the description of NOTAM

Please host the resulting web page on any server you like. 
Attach the source code to your reply or provide a link to the repository.

The task will test your ability to:

- implement an API call using our documentation and
- the ability to implement onto the google MAPS API and
- place an icon(s) on a google map geo location with that result using the google API
- write acceptance, functional and unit tests;
- write reusable code;
- comply SOLID principles.
