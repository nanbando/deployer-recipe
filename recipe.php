<?php

namespace Deployer;

set('bin/nanbando', 'nanbando.phar');
set('nanbando_backup_options', '');
set('nanbando_push', true);
set('nanbando', true);

task('nanbando:reconfigure', function () {
    if (get('nanbando')) {
        run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} reconfigure');
    }
})->desc('Reconfigure nanbando');

task('nanbando:backup', function () {
    if (get('nanbando')) {
        run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} backup {{nanbando_backup_options}}');
    }
})->desc('Create backup');

task('nanbando:push', function () {
    if (get('nanbando') && get('nanbando_push')) {
        run('cd {{current_path}} && {{bin/php}} {{bin/nanbando}} push');
    }
})->desc('Push backup to remote storage');

before('nanbando:backup', 'nanbando:reconfigure');
after('nanbando:backup', 'nanbando:push');
before('deploy:prepare', 'nanbando:backup');

