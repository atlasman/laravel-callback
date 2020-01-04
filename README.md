<h1 align="center"> laravel-callback </h1>

<p align="center"> http callback request for laravel.</p>


## Installing

```shell
$ composer require atlasman/laravel-callback -vvv
```
The package will automatically register itself.

You can publish the config-file with:

```bash
php artisan vendor:publish --provider="Atlasman\LaravelCallback\ServiceProvider" --tag="config"
```

You can publish the provider with:

```bash
php artisan vendor:publish --provider="Atlasman\LaravelCallback\ServiceProvider" --tag="provider"
```


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/atlasman/laravel-callback/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/atlasman/laravel-callback/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT