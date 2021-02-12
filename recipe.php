<?php

namespace Deployer;

set('bin/nanbando', 'nanbando.phar');
set('nanbando_backup_options', '');
set('nanbando_push', true);
set('nanbando', true);

set('nanbando_enabled', function () {
    if (!get('nanbando')) {
        return false;
    }

    $releases = get('releases_list', []);

    return 0 < count($releases);
});

task('nanbando:plugins:install', function () {
    if (!get('nanbando_enabled')) {
        return;
    }

    run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} plugins:install');
})->desc('nanbando plugins:install');

task('nanbando:backup', function () {
    if (!get('nanbando_enabled')) {
        return;
    }

    run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} backup {{nanbando_backup_options}}');
})->desc('nanbando backup');

task('nanbando:push', function () {
    if (!get('nanbando_push') || !get('nanbando_enabled')) {
        return;
    }

    run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} push');
})->desc('nanbando push');

before('nanbando:backup', 'nanbando:plugins:install');
after('nanbando:backup', 'nanbando:push');
before('deploy:prepare', 'nanbando:backup');
