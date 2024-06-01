<?php

uses(
    Tests\DuskTestCase::class,
    // Illuminate\Foundation\Testing\DatabaseMigrations::class,
)->in('Browser');

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createRequestHistoryMiddleware(array &$container): callable
{
    return function (callable $handler) use (&$container) {
        return function (RequestInterface $request, array $options) use (&$container, $handler) {
            $container[] = $request;

            return $handler($request, $options);
        };
    };
}

function mockGuzzleClient(array $mockResponse, array &$requestContainer = []): Client
{
    $mockResponseStream = fopen('php://memory', 'r+');
    if (isset($mockResponse['text']) || isset($mockResponse['choices'])) {
        fwrite(
            $mockResponseStream,
            json_encode($mockResponse)."\n"
        );
    } else {
        $mockResponse = array_map(function ($data) {
            return 'data: '.json_encode($data);
        }, $mockResponse);
        fwrite(
            $mockResponseStream,
            \implode("\n", $mockResponse)."\n"
        );
    }
    rewind($mockResponseStream);

    $mock = new MockHandler([
        new Response(200, [], $mockResponseStream),
    ]);
    $handlerStack = HandlerStack::create($mock);

    // Add the history middleware
    $history = createRequestHistoryMiddleware($requestContainer);
    $handlerStack->push($history);

    return new Client(['handler' => $handlerStack]);
}
