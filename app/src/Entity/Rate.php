<?php

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RateRepository::class)]
class Rate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name: "currency_from", length: 3)]
    private string $currencyFrom;

    #[ORM\Column(name: "currency_to", length: 3)]
    private string $currencyTo;

    #[ORM\Column(name: "value", precision: 20, scale: 10)]
    private string $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->currencyFrom . ' => ' . $this->currencyTo;
    }

    public function getCurrencyFrom(): ?string
    {
        return $this->currencyFrom;
    }

    public function setCurrencyFrom(string $currencyFrom): self
    {
        $this->currencyFrom = $currencyFrom;

        return $this;
    }

    public function getCurrencyTo(): ?string
    {
        return $this->currencyTo;
    }

    public function setCurrencyTo(string $currencyTo): self
    {
        $this->currencyTo = $currencyTo;

        return $this;
    }

    public function getValue(): ?float
    {
        return !is_string($this->value) ? $this->value : (float) $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
