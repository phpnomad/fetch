# phpnomad/fetch

[![Latest Version](https://img.shields.io/packagist/v/phpnomad/fetch.svg)](https://packagist.org/packages/phpnomad/fetch)
[![Total Downloads](https://img.shields.io/packagist/dt/phpnomad/fetch.svg)](https://packagist.org/packages/phpnomad/fetch)
[![PHP Version](https://img.shields.io/packagist/php-v/phpnomad/fetch.svg)](https://packagist.org/packages/phpnomad/fetch)
[![License](https://img.shields.io/packagist/l/phpnomad/fetch.svg)](https://packagist.org/packages/phpnomad/fetch)

`phpnomad/fetch` is the client-side HTTP abstraction for PHPNomad applications. It defines the `FetchStrategy` interface that application code depends on when it needs to make outbound HTTP requests, along with a `FetchPayload` value object and a fluent builder for assembling requests.

The package intentionally ships no transport of its own. Concrete implementations live in integration packages so your application code stays portable across runtimes. Pair it with `phpnomad/guzzle-fetch-integration` for Guzzle-backed transport, with the `FetchStrategy` in `phpnomad/wordpress-integration` for a `wp_remote_request`-backed transport, or write your own by implementing the interface. The same calling code works in every case. `phpnomad/fetch` powers outbound HTTP in [Siren](https://sirenaffiliates.com) and several other PHPNomad-based systems in production.

## Installation

```bash
composer require phpnomad/fetch
```

You also need a strategy implementation. The common choices are `phpnomad/guzzle-fetch-integration` and the `FetchStrategy` included in `phpnomad/wordpress-integration`.

## Quick Start

Build a `FetchPayload` and hand it to the strategy. The example below makes a GET request to a JSON API with a custom header and two query parameters.

```php
<?php

namespace MyApp\Http;

use PHPNomad\Fetch\Interfaces\FetchStrategy;
use PHPNomad\Fetch\Models\FetchPayloadBuilder;
use PHPNomad\Http\Enums\Method;

class WidgetClient
{
    protected FetchStrategy $fetchStrategy;

    public function __construct(FetchStrategy $fetchStrategy)
    {
        $this->fetchStrategy = $fetchStrategy;
    }

    public function listWidgets(int $page, int $perPage): array
    {
        $response = $this->fetchStrategy->fetch(
            (new FetchPayloadBuilder())
                ->setMethod(Method::Get)
                ->setUrl('https://api.example.com/widgets')
                ->setHeader('Accept', 'application/json')
                ->setParam('page', $page)
                ->setParam('per_page', $perPage)
                ->build()
        );

        if ($response->getStatus() >= 400) {
            return [];
        }

        return $response->getJson();
    }
}
```

The `FetchStrategy` instance is typically resolved from the container and injected into the services that need it. Because your code depends on the interface rather than a specific HTTP client, the same `WidgetClient` runs unchanged whether the underlying transport is Guzzle, `wp_remote_request`, or a custom implementation.

## Key Concepts

- `FetchStrategy` is the interface your application depends on. It exposes a single method, `fetch(FetchPayload): Response`.
- `FetchPayload` is an immutable value object that carries the URL, HTTP method, headers, body, and query parameters for a single request.
- `FetchPayloadBuilder` provides a fluent API for assembling a payload step by step when constructor arguments feel awkward.
- The `Response` returned by `fetch()` comes from `phpnomad/http`, so status codes, headers, and body access are uniform across every transport.
- To add a new transport, implement `FetchStrategy` against the HTTP client of your choice and bind your implementation to the interface in your container.

## Documentation

Full PHPNomad documentation lives at [phpnomad.com](https://phpnomad.com).

## License

Released under the [MIT License](LICENSE).
