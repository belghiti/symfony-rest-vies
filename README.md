
# belghiti/symfony-rest-vies

[![CI](https://github.com/belghiti/symfony-rest-vies/actions/workflows/ci.yml/badge.svg)](https://github.com/belghiti/symfony-rest-vies/actions)
[![Packagist](https://img.shields.io/packagist/v/belghiti/symfony-rest-vies.svg)](https://packagist.org/packages/belghiti/symfony-rest-vies)
[![Downloads](https://img.shields.io/packagist/dt/belghiti/symfony-rest-vies.svg)](https://packagist.org/packages/belghiti/symfony-rest-vies)

Symfony bundle for **VIES**. Wires the core `belghiti/vies-client` through Symfony HttpClient (PSR‑18) and adds a Symfony Cache decorator.

---

## Requirements

- Symfony **7.4 LTS** or **8.0**
- PHP **8.2+**

## Installation

```bash
composer require belghiti/symfony-rest-vies
```

Enable the bundle:
```php
// config/bundles.php
return [
  Belghiti\Vies\Symfony\PeasyViesBundle::class => ['all' => true],
];
```

Configure:
```yaml
# config/packages/peasy_vies.yaml
peasy_vies:
  base_uri: 'https://ec.europa.eu/taxation_customs/vies/rest-api'
  cache_ttl: 3600
```

## Usage

```php
use Belghiti\Vies\Client\ViesClientInterface;
use Belghiti\Vies\Dto\CheckVatRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class VatController extends AbstractController
{
    public function verify(ViesClientInterface $vies)
    {
        $res = $vies->checkVatNumber(new CheckVatRequest('IT','01114601006'));
        return $this->json(['valid' => $res->valid]);
    }
}
```

`ViesClientInterface` is resolved to **HttpViesClient → RetryingViesClient → SymfonyCacheViesClient**.

## Quality

```bash
composer lint   # PSR-12
composer stan   # PHPStan level max
vendor/bin/phpunit -c tests/phpunit.xml
```

## License

MIT
