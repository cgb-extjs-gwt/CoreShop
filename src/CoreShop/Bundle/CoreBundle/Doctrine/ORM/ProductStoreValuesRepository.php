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

namespace CoreShop\Bundle\CoreBundle\Doctrine\ORM;

use CoreShop\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use CoreShop\Component\Core\Model\ProductInterface;
use CoreShop\Component\Core\Repository\ProductStoreValuesRepositoryInterface;
use CoreShop\Component\Store\Model\StoreInterface;

class ProductStoreValuesRepository extends EntityRepository implements ProductStoreValuesRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findForProduct(ProductInterface $product)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.product = :product')
            ->setParameter('product', $product->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findForProductAndStore(ProductInterface $product, StoreInterface $store)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.product = :product')
            ->andWhere('o.store = :store')
            ->setParameter('product', $product->getId())
            ->setParameter('store', $store)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
