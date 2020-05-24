<?php
namespace App\Service;

use App\Entity\MarsResponse;
use DateTime;
use Exception;

class MarsTimeConverter
{
    private const THAI_OFFSET =  37;

    public function getMarsResponse(DateTime $utcTime): MarsResponse
    {
        if ($utcTime->getTimezone()->getName() !== 'UTC') {
            throw new Exception('Wrong time zone, Only UTC needed');
        }
        $j200 = $this->getJ200($utcTime);
        $msd = ((($j200 - 4.5) / 1.027491252) + 44796.0 - 0.00096);
        return new MarsResponse(
            number_format($msd, 5),
            $this->getFormattedMartianCoordinateTime($msd)
        );
    }

    private function getJ200(DateTime $utcTime): float
    {
        $milliSeconds = $utcTime->getTimestamp() * 1000;
        $jdUt = 2440587.5 + ($milliSeconds / 8.64E7);
        $jdTt = $jdUt + (self::THAI_OFFSET + 32.184) / 86400;
        return $jdTt - 2451545.0;
    }

    private function getFormattedMartianCoordinateTime(float $msd): string
    {
        $mtc = fmod($msd * 24, 24);
        return $this->convertDecimalToTime($mtc);
    }

    private function convertDecimalToTime(float $decimal): string
    {
        $seconds = ($decimal * 3600);
        $hours = floor($decimal);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        return sprintf('%s:%s:%s',
            $this->pad($hours),
            $this->pad($minutes),
            $this->pad(ceil($seconds))
        );
    }

    private function pad($num): string
    {
        return str_pad($num, 2, 0, STR_PAD_LEFT);
    }
}