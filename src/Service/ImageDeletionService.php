<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImageDeletionService
{
    private Filesystem $filesystem;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->filesystem = new Filesystem();
        $this->logger = $logger;
    }

    public function deleteImage(string $dir, string $illustration): void
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/' . $dir . '/' . $illustration;
        $this->logger->info('Trying to delete image: ' . $filePath);

        $realFilePath = realpath($filePath);

        if ($realFilePath && $this->filesystem->exists($realFilePath)) {
            try {
                $this->filesystem->remove($realFilePath);
                $this->logger->info('Deleted image: ' . $realFilePath);
            } catch (\Exception $e) {
                $this->logger->error('Failed to delete image: ' . $e->getMessage());
            }
        } else {
            $this->logger->warning('Image not found: ' . $filePath);
        }
    }
}