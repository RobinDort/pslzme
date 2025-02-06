<?php
namespace RobinDort\PslzmeLinks\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use RobinDort\PslzmeLinks\RobinDortPslzmeLinksBundle;

class Plugin implements BundlePluginInterface, RoutingPluginInterface {
    public function getBundles(ParserInterface $parser): array {
        return [
            BundleConfig::create(RobinDortPslzmeLinksBundle::class)
            ->setLoadAfter([
                ContaoCoreBundle::class,
            ]),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        $file = __DIR__.'/../../config/routes.yaml';
        return $resolver->resolve($file)->load($file);
    }
}
?>