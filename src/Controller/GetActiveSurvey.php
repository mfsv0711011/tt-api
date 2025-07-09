<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Base\AbstractController;
use App\Repository\SurveyRepository;

class GetActiveSurvey extends AbstractController
{
    public function __invoke(SurveyRepository $surveyRepository): array
    {
        return $surveyRepository->findOneBy(['active' => true]);
    }
}
