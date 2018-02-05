<?php

namespace App\Doctrine;

use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MakesAdminExtension extends AbstractAdminExtension
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @param AdminInterface      $admin
     * @param ProxyQueryInterface $query
     * @param string              $context
     *
     * @throws \RuntimeException
     */
    public function configureQuery(AdminInterface $admin, ProxyQueryInterface $query, $context = 'list')
    {
        $query->andWhere('o.make_slug IN (:make_slugs)')->setParameter('make_slugs', $this->session->get('make_slugs'));

        return;
    }
}