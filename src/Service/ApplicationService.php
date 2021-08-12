<?php

namespace App\Service;

use App\Entity\Application;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

class ApplicationService
{
    protected ManagerRegistry $doctrine;
    protected Security $security;

    /**
     * @param Security $security
     */
    public function __construct(ManagerRegistry $doctrine, Security $security)
    {
        $this->doctrine = $doctrine;
        $this->security = $security;
    }


    public function create(Application $application)
    {
        if($this->security->getUser() === null){
            // Could be used Security Exception or some created for service exception.
            // Due to application is not large this is the best exception type here IMHO.
            throw new \LogicException("Can't save Application entity without user logged in.");
        }
        $application->setUser($this->security->getUser());
        $em = $this->doctrine->getManager();
        $em->persist($application);
        $em->flush();
    }
}
