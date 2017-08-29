Drop arbiter
============

The arbiter has to count user orders, and send to robots the more wanted action.


## Install

Requires git, Docker, docker-compose.

``` bash
git clone git@github.com:Darkmira/drop-master.git
cd drop-master/

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


## License

This project is under [AGPL-v3 license](LICENSE).
