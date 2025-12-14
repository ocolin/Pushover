<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use Ocolin\GlobalType\GT;
use Exception;

class HTTP
{
    /**
     * @var Client Guzzle HTTP client.
     */
    private Client $client;

    /**
     * @var string API auth token for app.
     */
    private string $token;

    /**
     * @var string The API end point URI.
     */
    private string $endpoint;

    /**
     * @var string JSON or XML response.
     */
    private string $format;

    private const API_URL = 'https://api.pushover.net/1/';


/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $token API Auth token.
     * @param string $format JSON or XML response format.
     * @param bool $verify Verify SSL connection.
     * @param int $timeout HTTP Timeout.
     */
    public function __construct(
        ?string $token,
         string $format = 'json',
           bool $verify = true,
            int $timeout = 20
    )
    {
        $this->token  = $token ?? GT::envString( name: 'PUSHOVER_API_TOKEN' );

        $this->format = $format;

        $this->client = new Client([
            'base_uri'        => self::API_URL,
            'verify'          => $verify,
            'http_errors'     => false,
            'timeout'         => $timeout,
            'connect_timeout' => $timeout,
            'headers'         => [
                'Content-Type'  => 'application/json; charset=utf-8',
                'User-Agent'    => 'Pushover PHP Client 2.0',
            ]
        ]);
    }



/* GET REQUEST
----------------------------------------------------------------------------- */

    /**
     * @param string $uri API end point URI.
     * @param string[]|object $query URI query parameters.
     * @return Response Response object from API.
     * @throws GuzzleException
     */
    public function get( string $uri, array|object $query = [] ): Response
    {
        $this->endpoint = $uri;
        $this->trim_Path();
        if( gettype( $query ) === 'object' ) { $query = (array)$query; }
        if( empty( $query['token'])) { $query['token'] = $this->token; }

        return $this->format_Response( response: $this->client->get(
            uri: $this->endpoint, options: ['query' => $query ]
        ));
    }



/* POST REQUEST
----------------------------------------------------------------------------- */

    /**
     * @param string $uri End point URI.
     * @param array<string, string|int|float>|object $params POST parameters for request body.
     * @return Response Response object from API.
     * @throws GuzzleException
     */
    public function post( string $uri, array|object $params = [] ): Response
    {
        $this->endpoint = $uri;
        $this->trim_Path();
        if( gettype( $params ) === 'object' ) { $params = (array)$params; }
        $params['token'] = $this->token;

        return $this->format_Response( response: $this->client->post(
            uri: $this->endpoint, options: ['json' => $params ]
        ));
    }



/* POST ATTACHMENT REQUEST
----------------------------------------------------------------------------- */

    /**
     * @param string $uri API endpoint URI.
     * @param array<string, string|int|float>|object $params POST parameters to send.
     * @return Response API server response.
     * @throws Exception
     * @throws GuzzleException
     */
    public function multipart( string $uri, array|object $params = [] ): Response
    {
        $this->endpoint = $uri;
        $this->trim_Path();
        if( gettype( $params ) === 'object' ) { $params = (array)$params; }
        $params['token'] = $this->token;

        if( empty( $params['attachment'])) {
            throw new Exception(
                message: 'Attachment function requires attachment field.'
            );
        }
        $multipart = [];
        foreach( $params as $key => $value ) {
            if( $key === 'attachment' ) {
                $multipart[] = [
                    'name'     => $key,
                    'contents' => Utils::tryFopen( filename: $value, mode: 'r' )
                ];
            }
            else {
                $multipart[] = [
                    'name'     => $key,
                    'contents' => $value
                ];
            }
        }

        return $this->format_Response( response: $this->client->post(
            uri: $this->endpoint, options: [ 'multipart' => $multipart ]
        ));
    }



/* FORMAT API HTTP RESPONSE
----------------------------------------------------------------------------- */

    /**
     * @param ResponseInterface $response Guzzle HTTP response.
     * @return Response Formatted API response.
     */
    public function format_Response( ResponseInterface $response ): Response
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



/* REMOVE DUPLICATE SLASHES IN URL
----------------------------------------------------------------------------- */

    /**
     * If both the base URL and the end point path have root slash, remove
     * the one from end point to eliminate a double slash in the final URL.
     *
     */
    private function trim_Path() : void
    {
        if(
            str_starts_with( haystack: $this->endpoint, needle: '/' ) AND
            str_ends_with( haystack: self::API_URL, needle: '/' )
        ) {
            $this->endpoint =  trim( string: $this->endpoint, characters: '/' );
        }
    }
}
