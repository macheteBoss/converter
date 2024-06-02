<?php

namespace App\DTO;

use App\Entity\Rate;

class ComputeLogDTO
{
    private ?Rate $rate = null;

    private string $sum;

    public function getRate(): ?Rate
    {
        return $this->rate;
    }

    public function setRate(?Rate $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getSum(): ?int
    {
        return is_string($this->sum) ? (int) $this->sum : $this->sum;
    }

    public function setSum(string $sum): self
    {
        $this->sum = $sum;

        return $this;
    }
}