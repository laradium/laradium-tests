### Requirements

- PHP >= 7.1
- MySQL 5.6 or later (Maria DB 10.1 or later)
- Laradium packages (laradium, laradium-content, laradium-permission)

### Installation

- clone repository
- run migrations
- ./vendor/bin/phpunit

### Packages

Packages must be located under specified directory in order to run the tests.
Tests will not fully work if the required packages are not installed properly.
For specifics of each packages please read the documentation in the packages repository.

```
- laradium-tests
- packages
-- laradium
-- laradium-content
-- laradium-permission
```