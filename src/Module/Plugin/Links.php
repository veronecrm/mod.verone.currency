<?php
/**
 * Verone CRM | http://www.veronecrm.com
 *
 * @copyright  Copyright (C) 2015 Adam Banaszkiewicz
 * @license    GNU General Public License version 3; see license.txt
 */

namespace App\Module\Currency\Plugin;

use CRM\App\Module\Plugin;

class Links extends Plugin
{
    public function dashboard()
    {
        if($this->acl('mod.Currency.Currency', 'mod.Currency')->isAllowed('core.module'))
        {
            return [
                [
                    'ordering' => 10,
                    'icon' => 'fa fa-euro',
                    'icon-type' => 'class',
                    'name' => $this->t('currencies'),
                    'href' => $this->createUrl('Currency', 'Currency')
                ]
            ];
        }
    }
}
