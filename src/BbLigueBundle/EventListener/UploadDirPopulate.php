<?php
namespace BbLigueBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use BbLigueBundle\Entity\Team;

class UploadDirPopulate
{
    private $app_dir;
    private $web_dir;
    private $upload_dir;

    public function __construct($app_dir, $web_dir, $upload_dir) {
        $this->app_dir = $app_dir;
        $this->web_dir = $web_dir;
        $this->upload_dir = $upload_dir;
    }
    protected function getUploadDir()
    {
        return $this->app_dir . $this->web_dir . $this->upload_dir;
    }
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Team) {
            $entity->setAbsPath( $this->getUploadDir() );
            $entity->setWebPath( $this->upload_dir );
        }
    }
}
