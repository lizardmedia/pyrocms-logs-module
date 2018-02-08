# Pyrocms logs module

PyroCMS addon with logging administrative events, including nice grid with filtering.

## Getting Started

### Prerequisites

* PHP 7.1
* PyroCMS 3.4.0

### Installing

* Clone this repo to `addons/{app_name}/lizard/logs-module`.
* `composer dumpautoload`
* `php artisan addon:install lizard.module.logs`

Add Models to `Lizard\LogsModule\Log\LogManager` file to listen for events.

## Code styling

Use PSR-2, SOLID principles and good design patterns.

## Authors

* **Maciej Jeziorski** - *Initial work*
* **Rafał Wachelka** - *Additional work*

See also the list of [contributors](https://github.com/lizardmedia/pyrocms-logs-module/contributors) who participated in this project.

## TODO
* More examples for development.