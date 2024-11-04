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
    /**
     * @var string API authentication token.
     */
    public string $token;

    /**
     * @var string Base URL of API server.
     */
    public string $url;

    /**
     * @var string API output format. XML or JSON.
     */
    public string $format = 'json';

    /**
     * @var Client Guzzle HTTP client.
     */
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
        $this->format = $format;

        $this->client = new Client([
            'base_uri'    => $this->url,
            'verify'      => $verify,
            'http_errors' => $errors
        ]);
    }



/* GET METHOD
----------------------------------------------------------------------------- */

    /**
     * @param string $uri URI of API call
     * @param array<string, string|int|float> $params Query parameters for API call
     * @return Response API data object
     */
    public function get( string $uri, array $params = [] ) : Response
    {
        $uri = ltrim( string: $uri, characters: '/' );
        $params['token']  = $this->token;
        $options['query'] = Query::build( $params );

        try {
            $response = $this->client->request(
                 method: 'GET',
                    uri: $uri,
                options: $options
            );
        } catch (GuzzleException $e) {
            return self::error( message: $e->getMessage());
        }

        return $this->return_Results( response: $response );
    }



/* POST METHOD
----------------------------------------------------------------------------- */

    /**
     * @param string $uri URI of API call
     * @param array<string, string|int|float>|object $params Parameters for body of API call
     * @return Response API data object
     */

    public function post( string $uri, array|object $params ) : Response
    {
        $uri = ltrim( string: $uri, characters: '/' );
        $params += [ 'token' => $this->token ];
        $options['headers'] = [ 'content-type' => 'application/json' ];
        $options['body']  = json_encode( $params );

        try {
            $response = $this->client->request(
                 method: 'POST',
                    uri: $uri,
                options: $options
            );
        } catch (GuzzleException $e) {
            return self::error( message: $e->getMessage());
        }

        return $this->return_Results( response: $response );
    }



/* FORMAT API HTTP OUTPUT RESULTS
----------------------------------------------------------------------------- */

    /**
     * @param ResponseInterface $response Guzzle response object
     * @return Response Formatted Pushover response object
     */
    private function return_Results( ResponseInterface $response ) : Response
    {
        $output = new Response();
        $output->status         = $response->getStatusCode();
        $output->headers        = $response->getHeaders();
        $output->status_message = $response->getReasonPhrase();
        $output->body           = $response->getBody()->getContents() ?: new stdClass();

        if( $this->format === 'json' AND is_string( $output->body )) {
            $output->body = (object)json_decode( json: $output->body );
        }

        return $output;
    }



/* GENERATE ERROR OBJECT
----------------------------------------------------------------------------- */

    /**
     * @param string $message Error message to display
     * @return Response Error response object
     */
    public static function error( string $message ) : Response
    {
        $o = new Response();
        $o->status = 400;
        $o->status_message = 'Exception error message';

        $body = new stdClass();
        $body->status = 0;
        $body->errors = [ $message ];
        $o->body = $body;

        return $o;
    }
}