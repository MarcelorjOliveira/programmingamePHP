<?php

namespace AppBundle\ClassServices;

use Doctrine\ORM\EntityManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Application\Sonata\MediaBundle\Entity\Media;

class UploadListener {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getEm() {
        return $this->em;
    }

    public function onUpload(PostPersistEvent $event) {

        $file = $event->getFile();

        global $kernel;

        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $foto = new Media();

        $foto->setProviderName('sonata.media.provider.image');
        $foto->setContext('default');
        $foto->setBinaryContent($file);
        $foto->setUsuario($event->getRequest()->get('user'));
        $foto->setEnabled(true);
        
        $entityManager->persist($foto);
        $entityManager->flush();

        $response = $event->getResponse();

        $response['success'] = true;

        return $response;
    }

}
