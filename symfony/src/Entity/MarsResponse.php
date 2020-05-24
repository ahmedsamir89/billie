<?php

namespace App\Entity;

use JsonSerializable;

class MarsResponse implements JsonSerializable
{
    private $msd;
    private $mtc;

    public function __construct(string $msd, string $mtc)
    {
        $this->msd = $msd;
        $this->mtc = $mtc;
    }


    public function jsonSerialize(): array
    {
        return [
            'MarsSolDate' => $this->msd,
            'MartianCoordinateTime' => $this->mtc
        ];
    }
}