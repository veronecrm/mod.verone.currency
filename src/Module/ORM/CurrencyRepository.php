<?php
/**
 * Verone CRM | http://www.veronecrm.com
 *
 * @copyright  Copyright (C) 2015 Adam Banaszkiewicz
 * @license    GNU General Public License version 3; see license.txt
 */

namespace App\Module\Currency\ORM;

use CRM\ORM\Repository;

class CurrencyRepository extends Repository
{
    public $dbTable = '#__currency';

    public function getFieldsNames()
    {
        return [
            'id'     => 'ID',
            'name'   => $this->t('currencyName'),
            'code'   => $this->t('currencyCode'),
            'symbol' => $this->t('currencySymbol'),
            'rate'   => $this->t('currencyExchangeRate')
        ];
    }
}
