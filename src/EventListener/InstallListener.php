<?php
namespace RobinDort\PslzmeLinks\EventListener;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class InstallListener
{
    private $filesystem;
    private $projectDir;

    public function __construct(KernelInterface $kernel)
    {
        $this->filesystem = new Filesystem();
        $this->projectDir = $kernel->getProjectDir();
    }


    public function copyTemplates()
    {
        // Make sure the output files are copied to the global template folder in order for the pslzme text content element to use them properly.
        $sourceDir = __DIR__ .  '/../Resources/contao/templates/outputs';
        $targetDir = $this->projectDir . '/templates/pslzme';

        try {

            if (!is_dir($sourceDir)) {
                throw new InvalidFileException("Source directory path does not exist or is not a directory");
            }

            if (!$this->filesystem->exists($targetDir)) {
                $this->filesystem->mkdir($targetDir);

                // Copy all template files
                $this->filesystem->mirror($sourceDir, $targetDir);
            }
        } catch (InvalidFileException $ife) {
            System::log($ife->getErrorMsg(), __METHOD__, TL_ERROR);
        }
    }
}

?>