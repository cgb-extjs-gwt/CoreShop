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

namespace CoreShop\Component\Index\Interpreter;

use CoreShop\Component\Index\Model\IndexableInterface;
use CoreShop\Component\Index\Model\IndexColumnInterface;
use CoreShop\Component\Registry\ServiceRegistryInterface;

class RelationalNestedInterpreter implements RelationInterpreterInterface
{
    use NestedTrait;

    /**
     * @param ServiceRegistryInterface $interpreterRegistry
     */
    public function __construct(ServiceRegistryInterface $interpreterRegistry)
    {
        $this->interpreterRegistry = $interpreterRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function interpretRelational($value, IndexableInterface $indexable, IndexColumnInterface $config, $interpreterConfig = [])
    {
        $this->assert($interpreterConfig);

        return $this->loop($value, $interpreterConfig, function ($value, InterpreterInterface $interpreter, $interpreterConfig) use ($indexable, $config) {
            if ($interpreter instanceof RelationInterpreterInterface) {
                return $interpreter->interpretRelational($value, $indexable, $config, $interpreterConfig);
            }

            return $value;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function interpret($value, IndexableInterface $indexable, IndexColumnInterface $config, $interpreterConfig = [])
    {
        $this->assert($interpreterConfig);

        return $this->loop($value, $interpreterConfig, function ($value, InterpreterInterface $interpreter, $interpreterConfig) use ($indexable, $config) {
            if ($interpreter instanceof InterpreterInterface) {
                return $interpreter->interpret($value, $indexable, $config, $interpreterConfig);
            }

            return $value;
        });
    }
}
