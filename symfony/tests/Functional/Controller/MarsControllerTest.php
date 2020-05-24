<?php

namespace App\Tests\Functional\Controller;

use App\Entity\MarsResponse;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class MarsControllerTest extends WebTestCase
{
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function testWrongDate()
    {
        $this->client->request(Request::METHOD_GET, '/mars/time', [
            'earthDate' => '2323/55'
        ]);
        $this->assertTrue($this->client->getResponse()->isClientError());
    }

    /**
     * @dataProvider getData
     * @param string $date
     * @param string $response
     */
    public function testRightResponse(string $date, string $response): void
    {
        $this->client->request(Request::METHOD_GET, '/mars/time', [
            'earthDate' => $date
        ]);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals($response, $this->client->getResponse()->getContent());
    }

    public function getData(): array
    {
        return [
            ['2010-10-20', json_encode(['data' => new MarsResponse('48,630.58234', '13:58:35')])],
            ['2020-09-19 13:20:00', json_encode(['data' => new MarsResponse('52,156.21388', '05:07:59')])],
            ['2020-09-19 13:20:00', json_encode(['data' => new MarsResponse('52,156.21388', '05:07:59')])],
            ['2000-06-1 16:00:00', json_encode(['data' => new MarsResponse('44,939.71556', '17:10:25')])],
        ];
    }
}