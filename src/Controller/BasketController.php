<?php
/**
 * BasketController.php - Main Controller
 *
 * Main Controller for Basket Basket Plugin
 *
 * @category Controller
 * @package Contact\Basket
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Contact\Basket\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Contact\Basket\Model\BasketTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class BasketController extends CoreEntityController {
    /**
     * Basket Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * BasketController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param BasketTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,BasketTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'contactbasket-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    # Custom Code here:
    public function attachBasketForm($oItem = false) {

        $oForm = CoreEntityController::$aCoreTables['core-form']->select(['form_key'=>'contactbasket-single']);

        $aFields = [];
        $aUserFields = CoreEntityController::$oSession->oUser->getMyFormFields();
        if(array_key_exists('contactbasket-single',$aUserFields)) {
            $aFieldsTmp = $aUserFields['contactbasket-single'];
            if(count($aFieldsTmp) > 0) {
                # add all contact-base fields
                foreach($aFieldsTmp as $oField) {
                    if($oField->tab == 'basket-base') {
                        $aFields[] = $oField;
                    }
                }
            }
        }
        $aFieldsByTab = ['basket-base'=>$aFields];

        # Try to get adress table
        try {
            $oBasketTbl = CoreEntityController::$oServiceManager->get(BasketTable::class);
        } catch(\RuntimeException $e) {
            echo '<div class="alert alert-danger"><b>Error:</b> Could not load address table</div>';
            return [];
        }
        if(!isset($oBasketTbl)) {
            return [];
        }

        $aBaskets = [];
        $oPrimaryHistory = false;
        if($oItem) {
            # load contact addresses
            $oBaskets = $oBasketTbl->fetchAll(false, ['contact_idfs' => $oItem->getID()]);
            # get primary address
            if (count($oBaskets) > 0) {
                foreach ($oBaskets as $oAddr) {
                    $aBaskets[] = $oAddr;
                }
            }
        }
        # Pass Data to View - which will pass it to our partial
        return [
            # must be named aPartialExtraData
            'aPartialExtraData' => [
                # must be name of your partial
                'contact_basket'=> [
                    'oBaskets'=>$aBaskets,
                    'oForm'=>$oForm,
                    'aFormFields'=>$aFieldsByTab,
                ]
            ]
        ];
    }

}
