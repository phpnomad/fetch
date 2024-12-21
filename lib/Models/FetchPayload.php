<?php

namespace PHPNomad\Fetch\Models\Models;

final class FetchPayload
{
    protected string $url;
    protected string $method = 'GET';
    protected array $headers = [];
    protected $body;
    protected array $params = [];

    public function __construct(
        string $url,
        $body,
        string $method = 'GET',
        array $headers = [],
        array $params = []
    )
    {
        $this->url = $url;
        $this->body = $body;
        $this->method = $method;
        $this->headers = $headers;
        $this->params = $params;
    }

    /**
     * Get the URL for the request.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get the HTTP method for the request.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get a header value by name.
     *
     * @param string $name
     * @return string|null
     */
    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    /**
     * Get all headers for the request.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get the body for the request.
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get a request parameter by name.
     *
     * @param string $name
     * @return mixed|null
     */
    public function getParam(string $name)
    {
        return $this->params[$name] ?? null;
    }

    /**
     * Get all request parameters.
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}