<?php
namespace CirculoDeCredito\VerificacionExpediente\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use CirculoDeCredito\VerificacionExpediente\ApiException;
use CirculoDeCredito\VerificacionExpediente\Configuration;
use CirculoDeCredito\VerificacionExpediente\HeaderSelector;
use CirculoDeCredito\VerificacionExpediente\ObjectSerializer;

class ApiClient
{
    protected $client;
    protected $config;
    protected $headerSelector;
    
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }
    
    public function getConfig()
    {
        return $this->config;
    }
    
    public function getReporte($x_api_key, $request)
    {
        return $this->getReporteWithHttpInfo($x_api_key, $request);
    }
    
    public function getReporteWithHttpInfo($x_api_key,$request)
    {
        $returnType = '\CirculoDeCredito\VerificacionExpediente\Model\VerificacionExpedienteResponse';
        $request = $this->getReporteRequest($x_api_key, $request);

        try {
            $options = $this->createHttpClientOption();
            try {

	        $response = $this->client->send($request);

	    } catch (RequestException $e) {

                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() !== null ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() !== null ? $e->getResponse()->getBody() : null
                );
            }
            $statusCode = $response->getStatusCode();
            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
	    }

	    $responseBody = $response->getBody()->getContents();

	    return  ObjectSerializer::deserialize(json_decode($responseBody), $returnType);

        } catch (ApiException $e) {
            switch ($e->getCode()) {
		case 400:
                    $data = ObjectSerializer::deserialize(
                        json_decode($e->getResponseBody()->getContents()),
                        '\CirculoDeCredito\VerificacionExpediente\Model\ErroresResponse'
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        json_decode($e->getResponseBody()->getContents()),
                        '\CirculoDeCredito\VerificacionExpediente\Model\ErroresResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = ObjectSerializer::deserialize(
                        json_decode($e->getResponseBody()->getContents()),
                        '\CirculoDeCredito\VerificacionExpediente\Model\ErroresResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        json_decode($e->getResponseBody()->getContents()),
                        '\CirculoDeCredito\VerificacionExpediente\Model\ErroresResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 429:
                    $data = ObjectSerializer::deserialize(
                        json_decode($e->getResponseBody()->getContents()),
                        '\CirculoDeCredito\VerificacionExpediente\Model\ErroresResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        json_decode($e->getResponseBody()->getContents()),
                        '\CirculoDeCredito\VerificacionExpediente\Model\ErroresResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }
    
    public function getReporteAsync($x_api_key,$request)
    {
        return $this->getReporteAsyncWithHttpInfo($x_api_key, $request)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }
    
    public function getReporteAsyncWithHttpInfo($x_api_key, $request)
    {
        $returnType = '\CirculoDeCredito\VerificacionExpediente\Model\VerificacionExpedienteResponse';
        $request = $this->getReporteRequest($x_api_key, $request);
        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody;
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }
                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }
    
    protected function getReporteRequest($x_api_key, $request)
    {
        if ($x_api_key === null || (is_array($x_api_key) && count($x_api_key) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $x_api_key when calling getReporte'
            );
        }
        if ($request === null || (is_array($request) && count($request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $request when calling getReporte'
            );
        }
        $resourcePath = '/';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        if ($x_api_key !== null) {
            $headerParams['x-api-key'] = ObjectSerializer::toHeaderValue($x_api_key);
        }

        $_tempBody = null;
        if (isset($request)) {
            $_tempBody = $request;
        }
        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }
        if (isset($_tempBody)) {
            $httpBody = $_tempBody;
            
            if($headers['Content-Type'] === 'application/json') {
                if ($httpBody instanceof \stdClass) {
                    $httpBody = \GuzzleHttp\json_encode($httpBody);
                }
                if(is_array($httpBody)) {
                    $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($httpBody));
                }
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                $httpBody = new MultipartStream($multipartContents);
            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);
            } else {
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }
        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }
        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }
    
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }
        return $options;
    }
}
