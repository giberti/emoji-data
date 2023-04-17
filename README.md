# Emoji Data

### To Rebuild Data Files

1. Edit the URL to parse in `builder/Parser.php` around line 10
2. Start a docker image to install the dependencies and run the builder

```shell
docker run -it --rm -v `pwd`:/app composer:latest bash
cd builder
php Parser.php
```

3. If add any additional backwards compatible CLDR mappings to `builder/Templates/Emoji.twig` and `builder/Templates/Mappings.twig`
4. Start (or reuse) a docker image to run the tests

```shell
docker run -it --rm -v `pwd`:/app composer:latest bash
./vendor/bin/phpunit
```

5. Cut a new release