<?php

namespace App\EventSubscriber;

use App\Entity\Band;
use App\Service\ImageDeletionService;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArtistAndProductIllustrationDeletionSubscriber implements EventSubscriberInterface
{

    private LoggerInterface $logger;

    private ImageDeletionService $imageDeletionService;

    public function __construct(LoggerInterface $logger, ImageDeletionService $imageDeletionService)
    {
        $this->logger = $logger;
        $this->imageDeletionService = $imageDeletionService;
    }

    public static function getSubscribedEvents(): array
    {
        // S'abonner à l'événement de suppression d'entité avant qu'elle ne soit supprimée
        return [
            BeforeEntityDeletedEvent::class => 'onBeforeEntityDeleted',
        ];
    }

    public function onBeforeEntityDeleted(BeforeEntityDeletedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        // Log pour vérifier si l'entité est bien capturée
        $this->logger->info('BeforeEntityDeletedEvent triggered for entity: ' . get_class($entity));

        if (!$entity instanceof Band) {
            return;
        }

        $artistIllustration = $entity->getIllustration();
        $product = $entity->getProduct();

        foreach ($product as $image) {

            if ($image) {

                $illustration = $image->getIllustration();
                $illustrationAlt = $image->getIllustrationAlt();
                $allProductIllustrations = [$illustration, $illustrationAlt];

                foreach ($allProductIllustrations as $illustrationByProduct) {

                    $this->imageDeletionService->deleteImage('products', $illustrationByProduct);
                }
            }
        }

        $this->imageDeletionService->deleteImage('artists', $artistIllustration);
    }

}