# savoirr-tech-test

Savoirr technical test

Run containers and start the application

- composer deploy:dev

Stop de containers and the application

- composer stop

To execute the following commands, it is necessary to access the php container

Runs the worker to listen to messages in the queue

- php bin/console messenger:consume async -vv

Import members of the european parliament from url

- php bin/console app:import-members
