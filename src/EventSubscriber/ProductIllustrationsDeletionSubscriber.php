<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Service\ImageDeletionService;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class ProductIllustrationsDeletionSubscriber implements EventSubscriberInterface
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

        if (!$entity instanceof Product) {
            return;
        }

        $illustrations = [$entity->getIllustration(), $entity->getIllustrationAlt()];

        foreach ($illustrations as $image) {
            if ($image) {

                $this->imageDeletionService->deleteImage('products', $image);
            }
        }
    }

}