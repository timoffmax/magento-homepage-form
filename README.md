# Magento Homepage Form

Test task. Not for real use.

## Requirements
- PHP >= 7.2 (tested on 7.3)
- Magento >= 2.3 (tested on 2.3.5-p1)

## Installation
- Create a folder `mkdir -p app/code/Timoffmax/HomepageForm`
- Copy module's content to `app/code/Timoffmax/HomepageForm`
- `bin/magento module:enable Timoffmax_HomepageForm`
- `bin/magento setup:upgrade`

## To Improve
- Investigate the bug with form key. The first request ofter fails because `form_key` cookie is not set on main page loading. 
