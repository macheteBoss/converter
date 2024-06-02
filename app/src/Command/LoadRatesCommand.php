<?php

namespace App\Command;

use App\Service\LoadRatesService;
use App\Util\DateUtil;
use DateTime;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadRatesCommand extends Command
{
    protected static $defaultName = 'converttask:load-rates';

    /**
     * @var LoadRatesService $loadRatesService
     */
    private LoadRatesService $loadRatesService;

    public function __construct(LoadRatesService $loadRatesService) {
        parent::__construct();

        $this->loadRatesService = $loadRatesService;
    }

    protected function configure(): void
    {
        $this
            ->addOption('date', null, InputOption::VALUE_OPTIONAL)
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $inputDate = $input->getOption('date');
        if (!empty($inputDate)) {
            $date = DateTime::createFromFormat(DateUtil::DATE_FORMAT, $inputDate);

            if (!$date instanceof DateTime) {
                $io->error(sprintf('Incorrect date "%s". Expected type: Y-m-d', $inputDate));

                return 0;
            }
        } else {
            $date = (DateUtil::now())->modify('-1 day');
        }

        try {
            $this->loadRatesService->execute($date);
        } catch (RequestException|GuzzleException|ClientException $e) {
            $contents = json_decode($e->getResponse()->getBody()->getContents(), true);
            if (array_key_exists('errors', $contents) !== false) {
                foreach ($contents['errors'] as $error) {
                    $io->error($error);
                }
            } else {
                $io->error($contents['message']);
            }
        }

        return 0;
    }
}