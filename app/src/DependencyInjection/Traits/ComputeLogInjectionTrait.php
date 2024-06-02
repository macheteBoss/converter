<?php

namespace App\DependencyInjection\Traits;

use App\Service\ComputeLogService;

trait ComputeLogInjectionTrait
{
    /**
     * @var ComputeLogService
     */
    protected ComputeLogService $computeLogService;

    /**
     * @required
     *
     * @param ComputeLogService $computeLogService
     */
    public function setComputeLogService(ComputeLogService $computeLogService): void
    {
        $this->computeLogService = $computeLogService;
    }

    /**
     * @return ComputeLogService
     */
    public function getComputeLogService(): ComputeLogService
    {
        return $this->computeLogService;
    }
}