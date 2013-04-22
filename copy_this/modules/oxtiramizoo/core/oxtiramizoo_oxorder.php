<?php


/**
 * Extends oxorder class. Overrides method to allow send order to the API
 */
class oxTiramizoo_oxorder extends oxTiramizoo_oxorder_parent
{


    public function finalizeOrder( oxBasket $oBasket, $oUser, $blRecalculatingOrder = false )
    {
        $iRet = parent::finalizeOrder($oBasket, $oUser, $blRecalculatingOrder);

        if (oxSession::getVar('sShipSet') == oxTiramizoo_DeliverySet::TIRAMIZOO_DELIVERY_SET_ID) {

            $oTiramizooDeliverySet = oxRegistry::get('oxTiramizoo_DeliverySet');

            $oTiramizooWindow = $oTiramizooDeliverySet->getSelectedTimeWindow();

            $oRetailLocation = $oTiramizooDeliverySet->getRetailLocation();
            $oUser = $oTiramizooDeliverySet->getUser();
            $oDeliveryAddress = $oTiramizooDeliverySet->getDeliveryAddress();

            $oCreateOrderData = new oxTiramizoo_CreateOrderData($oTiramizooWindow, $oBasket, $oRetailLocation);
            $oCreateOrderData->buildPickup();
            $oCreateOrderData->buildDelivery($oUser, $oDeliveryAddress);
            $oCreateOrderData->buildItems();
            $oTiramizooData = $oCreateOrderData->getCreatedTiramizooOrderDataObject();

            $tiramizooResult = $oTiramizooDeliverySet->getTiramizooApi()->sendOrder($oTiramizooData);

            if (!in_array($tiramizooResult['http_status'], array(201))) {

                // Uncomment to debug
                // echo '<div>';
                // echo json_encode($tiramizooData);
                // echo json_encode($tiramizooResult);
                // echo '</div>';
                // 

                $oSendOrderJob = new oxTiramizoo_SendOrderJob();
                $oSendOrderJob->setExternalId($this->getId());
                $oSendOrderJob->setParams(array('api_token' => $oTiramizooDeliverySet->getApiToken()));            
                $oSendOrderJob->save();

                // $errorMessage = oxLang::getInstance()->translateString('oxTiramizoo_post_order_error', oxLang::getInstance()->getBaseLanguage(), false);
                // throw new oxTiramizoo_SendOrderException( $errorMessage );
            }

            $oTiramizooOrderExtended = oxTiramizoo_OrderExtended::findOneByFiltersOrCreate(array('oxorderid' => $this->getId()));

            $oTiramizooOrderExtended->oxtiramizooorderextended__tiramizoo_response = new oxField(base64_encode(serialize($tiramizooResult)), oxField::T_RAW);
            $oTiramizooOrderExtended->oxtiramizooorderextended__tiramizoo_request_data = new oxField(base64_encode(serialize($oTiramizooData)), oxField::T_RAW);
            $oTiramizooOrderExtended->oxtiramizooorderextended__tiramizoo_status = new oxField($tiramizooResult['response']->state, oxField::T_RAW);
            $oTiramizooOrderExtended->oxtiramizooorderextended__tiramizoo_external_id = new oxField($oTiramizooData->external_id, oxField::T_RAW);
            $oTiramizooOrderExtended->oxtiramizooorderextended__tiramizoo_tracking_url = new oxField($tiramizooResult['response']->tracking_url . '?locale=' . $sCurrentLang, oxField::T_RAW);
            $oTiramizooOrderExtended->oxtiramizooorderextended__oxorderid = new oxField($this->getId());

            $oTiramizooOrderExtended->save();
        }

        return $iRet;
    }
}