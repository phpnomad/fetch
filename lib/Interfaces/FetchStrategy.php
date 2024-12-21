<?php

namespace PHPNomad\Fetch\Interfaces;


use PHPNomad\Fetch\Models\Models\FetchPayload;
use PHPNomad\Http\Interfaces\Response;

interface FetchStrategy{

    /**
     * @param FetchPayload $payload
     * @return Response
     */
    public function fetch(FetchPayload $payload): Response;
}