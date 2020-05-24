<?php
namespace App\Service;

use App\Entity\MarsResponse;
use DateTime;
use DateTimeZone;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MarsTimeConverterTest extends KernelTestCase
{
    /** @var MarsTimeConverter */
    private $timeConverter;

    protected function setUp(): void
    {
       $this->timeConverter = self::bootKernel()->getContainer()->get(MarsTimeConverter::class);
    }

    public function testWrongTimeZoneDate(): void
    {
        $this->expectException(Exception::class);
        $this->timeConverter->getMarsResponse(new DateTime('now',new DateTimeZone('GMT')));
    }

    /**
     * @dataProvider getData
     * @param DateTime $dateTime
     * @param MarsResponse $marsResponse
     * @throws Exception
     */
    public function testًRightDateAndResponse(DateTime $dateTime, MarsResponse $marsResponse): void
    {
        $actualResponse = $this->timeConverter->getMarsResponse($dateTime);
        $this->assertEquals($marsResponse->jsonSerialize(), $actualResponse->jsonSerialize());
    }

    public function getData(): array
    {
        $timeZone = new DateTimeZone('UTC');
        return [
          [new DateTime('2010-10-20',$timeZone ), new MarsResponse('48,630.58234', '13:58:35')],
          [new DateTime('2020-09-19 13:20:00',$timeZone ), new MarsResponse('52,156.21388', '05:07:59')],
          [new DateTime('2020-09-19 13:20:00',$timeZone ), new MarsResponse('52,156.21388', '05:07:59')],
          [new DateTime('2000-06-1 16:00:00',$timeZone ), new MarsResponse('44,939.71556', '17:10:25')],
        ];
    }
}