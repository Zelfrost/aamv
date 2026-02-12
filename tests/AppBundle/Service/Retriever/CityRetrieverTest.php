<?php

namespace AppBundle\Service\Retriever;

use AppBundle\Repository\CityRepository;
use AppBundle\Service\Retriever\CityRetriever;
use Mockery as m;

class CityRetrieverTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    public function testRetrieve()
    {
        $repository = m::mock(CityRepository::class);
        $repository->shouldReceive('findLike')->once()->with('test')->andReturn([['id' => 'test', 'text' => 'test']]);

        $retriever = new CityRetriever($repository);
        $cities = $retriever->retrieve('test');

        $this->assertCount(1, $cities);
        $this->assertEquals('test', $cities[0]['id']);
    }

    public function testRetrieveEmpty()
    {
        $repository = m::mock(CityRepository::class);
        $repository->shouldReceive('findLike')->once()->with('nonexistent')->andReturn([]);

        $retriever = new CityRetriever($repository);
        $cities = $retriever->retrieve('nonexistent');

        $this->assertEmpty($cities);
    }
}
