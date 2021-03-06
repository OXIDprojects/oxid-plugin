<?php


class oxTiramizoo_CreateOrderDataExposed extends oxTiramizoo_CreateOrderData
{
    const TIRAMIZOO_SALT = 'oxTiramizoo';

    public $_sApiWebhookUrl = '/modules/oxtiramizoo/api.php';

    public $_oTiramizooData = null;

    public $_oTimeWindow = null;
    public $_oBasket = null;
    public $_oRetailLocation = null;


    public $_sExternalId = '';

    public $_aPackages = array();

    public $_oPickup = null;
    public $_oDelivery = null;

    public function _buildItem($oArticle)
    {
    	return parent::_buildItem($oArticle);
    }
}

class Unit_Modules_oxTiramizoo_core_TiramizooApi_oxTiramizooCreateOrderDataTest extends OxidTestCase
{
	protected $_oTiramizooCreateOrderData = null;

	protected function setUp()
	{
		$oBasket = $this->getMock('oxBasket', array(), array(), '', false);
		$oRetailLocation = $this->getMock('oxTiramizoo_RetailLocation', array(), array(), '', false);
		$oTimeWindow = $this->getMock('oxTiramizoo_TimeWindow', array(), array(), '', false);


	    $this->_oTiramizooCreateOrderData = new oxTiramizoo_CreateOrderDataExposed($oTimeWindow, $oBasket, $oRetailLocation);
		$this->_oTiramizooCreateOrderData->_oTiramizooData = new stdClass;
	}

	protected function tearDown()
	{
		oxUtilsObject::resetClassInstances();
        parent::tearDown();
	}


	public function testGetShopUrl()
	{
		$oTiramizooConfig = $this->getMock('oxTiramizoo_Config', array('getShopConfVar'));
	    $oTiramizooConfig->expects($this->any())
             			 ->method('getShopConfVar')
             			 ->will($this->returnValue('http://someurl.de'));

	    $this->_oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getTiramizooConfig'), array(), '', false);
	    $this->_oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getTiramizooConfig')
             					  ->will($this->returnValue($oTiramizooConfig));

		$this->assertEquals('http://someurl.de', $this->_oTiramizooCreateOrderData->getShopUrl());
	}

	public function testGetWebhookUrl()
	{
		$oTiramizooConfig = $this->getMock('oxTiramizoo_Config', array('getShopConfVar'));
	    $oTiramizooConfig->expects($this->any())
             			 ->method('getShopConfVar')
             			 ->will($this->returnValue('http://someurl.de'));

	    $this->_oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getTiramizooConfig'), array(), '', false);
	    $this->_oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getTiramizooConfig')
             					  ->will($this->returnValue($oTiramizooConfig));

		$this->assertEquals('http://someurl.de/modules/oxtiramizoo/api.php', $this->_oTiramizooCreateOrderData->getWebhookUrl());
	}

	public function testGetExternalId()
	{
		$sExternalId = $this->_oTiramizooCreateOrderData->getExternalId();

		$this->assertEquals($this->_oTiramizooCreateOrderData->_sExternalId, $sExternalId);
	}

	public function testGetBasket()
	{
		$this->assertTrue($this->_oTiramizooCreateOrderData->getBasket() instanceof oxBasket);
	}

	public function testGetTiramizooDataObject()
	{
		$this->assertEquals(new stdClass, $this->_oTiramizooCreateOrderData->getTiramizooDataObject());
	}

	public function testCreateTiramizooOrderDataObject()
	{
		$oExpectedTiramizooData = new stdClass();

        $oExpectedTiramizooData->description = 'some description';
        $oExpectedTiramizooData->external_id = 'some external id';
        $oExpectedTiramizooData->web_hook_url = 'webhook url';
        $oExpectedTiramizooData->pickup = oxNew('oxAddress');
        $oExpectedTiramizooData->delivery = oxNew('oxAddress');
        $oExpectedTiramizooData->packages = array();

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getDescription', 'getExternalId', 'getWebhookUrl'), array(), '', false);
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getDescription')
             					  ->will($this->returnValue('some description'));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getExternalId')
             					  ->will($this->returnValue('some external id'));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getWebhookUrl')
             					  ->will($this->returnValue('webhook url'));
		$oTiramizooCreateOrderData->_oPickup = oxNew('oxAddress');
		$oTiramizooCreateOrderData->_oDelivery = oxNew('oxAddress');
		$oTiramizooCreateOrderData->_aPackages = array();

		$this->assertEquals($oExpectedTiramizooData, $oTiramizooCreateOrderData->createTiramizooOrderDataObject());

		$oTiramizooCreateOrderData->_oPickup = null;
		$this->assertNotEquals($oExpectedTiramizooData, $oTiramizooCreateOrderData->createTiramizooOrderDataObject());
	}

	public function testGetCreatedTiramizooOrderDataObject()
	{
		$oExpectedTiramizooData = new stdClass();

        $oExpectedTiramizooData->description = 'some description';
        $oExpectedTiramizooData->external_id = 'some external id';
        $oExpectedTiramizooData->web_hook_url = 'webhook url';
        $oExpectedTiramizooData->pickup = oxNew('oxAddress');
        $oExpectedTiramizooData->delivery = oxNew('oxAddress');
        $oExpectedTiramizooData->packages = array();

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getDescription', 'getExternalId', 'getWebhookUrl'), array(), '', false);
		$oTiramizooCreateOrderData->_oTiramizooData = null;
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getDescription')
             					  ->will($this->returnValue('some description'));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getExternalId')
             					  ->will($this->returnValue('some external id'));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getWebhookUrl')
             					  ->will($this->returnValue('webhook url'));
		$oTiramizooCreateOrderData->_oPickup = oxNew('oxAddress');
		$oTiramizooCreateOrderData->_oDelivery = oxNew('oxAddress');
		$oTiramizooCreateOrderData->_aPackages = array();

		$this->assertEquals($oExpectedTiramizooData, $oTiramizooCreateOrderData->getCreatedTiramizooOrderDataObject());
	}


	public function testBuildPickup()
	{
		$oExpectedPickup = new stdClass();
		$oExpectedPickup->address_line = 'test address line 1';
		$oExpectedPickup->city = 'test city';
		$oExpectedPickup->postal_code = 'test postal_code';
		$oExpectedPickup->country_code = 'test country_code';
		$oExpectedPickup->name = 'test name';
		$oExpectedPickup->phone_number = 'test phone_number';
		$oExpectedPickup->after = '2012-04-01T19:00:00Z';
		$oExpectedPickup->before = '2012-04-01T21:00:00Z';

		$oTimeWindow = $this->getMock('oTiramizoo_TimeWindow', array('getPickupFrom', 'getPickupTo'));
	    $oTimeWindow->expects($this->any())
             		->method('getPickupFrom')
             		->will($this->returnValue('2012-04-01T19:00:00Z'));
	    $oTimeWindow->expects($this->any())
             		->method('getPickupTo')
             		->will($this->returnValue('2012-04-01T21:00:00Z'));

	    $oRetailLocation = $this->getMock('oxTiramizoo_RetailLocation', array('getConfVar'), array(), '', false);

        $aExpectedPickup = (array)$oExpectedPickup;
        $aExpectedPickup['address_line'] = 'test address line 1';

	    $oRetailLocation->expects($this->any())
             			->method('getConfVar')
             			->will($this->returnValue($aExpectedPickup));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('__construct'), array(), '', false);
		$oTiramizooCreateOrderData->_oTimeWindow = $oTimeWindow;
		$oTiramizooCreateOrderData->_oRetailLocation = $oRetailLocation;

		$this->assertEquals($oExpectedPickup, $oTiramizooCreateOrderData->buildPickup());
	}

	public function testGetDescription()
	{
		$oArticle1 = oxNew('oxArticle');
		$oArticle1->oxarticles__oxid = new oxField(1);
		$oArticle1->oxarticles__oxtitle = new oxField('Test product 1');

		$oArticle2 = oxNew('oxArticle');
		$oArticle2->oxarticles__oxid = new oxField(2);
		$oArticle2->oxarticles__oxtitle = new oxField('Test product 2');

		$oArticle3 = oxNew('oxArticle');
		$oArticle3->oxarticles__oxid = new oxField(3);
		$oArticle3->oxarticles__oxtitle = new oxField('Test product with very long title so this text should not be presented at all. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book');


		$oBasket = $this->getMock('oxBasket', array('getBasketArticles', 'getArtStockInBasket'), array(), '', false);
	    $oBasket->expects($this->any())
             	->method('getBasketArticles')
             	->will($this->returnValue(array($oArticle1, $oArticle2, $oArticle3)));
	    $oBasket->expects($this->at(1))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(1));
	    $oBasket->expects($this->at(2))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(2));
	    $oBasket->expects($this->at(3))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(3));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getBasket'), array(), '', false);
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getBasket')
             					  ->will($this->returnValue($oBasket));

		$this->assertEquals('Test product 1 (x1), Test product 2 (x2), Test product with very long title so this text should not be presented at all. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever', $oTiramizooCreateOrderData->getDescription());
	}

	public function testBuildDeliveryFromUser()
	{
		$oExpectedDelivery = new stdClass();
		$oExpectedDelivery->email = 'some.email@address.de';
		$oExpectedDelivery->address_line = 'test address line 1 number 777';
		$oExpectedDelivery->city = 'test city';
		$oExpectedDelivery->postal_code = 'test postal_code';
		$oExpectedDelivery->country_code = 'de';
		$oExpectedDelivery->phone_number = 'test phone_number';
		$oExpectedDelivery->name = 'company / fname lname';
		$oExpectedDelivery->after = '2012-04-01T19:00:00Z';
		$oExpectedDelivery->before = '2012-04-01T21:00:00Z';

		$oUser = $this->getMock('oxUser', array('__construct'), array(), '', false);

		$oUser->oxuser__oxusername = new oxField('some.email@address.de');
		$oUser->oxuser__oxstreet = new oxField('test address line 1');
		$oUser->oxuser__oxstreetnr = new oxField('number 777');
		$oUser->oxuser__oxcity = new oxField('test city');
		$oUser->oxuser__oxzip = new oxField('test postal_code');
		$oUser->oxuser__oxcountryid = new oxField('test country_code');
		$oUser->oxuser__oxfon = new oxField('test phone_number');
		$oUser->oxuser__oxfname = new oxField('fname');
		$oUser->oxuser__oxlname = new oxField('lname');
		$oUser->oxuser__oxcompany = new oxField('company');

		$oCountry = $this->getMock('oxcountry', array('load'), array(), '', false);
		$oCountry->oxcountry__oxisoalpha2 = new oxField('de');
        oxTestModules::addModuleObject('oxcountry', $oCountry);

		$oTimeWindow = $this->getMock('oTiramizoo_TimeWindow', array('getDeliveryFrom', 'getDeliveryTo'));
	    $oTimeWindow->expects($this->any())
             		->method('getDeliveryFrom')
             		->will($this->returnValue('2012-04-01T19:00:00Z'));
	    $oTimeWindow->expects($this->any())
             		->method('getDeliveryTo')
             		->will($this->returnValue('2012-04-01T21:00:00Z'));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('buildPickup'), array(), '', false);
		$oTiramizooCreateOrderData->_oTimeWindow = $oTimeWindow;

		$this->assertEquals($oExpectedDelivery, $oTiramizooCreateOrderData->buildDelivery($oUser, null));
	}

	public function testBuildDeliveryFromDelivery()
	{
		$oExpectedDelivery = new stdClass();
		$oExpectedDelivery->email = 'some.email@address.de';
		$oExpectedDelivery->address_line = 'test address line 1 number 777';
		$oExpectedDelivery->city = 'test city';
		$oExpectedDelivery->postal_code = 'test postal_code';
		$oExpectedDelivery->country_code = 'de';
		$oExpectedDelivery->phone_number = 'test phone_number';
		$oExpectedDelivery->name = 'company / fname lname';
		$oExpectedDelivery->after = '2012-04-01T19:00:00Z';
		$oExpectedDelivery->before = '2012-04-01T21:00:00Z';

		$oUser = $this->getMock('oxUser', array('__construct'), array(), '', false);

		$oUser->oxuser__oxusername = new oxField('some.email@address.de');
		$oUser->oxuser__oxstreet = new oxField('test address line 1');
		$oUser->oxuser__oxstreetnr = new oxField('number 777');
		$oUser->oxuser__oxcity = new oxField('test city');
		$oUser->oxuser__oxzip = new oxField('test postal_code');
		$oUser->oxuser__oxcountryid = new oxField('test country_code');
		$oUser->oxuser__oxfon = new oxField('test phone_number');
		$oUser->oxuser__oxfname = new oxField('fname');
		$oUser->oxuser__oxlname = new oxField('lname');
		$oUser->oxuser__oxcompany = new oxField('company');


		$oDeliveryAddress = $this->getMock('oxUser', array('__construct'), array(), '', false);

		$oDeliveryAddress->oxaddress__oxusername = new oxField('some.email@address.de');
		$oDeliveryAddress->oxaddress__oxstreet = new oxField('test address line 1');
		$oDeliveryAddress->oxaddress__oxstreetnr = new oxField('number 777');
		$oDeliveryAddress->oxaddress__oxcity = new oxField('test city');
		$oDeliveryAddress->oxaddress__oxzip = new oxField('test postal_code');
		$oDeliveryAddress->oxaddress__oxcountryid = new oxField('test country_code');
		$oDeliveryAddress->oxaddress__oxfon = new oxField('test phone_number');
		$oDeliveryAddress->oxaddress__oxfname = new oxField('fname');
		$oDeliveryAddress->oxaddress__oxlname = new oxField('lname');
		$oDeliveryAddress->oxaddress__oxcompany = new oxField('company');

		$oCountry = $this->getMock('oxcountry', array('load'), array(), '', false);
		$oCountry->oxcountry__oxisoalpha2 = new oxField('de');
        oxTestModules::addModuleObject('oxcountry', $oCountry);

		$oTimeWindow = $this->getMock('oTiramizoo_TimeWindow', array('getDeliveryFrom', 'getDeliveryTo'));
	    $oTimeWindow->expects($this->any())
             		->method('getDeliveryFrom')
             		->will($this->returnValue('2012-04-01T19:00:00Z'));
	    $oTimeWindow->expects($this->any())
             		->method('getDeliveryTo')
             		->will($this->returnValue('2012-04-01T21:00:00Z'));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('buildPickup'), array(), '', false);
		$oTiramizooCreateOrderData->_oTimeWindow = $oTimeWindow;

		$this->assertEquals($oExpectedDelivery, $oTiramizooCreateOrderData->buildDelivery($oUser, $oDeliveryAddress));
	}

	public function testBuildItems()
	{
        $aArticle1EffectiveData = array();
		$aArticle1EffectiveData['weight'] = 2;
		$aArticle1EffectiveData['width'] = 30;
        $aArticle1EffectiveData['length'] = 30;
        $aArticle1EffectiveData['height'] = 30;

        $aArticle2EffectiveData = array();
        $aArticle2EffectiveData['weight'] = 3;
        $aArticle2EffectiveData['width'] = 3;
        $aArticle2EffectiveData['length'] = 5;
        $aArticle2EffectiveData['height'] = 6;

        $aArticle3EffectiveData = array();
        $aArticle3EffectiveData['weight'] = 4;
        $aArticle3EffectiveData['width'] = 11;
        $aArticle3EffectiveData['length'] = 11;
        $aArticle3EffectiveData['height'] = 11;

        $oItem1 = new stdClass();
        $oItem1->weight = 2;
        $oItem1->width = 30;
        $oItem1->height = 30;
        $oItem1->length = 30;
        $oItem1->quantity = 1;
        $oItem1->description = 'Test product 1';
        $oItem1->bundle = true;

        $oItem2 = new stdClass();
        $oItem2->weight = 3;
        $oItem2->width = 3;
        $oItem2->height = 6;
        $oItem2->length = 5;
        $oItem2->quantity = 2;
        $oItem2->description = 'Test product 2';
        $oItem2->bundle = true;

        $oItem3 = new stdClass();
        $oItem3->weight = 4;
        $oItem3->width = 11;
        $oItem3->height = 11;
        $oItem3->length = 11;
        $oItem3->quantity = 3;
        $oItem3->description = 'Test product 4';
        $oItem3->bundle = true;

        $aExpectedItems = array($oItem1, $oItem2, $oItem3);

		$oArticle1 = oxNew('oxArticle');
		$oArticle1->oxarticles__oxid = new oxField(1);
		$oArticle1->oxarticles__oxtitle = new oxField('Test product 1');
		$oArticle1->oxarticles__oxstock = new oxField(3);

		$oArticle2 = oxNew('oxArticle');
		$oArticle2->oxarticles__oxid = new oxField(2);
		$oArticle2->oxarticles__oxtitle = new oxField('Test product 2');
		$oArticle2->oxarticles__oxstock = new oxField(2);

		$oArticle3 = oxNew('oxArticle');
		$oArticle3->oxarticles__oxid = new oxField(3);
		$oArticle3->oxarticles__oxtitle = new oxField('Test product 3');
		$oArticle3->oxarticles__oxstock = new oxField(4);
		$oArticle3->oxarticles__oxparentid = new oxField(4);

		$oArticle4 = oxNew('oxArticle');
		$oArticle4->oxarticles__oxid = new oxField(3);
		$oArticle4->oxarticles__oxtitle = new oxField('Test product 4');
		$oArticle4->oxarticles__oxstock = new oxField(4);


        oxTestModules::addModuleObject('oxArticle', $oArticle4);

	    $oArticleExtended = $this->getMock('oxTiramizoo_ArticleExtended', array(), array(), '', false);

        $oArticleExtended->expects($this->any())
             			 ->method('isEnabled')
             			 ->will($this->returnValue(true));

	    $oArticleExtended->expects($this->any())
             			 ->method('hasIndividualPackage')
             			 ->will($this->returnValue(false));

	    $oArticleExtended->expects($this->at(2))
             			 ->method('getEffectiveData')
             			 ->will($this->returnValue($aArticle1EffectiveData));

	    $oArticleExtended->expects($this->at(6))
             			 ->method('getEffectiveData')
             			 ->will($this->returnValue($aArticle2EffectiveData));

	    $oArticleExtended->expects($this->at(10))
             			 ->method('getEffectiveData')
             			 ->will($this->returnValue($aArticle3EffectiveData));

        oxTestModules::addModuleObject('oxTiramizoo_ArticleExtended', $oArticleExtended);


		$oBasket = $this->getMock('oxBasket', array('getBasketArticles', 'getArtStockInBasket'), array(), '', false);

	    $oBasket->expects($this->any())
             	->method('getBasketArticles')
             	->will($this->returnValue(array($oArticle1, $oArticle2, $oArticle3)));
	    $oBasket->expects($this->at(1))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(1));
	    $oBasket->expects($this->at(2))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(2));
	    $oBasket->expects($this->at(3))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(3));

        $oTiramizooConfig = $this->getMock('oxTiramizoo_Config', array('getShopConfVar'));
        $oTiramizooConfig->expects($this->any())
                         ->method('getShopConfVar')
                         ->will($this->returnValue(1));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getTiramizooConfig', 'getBasket'), array(), '', false);
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getTiramizooConfig')
             					  ->will($this->returnValue($oTiramizooConfig));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getBasket')
             					  ->will($this->returnValue($oBasket));

		$this->assertEquals($aExpectedItems, $oTiramizooCreateOrderData->buildItems());
	}


	public function testBuildItemPackageStrategySinglePackage()
	{
        $aArticle1EffectiveData = array();
        $aArticle1EffectiveData['enable'] = true;
        $aArticle1EffectiveData['tiramizoo_use_package'] = true;
        $aArticle1EffectiveData['weight'] = 2;
        $aArticle1EffectiveData['width'] = 30;
        $aArticle1EffectiveData['length'] = 30;
        $aArticle1EffectiveData['height'] = 30;

		$oItem = new stdClass();
		$oItem->weight = 15;
        $oItem->width = 40;
        $oItem->height = 80;
        $oItem->length = 120;
        $oItem->quantity = 1;
		$oItem->description = 'Test product 1';

		$aExpectedItems = array($oItem);

		$oTiramizooConfig = $this->getMock('oxTiramizoo_Config', array(), array(), '', false);

	    $oTiramizooConfig->expects($this->any())
             			 ->method('getShopConfVar')
		                 ->will($this->returnCallback(function(){
		                    $valueMap = array(
								array('oxTiramizoo_package_strategy', 2),
								array('oxTiramizoo_std_package_width', 40),
								array('oxTiramizoo_std_package_length', 120),
								array('oxTiramizoo_std_package_height', 80),
								array('oxTiramizoo_std_package_weight', 15)
		                    );

							return returnValueMap($valueMap, func_get_args());
		                 }));


		$oArticle1 = oxNew('oxArticle');
		$oArticle1->oxarticles__oxid = new oxField(1);
		$oArticle1->oxarticles__oxtitle = new oxField('Test product 1');
		$oArticle1->oxarticles__oxstock = new oxField(3);

		$oArticle2 = oxNew('oxArticle');
		$oArticle2->oxarticles__oxid = new oxField(2);
		$oArticle2->oxarticles__oxtitle = new oxField('Test product 2');
		$oArticle2->oxarticles__oxstock = new oxField(2);

		$oArticle3 = oxNew('oxArticle');
		$oArticle3->oxarticles__oxid = new oxField(3);
		$oArticle3->oxarticles__oxtitle = new oxField('Test product 3');
		$oArticle3->oxarticles__oxstock = new oxField(4);
		$oArticle3->oxarticles__oxparentid = new oxField(4);

		$oArticle4 = oxNew('oxArticle');
		$oArticle4->oxarticles__oxid = new oxField(3);
		$oArticle4->oxarticles__oxtitle = new oxField('Test product 4');
		$oArticle4->oxarticles__oxstock = new oxField(4);

        oxTestModules::addModuleObject('oxArticle', $oArticle4);

	    $oArticleExtended = $this->getMock('oxTiramizoo_ArticleExtended', array(), array(), '', false);

	    $oArticleExtended->expects($this->any())
             			 ->method('isEnabled')
             			 ->will($this->returnValue(true));

	    $oArticleExtended->expects($this->any())
             			 ->method('hasIndividualPackage')
             			 ->will($this->returnValue(false));

	    $oArticleExtended->expects($this->any())
             			 ->method('getIdByArticleId')
             			 ->will($this->returnValue('someID'));

	    $oArticleExtended->expects($this->any())
             			 ->method('buildArticleEffectiveData')
             			 ->will($this->returnValue($aArticle1EffectiveData));

        oxTestModules::addModuleObject('oxTiramizoo_ArticleExtended', $oArticleExtended);

        $oArticleExtended = oxNew('oxTiramizoo_ArticleExtended');

		$oBasket = $this->getMock('oxBasket', array('getBasketArticles', 'getArtStockInBasket'), array(), '', false);

	    $oBasket->expects($this->any())
             	->method('getBasketArticles')
             	->will($this->returnValue(array($oArticle1, $oArticle2, $oArticle3)));

	    $oBasket->expects($this->at(1))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(1));

	    $oBasket->expects($this->at(2))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(2));

	    $oBasket->expects($this->at(3))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(3));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getTiramizooConfig', 'getBasket'), array(), '', false);
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getTiramizooConfig')
             					  ->will($this->returnValue($oTiramizooConfig));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getBasket')
             					  ->will($this->returnValue($oBasket));

		$this->assertEquals($aExpectedItems, $oTiramizooCreateOrderData->buildItems());
	}

	public function testBuildItemsPackageStrategyIndividualPackage()
	{

        $aArticle1EffectiveData = array();
        $aArticle1EffectiveData['weight'] = 2;
        $aArticle1EffectiveData['width'] = 30;
        $aArticle1EffectiveData['length'] = 30;
        $aArticle1EffectiveData['height'] = 30;

        $aArticle2EffectiveData = array();
        $aArticle2EffectiveData['weight'] = 3;
        $aArticle2EffectiveData['width'] = 3;
        $aArticle2EffectiveData['length'] = 5;
        $aArticle2EffectiveData['height'] = 6;

        $aArticle3EffectiveData = array();
        $aArticle3EffectiveData['weight'] = 4;
        $aArticle3EffectiveData['width'] = 11;
        $aArticle3EffectiveData['length'] = 11;
        $aArticle3EffectiveData['height'] = 11;


		$oItem1 = new stdClass();
		$oItem1->weight = 2;
		$oItem1->width = 30;
		$oItem1->height = 30;
        $oItem1->length = 30;
		$oItem1->quantity = 1;
		$oItem1->description = 'Test product 1';

		$oItem2 = new stdClass();
		$oItem2->weight = 3;
		$oItem2->width = 3;
		$oItem2->height = 6;
        $oItem2->length = 5;
		$oItem2->quantity = 2;
		$oItem2->description = 'Test product 2';

		$oItem3 = new stdClass();
		$oItem3->weight = 4;
		$oItem3->width = 11;
		$oItem3->height = 11;
        $oItem3->length = 11;
		$oItem3->quantity = 3;
		$oItem3->description = 'Test product 4';

		$aExpectedItems = array($oItem1, $oItem2, $oItem3);

		$oTiramizooConfig = $this->getMock('oxTiramizoo_Config', array('getShopConfVar'));

	    $oTiramizooConfig->expects($this->any())
             			 ->method('getShopConfVar')
		                 ->will($this->returnCallback(function(){
		                    $valueMap = array(
          						array('oxTiramizoo_package_strategy', null, 'oxTiramizoo', 0),
		                    );

							return returnValueMap($valueMap, func_get_args());
		                 }));

		$oArticle1 = oxNew('oxArticle');
		$oArticle1->oxarticles__oxid = new oxField(1);
		$oArticle1->oxarticles__oxtitle = new oxField('Test product 1');
		$oArticle1->oxarticles__oxstock = new oxField(3);

		$oArticle2 = oxNew('oxArticle');
		$oArticle2->oxarticles__oxid = new oxField(2);
		$oArticle2->oxarticles__oxtitle = new oxField('Test product 2');
		$oArticle2->oxarticles__oxstock = new oxField(2);

		$oArticle3 = oxNew('oxArticle');
		$oArticle3->oxarticles__oxid = new oxField(3);
		$oArticle3->oxarticles__oxtitle = new oxField('Test product 3');
		$oArticle3->oxarticles__oxstock = new oxField(4);
		$oArticle3->oxarticles__oxparentid = new oxField(4);

		$oArticle4 = oxNew('oxArticle');
		$oArticle4->oxarticles__oxid = new oxField(3);
		$oArticle4->oxarticles__oxtitle = new oxField('Test product 4');
		$oArticle4->oxarticles__oxstock = new oxField(4);

        oxTestModules::addModuleObject('oxArticle', $oArticle4);

	    $oArticleExtended = $this->getMock('oxTiramizoo_ArticleExtended', array(), array(), '', false);

	    $oArticleExtended->expects($this->any())
             			 ->method('isEnabled')
             			 ->will($this->returnValue(true));

	    $oArticleExtended->expects($this->any())
             			 ->method('hasIndividualPackage')
             			 ->will($this->returnValue(true));

	    $oArticleExtended->expects($this->at(2))
             			 ->method('getEffectiveData')
             			 ->will($this->returnValue($aArticle1EffectiveData));

	    $oArticleExtended->expects($this->at(5))
             			 ->method('getEffectiveData')
             			 ->will($this->returnValue($aArticle2EffectiveData));

	    $oArticleExtended->expects($this->at(8))
             			 ->method('getEffectiveData')
             			 ->will($this->returnValue($aArticle3EffectiveData));

	    $oArticleExtended->expects($this->any())
             			 ->method('getIdByArticleId')
             			 ->will($this->returnValue('someID'));

        oxTestModules::addModuleObject('oxTiramizoo_ArticleExtended', $oArticleExtended);


		$oBasket = $this->getMock('oxBasket', array('getBasketArticles', 'getArtStockInBasket'), array(), '', false);

	    $oBasket->expects($this->any())
             	->method('getBasketArticles')
             	->will($this->returnValue(array($oArticle1, $oArticle2, $oArticle3)));

	    $oBasket->expects($this->at(1))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(1));

	    $oBasket->expects($this->at(2))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(2));

	    $oBasket->expects($this->at(3))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(3));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getTiramizooConfig', 'getBasket'), array(), '', false);
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getTiramizooConfig')
             					  ->will($this->returnValue($oTiramizooConfig));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getBasket')
             					  ->will($this->returnValue($oBasket));

		$this->assertEquals($aExpectedItems, $oTiramizooCreateOrderData->buildItems());
	}

	public function testBuildItemsIfNoStockQty()
	{
		$oTiramizooConfig = $this->getMock('oxTiramizoo_Config', array('getShopConfVar'));
	    $oTiramizooConfig->expects($this->any())
             			 ->method('getShopConfVar')
             			 ->will($this->returnValue(1));

		$oArticle1 = oxNew('oxArticle');
		$oArticle1->oxarticles__oxid = new oxField(1);
		$oArticle1->oxarticles__oxtitle = new oxField('Test product 1');
		$oArticle1->oxarticles__oxstock = new oxField(0);

		$oArticle2 = oxNew('oxArticle');
		$oArticle2->oxarticles__oxid = new oxField(2);
		$oArticle2->oxarticles__oxtitle = new oxField('Test product 2');
		$oArticle2->oxarticles__oxstock = new oxField(0);

		$oArticle3 = oxNew('oxArticle');
		$oArticle3->oxarticles__oxid = new oxField(3);
		$oArticle3->oxarticles__oxtitle = new oxField('Test product 3');
		$oArticle3->oxarticles__oxstock = new oxField(0);
		$oArticle3->oxarticles__oxparentid = new oxField(4);

		$oArticle4 = oxNew('oxArticle');
		$oArticle4->oxarticles__oxid = new oxField(3);
		$oArticle4->oxarticles__oxtitle = new oxField('Test product 4');
		$oArticle4->oxarticles__oxstock = new oxField(0);

        oxTestModules::addModuleObject('oxArticle', $oArticle4);

	    $oArticleExtended = $this->getMock('oxTiramizoo_ArticleExtended', array(), array(), '', false);
	    $oArticleExtended->expects($this->any())
             			 ->method('isEnabled')
             			 ->will($this->returnValue(true));
	    $oArticleExtended->expects($this->any())
             			 ->method('buildArticleEffectiveData')
             			 ->will($this->returnValue($oItem2));
	    $oArticleExtended->expects($this->any())
             			 ->method('getIdByArticleId')
             			 ->will($this->returnValue('someID'));
        oxTestModules::addModuleObject('oxTiramizoo_ArticleExtended', $oArticleExtended);


		$oBasket = $this->getMock('oxBasket', array('getBasketArticles', 'getArtStockInBasket'), array(), '', false);
	    $oBasket->expects($this->any())
             	->method('getBasketArticles')
             	->will($this->returnValue(array($oArticle1, $oArticle2, $oArticle3)));
	    $oBasket->expects($this->at(1))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(1));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getTiramizooConfig', 'getBasket'), array(), '', false);
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getTiramizooConfig')
             					  ->will($this->returnValue($oTiramizooConfig));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getBasket')
             					  ->will($this->returnValue($oBasket));

		$this->assertEquals(false, $oTiramizooCreateOrderData->buildItems());
	}

	public function testBuildItemsIfNotEnabled()
	{
		$oTiramizooConfig = $this->getMock('oxTiramizoo_Config', array('getShopConfVar'));
	    $oTiramizooConfig->expects($this->any())
             			 ->method('getShopConfVar')
             			 ->will($this->returnValue(1));

		$oArticle1 = oxNew('oxArticle');
		$oArticle1->oxarticles__oxid = new oxField(1);
		$oArticle1->oxarticles__oxtitle = new oxField('Test product 1');
		$oArticle1->oxarticles__oxstock = new oxField(1);

		$oArticle2 = oxNew('oxArticle');
		$oArticle2->oxarticles__oxid = new oxField(2);
		$oArticle2->oxarticles__oxtitle = new oxField('Test product 2');
		$oArticle2->oxarticles__oxstock = new oxField(2);

		$oArticle3 = oxNew('oxArticle');
		$oArticle3->oxarticles__oxid = new oxField(3);
		$oArticle3->oxarticles__oxtitle = new oxField('Test product 3');
		$oArticle3->oxarticles__oxstock = new oxField(3);
		$oArticle3->oxarticles__oxparentid = new oxField(4);

		$oArticle4 = oxNew('oxArticle');
		$oArticle4->oxarticles__oxid = new oxField(3);
		$oArticle4->oxarticles__oxtitle = new oxField('Test product 4');
		$oArticle4->oxarticles__oxstock = new oxField(4);

        oxTestModules::addModuleObject('oxArticle', $oArticle4);

	    $oArticleExtended = $this->getMock('oxTiramizoo_ArticleExtended', array(), array(), '', false);
	    $oArticleExtended->expects($this->any())
             			 ->method('isEnabled')
             			 ->will($this->returnValue(false));
	    $oArticleExtended->expects($this->any())
             			 ->method('buildArticleEffectiveData')
             			 ->will($this->returnValue($oItem2));
	    $oArticleExtended->expects($this->any())
             			 ->method('getIdByArticleId')
             			 ->will($this->returnValue('someID'));
        oxTestModules::addModuleObject('oxTiramizoo_ArticleExtended', $oArticleExtended);


		$oBasket = $this->getMock('oxBasket', array('getBasketArticles', 'getArtStockInBasket'), array(), '', false);
	    $oBasket->expects($this->any())
             	->method('getBasketArticles')
             	->will($this->returnValue(array($oArticle1, $oArticle2, $oArticle3)));
	    $oBasket->expects($this->at(1))
             	->method('getArtStockInBasket')
             	->will($this->returnValue(1));

	    $oTiramizooCreateOrderData = $this->getMock('oxTiramizoo_CreateOrderDataExposed', array('getTiramizooConfig', 'getBasket'), array(), '', false);
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getTiramizooConfig')
             					  ->will($this->returnValue($oTiramizooConfig));
	    $oTiramizooCreateOrderData->expects($this->any())
             					  ->method('getBasket')
             					  ->will($this->returnValue($oBasket));

		$this->assertEquals(false, $oTiramizooCreateOrderData->buildItems());
	}



}