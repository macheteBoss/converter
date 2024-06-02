<?php

namespace App\Controller;

use App\DependencyInjection\Traits\ComputeLogInjectionTrait;
use App\DTO\ComputeLogDTO;
use App\Form\Type\ComputeLogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MainController extends AbstractController
{
    use ComputeLogInjectionTrait;

    public function index(): Response
    {
        $form = $this->createForm(ComputeLogType::class);

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ComputeLogDTO $logDTO */
            $logDTO = $form->getData();

            try {
                if ($logDTO->getRate() === null) {
                    throw new \Exception('Rate not found');
                }
                if ($logDTO->getSum() < 0) {
                    throw new \Exception('Expected amount greater than 0');
                }

                $this->getComputeLogService()->createFromDTO($logDTO);
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }

            $response = new RedirectResponse('/');
            $response->prepare($request);

            return $response->send();
        }

        return $this->render('Main/index.html.twig', [
            'logs' => $this->getComputeLogService()->getComputeLogs(),
            'form' => $form->createView(),
        ]);
    }
}