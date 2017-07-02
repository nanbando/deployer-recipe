# Nanbando deployer recipe

This repository contains a recipe to integrate with deployer.

## Installation

```bash
composer require --dev nanbando/deployer-recipe
```

Include file into your `deploy.php`:`

```php
require 'vendor/nanbando/deployer-recipe/recipe.php';

set('bin/nanbando', '<path/to>/nanbando.phar');
set('nanbando_push', true);
set('nanbando_backup_options', '');
```
