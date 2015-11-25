<?php
/**
 * Verone CRM | http://www.veronecrm.com
 *
 * @copyright  Copyright (C) 2015 Adam Banaszkiewicz
 * @license    GNU General Public License version 3; see license.txt
 */

namespace App\Module\Currency\Controller;

use CRM\App\Controller\BaseController;

/**
 * @section mod.Currency.Currency
 */
class Currency extends BaseController
{
    /**
     * @access core.module
     */
    public function indexAction($request)
    {
        return $this->render('', [
            'elements' => $this->repo()->findAll(),
            'default'  => $this->openSettings('app')->get('currency')
        ]);
    }

    /**
     * @access core.write
     */
    public function addAction()
    {
        return $this->render('form', [
            'currency' => $this->entity()
        ]);
    }

    /**
     * @access core.write
     */
    public function saveAction($request)
    {
        $currency = $this->entity()->fillFromRequest($request);
        $currencyDetails = $this->get('helper.currency')->get($request->get('currency'));

        $currency->setName($currencyDetails->name);
        $currency->setCode($currencyDetails->code);
        $currency->setSymbol($currencyDetails->symbol);

        $this->repo()->save($currency);

        $this->openUserHistory($currency)->flush('create', $this->t('currency'));

        $this->flash('success', $this->t('currencySaved'));

        if($request->get('apply'))
            return $this->redirect('Currency', 'Currency', 'edit', [ 'id' => $currency->getId() ]);
        else
            return $this->redirect('Currency', 'Currency', 'index');
    }


    /**
     * @access core.read
     */
    public function editAction($request)
    {
        $currency = $this->repo()->find($request->get('id'));

        if(! $currency)
        {
            $this->flash('danger', $this->t('currencyDoesntExists'));
            return $this->redirect('Currency', 'Currency', 'index');
        }

        return $this->render('form', [
            'currency' => $currency
        ]);
    }

    /**
     * @access core.write
     */
    public function updateAction($request)
    {
        $currency = $this->repo()->find($request->get('id'));

        if(! $currency)
        {
            $this->flash('danger', $this->t('currencyDoesntExists'));
            return $this->redirect('Currency', 'Currency', 'index');
        }

        $log = $this->openUserHistory($currency);

        $currency->fillFromRequest($request);

        $this->repo()->save($currency);

        $log->flush('change', $this->t('currency'));

        $this->flash('success', $this->t('currencyUpdated'));

        if($request->get('apply'))
            return $this->redirect('Currency', 'Currency', 'edit', [ 'id' => $currency->getId() ]);
        else
            return $this->redirect('Currency', 'Currency', 'index');
    }

    /**
     * @access core.delete
     */
    public function deleteAction($request)
    {
        $currency = $this->repo()->find($request->get('id'));

        if(! $currency)
        {
            $this->flash('danger', $this->t('currencyDoesntExists'));
            return $this->redirect('Currency', 'Currency', 'index');
        }

        $this->repo()->delete($currency);

        $this->openUserHistory($currency)->flush('delete', $this->t('currency'));

        $this->flash('success', $this->t('currencyDeleted'));

        return $this->redirect('Currency', 'Currency', 'index');
    }

    /**
     * @access core.write
     */
    public function updateDefaultCurrencyAction($request)
    {
        $currency = $this->repo()->find($request->get('id'));

        if(! $currency)
        {
            $this->flash('danger', $this->t('currencyDoesntExists'));
            return $this->redirect('Currency', 'Currency', 'index');
        }

        $app = $this->openSettings('app');

        $logger = $this->get('history.user.log');
        $logger->setModule('Settings');
        $logger->setEntityId(0);
        $logger->setEntityName('General');
        $logger->appendPreValue('currency', $app->get('currency'));

        $app->set('currency', $currency->getId());

        $logger->appendPostValue('currency', $app->get('currency'));
        $logger->flush(2, $this->t('settingsGeneralSettings'));

        return $this->responseAJAX([
            'message' => sprintf($this->t('currencyDefaultChanged'), $currency->getName()),
            'status'  => 'success'
        ]);
    }
}
