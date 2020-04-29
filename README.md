# WaterYourFlippinFerns
Vue.js learning project

This is a simple learning project to get more familiar with vue.js, which helps me keep track of which of my plants are in need of water.
The Frontend is a vue.js App which interacts with a laravel REST-API that acts as backend.

## Current functionality

The user can create a new Plant and specify name, amount of water needed and watering interval.
This Plant gets saved in the laravel db.

A list of all plants will get displayed split into plants that have enough water and plants that are in need of water.
The Plants are sorted by most urgent to least urgent.

Every plant item in the list can be deleted, edited or watered.
Watering a plant triggers an animated reordering of the list.

## Planned functionality

There should be an option to set a separate fertilization interval which reminds me on when I should fertilize my plants.
The degree of fertilization should be represented by a color gradient in the frontend.
