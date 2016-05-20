/**
 * CoreShop
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015 Dominik Pfaffenbauer (http://dominik.pfaffenbauer.at)
 * @license    http://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

pimcore.registerNS('pimcore.plugin.coreshop.filters.conditions');
pimcore.registerNS('pimcore.plugin.coreshop.filters.conditions.abstract');

pimcore.plugin.coreshop.filters.conditions.abstract = Class.create(pimcore.plugin.coreshop.filters.abstract, {
    elementType : 'conditions',

    getDefaultItems : function () {
        return [
            {
                xtype : 'textfield',
                name : 'label',
                width : 400,
                fieldLabel : t('label'),
                value : this.data.label
            },
            this.getFieldsComboBox()
        ];
    }
});
