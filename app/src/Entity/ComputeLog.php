<?php

namespace App\Entity;

use App\Repository\ComputeLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComputeLogRepository::class)]
class ComputeLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: "date", type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $date;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Rate $rate;

    #[ORM\Column(name: "sum", type: Types::BIGINT)]
    private int $sum;

    #[ORM\Column(name: "result", precision: 50, scale: 20)]
    private string $result;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRate(): ?Rate
    {
        return $this->rate;
    }

    public function setRate(Rate $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getSum(): ?int
    {
        return $this->sum;
    }

    public function setSum(int $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getResult(): ?float
    {
        return !is_string($this->result) ? $this->result : (float) $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }
}
