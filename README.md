Drop arbiter
============

The arbiter has to count user orders, and send to robots the more wanted action.


## Install

Requires git, Docker, docker-compose.

``` bash
git clone git@github.com:Darkmira/drop-master.git
cd drop-master/

# Create your .env from distribution and edit it
cp .env.dist .env

make
```

> **Note**: Sometimes you'll need to do either a
> `chown -R {your_user}:{your_group} .`
> or a
> `chmod -R 777 var/*`
> to make it work.


## Usage

Run all with Docker with command `make`.

Docker runs the whole environment, the RestApi, the websocket server and PHPMyAdmin. You now have access to:

 - http://0.0.0.0:8480/index-dev.php/api/race Rest Api (dev mode)
 - http://0.0.0.0:8480/api/race Rest Api (prod mode)
 - http://0.0.0.0:8480/index-dev.php/_profiler/ Symfony web profiler (only dev mode).
 - http://0.0.0.0:8481 PHPMyAdmin (login: `root` / `root`).
 - `ws://0.0.0.0:8482` Websocket server.


### Postman collection

You can use Postman to send predefined requests to the api.

Import this Postman collection: [postman.json](postman.json).


### Commands

Go to php container (if using Docker):

``` bash
make bash
```

Process votes and send them to Fleet control API:

``` bash
bin/console drop:votes:process
```

Do the same thing, but every 15 seconds:

``` bash
bin/console drop:votes:schedule 15
```


## License

This project is under [AGPL-v3 license](LICENSE).
