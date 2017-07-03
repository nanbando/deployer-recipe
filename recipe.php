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

task('nanbando:reconfigure', function () {
    if (!get('nanbando_enabled')) {
        return;
    }

    run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} reconfigure');
})->desc('Reconfigure nanbando');

task('nanbando:backup', function () {
    if (!get('nanbando_enabled')) {
        return;
    }

    run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} backup {{nanbando_backup_options}}');
})->desc('Create backup');

task('nanbando:push', function () {
    if (!get('nanbando_push') || !get('nanbando_enabled')) {
        return;
    }

    run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} push');
})->desc('Push backup to remote storage');

before('nanbando:backup', 'nanbando:reconfigure');
after('nanbando:backup', 'nanbando:push');
before('deploy:prepare', 'nanbando:backup');
