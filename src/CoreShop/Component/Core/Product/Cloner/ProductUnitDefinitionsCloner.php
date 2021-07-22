<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Component\Core\Product\Cloner;

use CoreShop\Component\Core\Model\ProductInterface;

class ProductUnitDefinitionsCloner implements ProductClonerInterface
{
    /**
     * {@inheritDoc}
     */
    public function clone(ProductInterface $product, ProductInterface $referenceProduct, bool $resetExistingData = false)
    {
        if ($product->hasUnitDefinitions() === true && $resetExistingData === false) {
            return;
        }

        $unitDefinitions = clone $referenceProduct->getUnitDefinitions();

        //Hack to get rid of the ID
        $reflectionClass = new \ReflectionClass($unitDefinitions);
        $property = $reflectionClass->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($unitDefinitions, null);

        foreach ($unitDefinitions->getUnitDefinitions() as $unitDefinition) {
            $reflectionClass = new \ReflectionClass($unitDefinition);
            $property = $reflectionClass->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($unitDefinition, null);
        }

        $product->setUnitDefinitions($unitDefinitions);
    }
}
