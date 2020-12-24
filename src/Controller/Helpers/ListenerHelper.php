<?php

namespace App\Controller\Helpers;

use App\Entity\Skills;
use App\Entity\Company;
use App\Entity\Expertise;
use App\Controller\AbstractController;
use App\Repository\ExpertiseRepository;


class ListenerHelper extends AbstractController
{





    public function companyListener(string $data)
    {
        $company = $this->companyRepository->findOneBy(['name' => $data]);

        if (\is_null($company)) {
            $companys = new Company();
            $companys->setName($data);
            $em = $this->getDoctrine()->getManager();
            $em->persist($companys);
            $em->flush();
        } else {
            $companys = $company;
        }

        return $companys;
    }
}
