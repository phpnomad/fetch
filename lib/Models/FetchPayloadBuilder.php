<?php

namespace PHPNomad\Fetch\Models\Models;

use PHPNomad\Http\Enums\Method;

final class FetchPayloadBuilder
{
    private string $url = '';
    private string $method = Method::Get;
    private array $headers = [];
    private $body = null;
    private array $params = [];

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function setHeader(string $name, string $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param string $name
     * @param        $value
     *
     * @return $this
     */
    public function setParam(string $name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    public function build(): FetchPayload
    {
        return new FetchPayload(
          $this->url,
          $this->body,
          $this->method,
          $this->headers,
          $this->params
        );
    }
}