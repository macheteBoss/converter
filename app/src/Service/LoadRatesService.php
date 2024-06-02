<?php

namespace App\Service;

use App\DBAL\Types\CurrencyType;
use App\DependencyInjection\Traits\EntityManagerInterfaceInjectionTrait;
use App\DTO\RateDTO;
use App\Entity\Rate;
use App\Util\DateUtil;
use DateTime;
use GuzzleHttp\Exception\GuzzleException;

class LoadRatesService
{
    use EntityManagerInterfaceInjectionTrait;

    /**
     * @var array
     */
    protected array $ratesDTO = [];

    /**
     * @param DateTime $date
     *
     * @throws GuzzleException
     */
    public function execute(DateTime $date): void
    {
        $formatDate = $date->format(DateUtil::DATE_FORMAT);

        $client = new \GuzzleHttp\Client();

        $currencies = CurrencyType::getChoices();

        foreach ($currencies as $currency) {
            $stringCurrencies = implode(',', CurrencyType::getChoicesWithoutOne($currency));
            $request          = $client->request('GET', 'https://api.freecurrencyapi.com/v1/historical', [
                'query' => [
                    'apikey'         => 'fca_live_otqDU4h02wTFimyLK1AECzcZNkZjUwF5oorGhHFy',
                    'base_currency'  => $currency,
                    'currencies'     => $stringCurrencies,
                    'date'           => $formatDate,
                ]
            ]);

            $response = json_decode($request->getBody()->getContents(), true);
            $resultCurrencies = $response['data'][$formatDate];

            $this->executeRatesDTO($currency, $resultCurrencies);
        }

        if (!empty($this->ratesDTO)) {
            /** @var RateDTO $rateDTO */
            foreach ($this->ratesDTO as $rateDTO) {
                $rate = $this->em->getRepository(Rate::class)->findOneBy(['currencyFrom' => $rateDTO->getCurrencyFrom(), 'currencyTo' => $rateDTO->getCurrencyTo()]);

                if ($rate === null) {
                    $rate = (new Rate())
                        ->setCurrencyFrom($rateDTO->getCurrencyFrom())
                        ->setCurrencyTo($rateDTO->getCurrencyTo())
                        ->setValue($rateDTO->getValue())
                    ;

                    $this->em->persist($rate);
                } else {
                    $rate->setValue($rateDTO->getValue());
                }
            }

            $this->em->flush();
        }
    }

    private function executeRatesDTO(string $baseCurrency, array $currencies): void
    {
        foreach ($currencies as $currency => $value) {
            $this->ratesDTO[] = (new RateDTO())
                ->setCurrencyFrom($baseCurrency)
                ->setCurrencyTo($currency)
                ->setValue($value)
            ;
        }
    }
}