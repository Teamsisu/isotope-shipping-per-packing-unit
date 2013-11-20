<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * 
 * @package    isotope_shipping_per_packing_unit
 * @copyright  Team sisu GmbH
 * @author     Martin Treml
 * @author     Johannes Tober
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

$GLOBALS['TL_DCA']['tl_iso_shipping_modules']['palettes']['per_packing_unit'] = '{title_legend},name,label,type;{note_legend:hide},note;{price_legend},tax_class,packing_quantity;{config_legend},countries,subdivisions,postalCodes,minimum_total,maximum_total,product_types;{expert_legend:hide},guests,protected;{enabled_legend},enabled';



$GLOBALS['TL_DCA']['tl_iso_shipping_modules']['fields']['packing_quantity'] = array(
    'label'      => &$GLOBALS['TL_LANG']['tl_iso_shipping_modules']['packing_calculation'],
    'exclude'    => true,
    'inputType'  => 'multiColumnWizard',
    'eval'       => array(
        'tl_class'=>'clr',
        'columnFields'  => array(
            'product_types' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_iso_shipping_modules']['packing_product_types'],
                'exclude'    => true,
                'inputType'  => 'select',
                'foreignKey' => 'tl_iso_producttypes.name',
                'eval'       => array('style' => 'width:250px;margin-right:5px;'),
            ),
            'quantity' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_iso_shipping_modules']['packing_quantity'],
                'exclude'    => true,
                'inputType'  => 'text',
                'default'    => 0,
                'eval'       => array('maxlength'=>255, 'rgxp'=>'digit', 'style' => 'width:140px;margin-right:5px;'),
            ),
            'price' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_iso_shipping_modules']['packing_price'],
                'exclude'    => true,
                'inputType'  => 'text',
                'eval'       => array('maxlength'=>255, 'rgxp'=>'price', 'style' => 'width:140px', 'mandatory' => true),
            )
        )
    )
);