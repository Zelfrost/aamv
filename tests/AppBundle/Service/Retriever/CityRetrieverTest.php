<?php

namespace AppBundle\Service\Retriever;

use AppBundle\Service\Retriever\CityRetriever;
use Buzz\Message\Response;
use \Mockery as m;

class CityRetrieverTest extends \PHPUnit_Framework_TestCase
{
    public function testWithoutArrayAsResponse()
    {
        $response = m::mock('Buzz\Message\Response');
        $response->shouldReceive('getContent')->once()->withNoArgs()->andReturn('bad-json');

        $browser = m::mock('Buzz\Browser');
        $browser
            ->shouldReceive('get')
            ->once()
            ->with('http://www.citysearch-api.com/fr/city?login=login&apikey=key&cp=59&ville=bad-json')
            ->andReturn($response);

        $retriever = new CityRetriever($browser, 'login', 'key');
        $cities = $retriever->retrieve('bad-json');

        $this->assertEmpty($cities);
    }

    public function testWithEmptyArrayAsResponse()
    {
        $response = m::mock('Buzz\Message\Response');
        $response->shouldReceive('getContent')->once()->withNoArgs()->andReturn('{}');

        $browser = m::mock('Buzz\Browser');
        $browser
            ->shouldReceive('get')
            ->once()
            ->with('http://www.citysearch-api.com/fr/city?login=login&apikey=key&cp=59&ville=empty-array')
            ->andReturn($response);

        $retriever = new CityRetriever($browser, 'login', 'key');
        $cities = $retriever->retrieve('empty-array');

        $this->assertEmpty($cities);
    }

    public function testArrayWithoutResultAsResponse()
    {
        $response = m::mock('Buzz\Message\Response');
        $response->shouldReceive('getContent')->once()->withNoArgs()->andReturn('{"results":[]}');

        $browser = m::mock('Buzz\Browser');
        $browser
            ->shouldReceive('get')
            ->once()
            ->with('http://www.citysearch-api.com/fr/city?login=login&apikey=key&cp=59&ville=array-without-result')
            ->andReturn($response);

        $retriever = new CityRetriever($browser, 'login', 'key');
        $cities = $retriever->retrieve('array-without-result');

        $this->assertEmpty($cities);
    }

    public function testArrayWithInvalidResultResponse()
    {
        $response = m::mock('Buzz\Message\Response');
        $response->shouldReceive('getContent')->once()->withNoArgs()->andReturn('{"results":[{"test":"test"}]}');

        $browser = m::mock('Buzz\Browser');
        $browser
            ->shouldReceive('get')
            ->once()
            ->with('http://www.citysearch-api.com/fr/city?login=login&apikey=key&cp=59&ville=array-with-invalid-result')
            ->andReturn($response);

        $retriever = new CityRetriever($browser, 'login', 'key');
        $cities = $retriever->retrieve('array-with-invalid-result');

        $this->assertEmpty($cities);
    }

    public function testArrayWithValidResultResponse()
    {
        $response = m::mock('Buzz\Message\Response');
        $response->shouldReceive('getContent')->once()->withNoArgs()->andReturn('{"results":[{"ville":"test"}]}');

        $browser = m::mock('Buzz\Browser');
        $browser
            ->shouldReceive('get')
            ->once()
            ->with('http://www.citysearch-api.com/fr/city?login=login&apikey=key&cp=59&ville=array-with-valid-result')
            ->andReturn($response);

        $retriever = new CityRetriever($browser, 'login', 'key');
        $cities = $retriever->retrieve('array-with-valid-result');

        $this->assertEquals('test', $cities[0]['id']);
        $this->assertEquals('test', $cities[0]['text']);

        $this->assertCount(1, $cities);
    }
}