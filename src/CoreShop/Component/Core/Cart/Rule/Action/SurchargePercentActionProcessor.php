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

namespace CoreShop\Component\Core\Cart\Rule\Action;

use CoreShop\Component\Core\Cart\Rule\Applier\CartRuleApplierInterface;
use CoreShop\Component\Order\Cart\Rule\Action\CartPriceRuleActionProcessorInterface;
use CoreShop\Component\Order\Model\CartInterface;
use CoreShop\Component\Order\Model\ProposalCartPriceRuleItemInterface;

class SurchargePercentActionProcessor implements CartPriceRuleActionProcessorInterface
{
    /**
     * @var CartRuleApplierInterface
     */
    protected $cartRuleApplier;

    /**
     * @param CartRuleApplierInterface $cartRuleApplier
     */
    public function __construct(CartRuleApplierInterface $cartRuleApplier)
    {
        $this->cartRuleApplier = $cartRuleApplier;
    }

    /**
     * {@inheritdoc}
     */
    public function applyRule(CartInterface $cart, array $configuration, ProposalCartPriceRuleItemInterface $cartPriceRuleItem)
    {
        $discount = $this->getDiscount($cart, $configuration);

        if ($discount <= 0) {
            return false;
        }

        $this->cartRuleApplier->applySurcharge($cart, $cartPriceRuleItem, $discount, false);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function unApplyRule(CartInterface $cart, array $configuration, ProposalCartPriceRuleItemInterface $cartPriceRuleItem)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDiscount(CartInterface $cart, array $configuration)
    {
        $total = $cart->getSubtotal(false);
        $amount = (int) round(($configuration['percent'] / 100) * $total);

        return $this->getApplicableAmount($amount, $amount);
    }

    /**
     * @param int $cartAmount
     * @param int $ruleAmount
     *
     * @return int
     */
    protected function getApplicableAmount($cartAmount, $ruleAmount)
    {
        return min($cartAmount, $ruleAmount);
    }
}
