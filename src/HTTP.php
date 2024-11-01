<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Query;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class HTTP
{
    public string $token;

    public string $url;

    public string $format = 'json';

    public Client $client;


/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $token Authentication token
     * @param string|null $url Base URL for API
     * @param string $format HTTP output format
     * @param bool $verify
     * @param bool $errors
     */
    public function __construct(
        ?string $token  = null,
        ?string $url    = null,
         string $format = 'json',
           bool $verify = false,
           bool $errors = false,
    )
    {
        $this->token = $token   ?? $_ENV['PUSHOVER_API_TOKEN'];
        $this->url   = $url     ?? $_ENV['PUSHOVER_API_URL'];
        $this->format = $format ?? $this->format;

        $this->client = $client ?? new Client([
            'base_uri'    => $this->url,
            'verify'      => $verify,
            'http_errors' => $errors
        ]);
    }



/* GET METHOD
----------------------------------------------------------------------------- */

    /**
     * @param string $uri URI of API call
     * @param array $params Query parameters for API call
     * @return object
     */
    public function get( string $uri, array $params = [] ) : object
    {
        $uri = ltrim( string: $uri, characters: '/' );
        $params['token'] = $this->token;
        $options['query'] = Query::build( $params );

        try {
            $response = $this->client->request(
                 method: 'GET',
                    uri: $uri,
                options: $options
            );
        } catch (GuzzleException $e) {
            // DO SOMETHING HERE
            exit;
        }

        return $this->return_Results( response: $response );
    }



/* POST METHOD
----------------------------------------------------------------------------- */

    /**
     * @param string $uri URI of API call
     * @param array|object $params Parameters for body of API call
     * @return object
     */

    public function post( string $uri, array|object $params ) : object
    {
        $uri = ltrim( string: $uri, characters: '/' );
        $params['token'] = $this->token;
        $options['headers'] = [ 'content-type' => 'application/json' ];
        $options['body']  = json_encode( $params );

        try {
            $response = $this->client->request(
                 method: 'POST',
                    uri: $uri,
                options: $options
            );
        } catch (GuzzleException $e) {
            //print_r( $e->getMessage() );
            // DO SOMETHING HERE
            exit;
        }

        return $this->return_Results( response: $response );
    }


/*
----------------------------------------------------------------------------- */

    private function return_Results( ResponseInterface $response ) : object
    {
        $output = new stdClass();
        $output->status         = $response->getStatusCode();
        $output->headers        = $response->getHeaders();
        $output->status_message = $response->getReasonPhrase();
        $output->body           = $response->getBody()->getContents() ?? [];

        if( $this->format === 'json' ) {
            $output->body = json_decode( json: $output->body );
        }

        return $output;
    }
}