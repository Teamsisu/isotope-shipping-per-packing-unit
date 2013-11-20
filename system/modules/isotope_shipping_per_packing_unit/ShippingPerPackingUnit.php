<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * @copyright  Isotope eCommerce Workgroup 2009-2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @author     Fred Bliss <fred.bliss@intelligentspark.com>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * 
 * @package    isotope_shipping_per_packing_unit
 * @copyright  Team sisu GmbH
 * @author     Martin Treml
 * @author     Johannes Tober
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


class ShippingPerPackingUnit extends IsotopeShipping
{

	/**
	 * Return an object property
	 *
	 * @access public
	 * @param string
	 * @return mixed
	 */
	public function __get($strKey)
	{
		switch( $strKey )
		{
			case 'price':
				return $this->Isotope->calculatePrice($this->getPrice(), $this, 'price', $this->arrData['tax_class']);
				break;
		}

		return parent::__get($strKey);
	}


	/**
	 * Get the checkout surcharge for this shipping method
	 */
	public function getSurcharge($objCollection)
	{
		$fltPrice = $this->getPrice();

		if ($fltPrice == 0)
		{
			return false;
		}

		return $this->Isotope->calculateSurcharge(
								$fltPrice,
								($GLOBALS['TL_LANG']['MSC']['shippingLabel'] . ' (' . $this->label . ')'),
								$this->arrData['tax_class'],
								$objCollection->getProducts(),
								$this);
	}


	/**
	 * Calculate the price based on module configuration
	 * @return float
	 */
	private function getPrice()
	{
		
        $tmpData = deserialize($this->arrData['packing_quantity']);
        
        // set product type as key to unique the fields
        foreach($tmpData AS $value){
            $calculatedFieldData[$value['product_types']] = $value;
            $calculatedFieldData[$value['product_types']]['requested_quantity'] = 0;
        }
        
        $products = $this->Isotope->Cart->getProducts();
        
        // set requested_quantity
        foreach($products AS $product){
            if(isset($calculatedFieldData[$product->type])){
                $calculatedFieldData[$product->type]['requested_quantity'] += $product->quantity_requested;
            }
        }
        
        $price = 0;
        
        // calcualte
        foreach($calculatedFieldData AS $data){
            
            if($data['quantity'] == 0){
               $price += $data['price'];
               continue;
            }
            
            if($data['quantity'] == 1){
               $price += $data['requested_quantity']*$data['price'];
               continue;
            }
            
            if($data['quantity'] > 1){
                
                if($data['requested_quantity'] % $data['quantity'] != 0){
                    $amount = ceil($data['requested_quantity']/$data['quantity']);
                    $price += $amount*$data['price'];
                }else{
                    $amount = $data['requested_quantity']/$data['quantity'];
                    $price += $amount*$data['price'];
                }
                
            }
            
        }
        
        return $price;
        
	}

}

