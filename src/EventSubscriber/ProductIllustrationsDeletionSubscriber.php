<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;

class ProductIllustrationsDeletionSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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

        $filesystem = new Filesystem();
        $illustrations = [$entity->getIllustration(), $entity->getIllustrationAlt()];


        foreach ($illustrations as $image) {
            if ($image) {

                $filePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/products/' . $image;
                // Log pour vérifier le chemin du fichier
                $this->logger->info('File path: ' . $filePath);

                $realFilePath = realpath($filePath);

                if ($realFilePath !== false) {
                    // Log pour confirmer que le fichier existe
                    $this->logger->info('File exists, attempting to delete: ' . $realFilePath);

                    if ($filesystem->exists($realFilePath)) {
                        try {
                            $filesystem->remove($realFilePath);
                            $this->logger->info('File successfully deleted: ' . $realFilePath);
                        } catch (\IOExceptionInterface $exception) {
                            $this->logger->error('Error removing file: ' . $exception->getMessage());
                        }
                    }
                } else {
                    $this->logger->warning('File not found: ' . $filePath);
                }
            }
        }
    }

}