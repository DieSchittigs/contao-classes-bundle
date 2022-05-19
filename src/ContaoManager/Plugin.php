<?php

declare(strict_types=1);

namespace DieSchittigs\ClassesBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {

        return [
            BundleConfig::create('DieSchittigs\ClassesBundle\ClassesBundle')
                ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle'])
        ];
    }
}
