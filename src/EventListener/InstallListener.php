<?php
namespace RobinDort\PslzmeLinks\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InstallListener implements EventSubscriberInterface
{
    private $framework;
    private $filesystem;
    private $kernel;

    public function __construct(ContaoFrameworkInterface $framework, KernelInterface $kernel)
    {
        $this->framework = $framework;
        $this->filesystem = new Filesystem();
        $this->kernel = $kernel;
    }

    public static function getSubscribedEvents()
    {
        return [
            'contao.install' => 'onInstall',
        ];
    }

    public function onInstall()
    {
        // Make sure the output files are copied to the global template folder in order for the pslzme text content element to use them properly.
        $templateDir = $this->kernel->getProjectDir() . '/templates';
        $extensionTemplateDir = $this->kernel->getProjectDir() . '/vendor/robindort/pslzme-links/src/Resources/contao/templates/outputs';

        if ($this->filesystem->exists($extensionTemplateDir)) {
            $this->filesystem->mirror($extensionTemplateDir, $templateDir);
        }
    }
}

?>