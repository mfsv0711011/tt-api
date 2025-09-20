<?php

declare(strict_types=1);

namespace App\Entity\Interfaces;

use App\Entity\Company;

interface CompanySettableInterface
{
    public function setCompany(Company $company): static;
}
