<?php



class Unit_Modules_oxTiramizoo_Core_oxTiramizoo_SyncConfigJobTest extends OxidTestCase
{
	protected $_oSubj = null;

	public function setUp()
	{
        parent::setUp();
		$this->_oSubj = new oxTiramizoo_SyncConfigJob();
		$this->_oSubj->save();
	}

	public function testFinishJob()
	{
		$this->_oSubj->finishJob();
		$this->assertEquals('finished', $this->_oSubj->oxtiramizooschedulejob__oxstate->value);
	}

	public function testRefreshJob()
	{
		$this->assertEquals(0, $this->_oSubj->getRepeats());
		
		$this->_oSubj->refreshJob();
		$this->assertEquals(1, $this->_oSubj->getRepeats());

		$this->_oSubj->refreshJob();
		$this->_oSubj->refreshJob();
		$this->assertEquals(3, $this->_oSubj->getRepeats());

		$this->_oSubj->finishJob();
	}

	public function tearDown()
	{
		$this->_oSubj->delete();
		oxRegistry::set('oxTiramizoo_Config', new oxTiramizoo_Config());
	}

	public function testRun1()
	{
		$oSyncConfigJob = $this->getMock('oxTiramizoo_SyncConfigJob', array('getRepeats', 'closeJob'), array(), '', false);
		$oSyncConfigJob->expects($this->any())->method('getRepeats')->will($this->returnValue(oxTiramizoo_SyncConfigJob::MAX_REPEATS + 10));
		$oSyncConfigJob->expects($this->once())->method('closeJob');

		$oSyncConfigJob->run();
	}

	// no retail list
	public function testRun2()
	{
		$oSyncConfigJob = $this->getMock('oxTiramizoo_SyncConfigJob', array('getRepeats', 'closeJob', 'finishJob'), array(), '', false);
		$oSyncConfigJob->expects($this->any())->method('getRepeats')->will($this->returnValue(oxTiramizoo_SyncConfigJob::MAX_REPEATS - 5));
		$oSyncConfigJob->expects($this->never())->method('closeJob');
		$oSyncConfigJob->expects($this->once())->method('finishJob');

		$oRetailLocationList = $this->getMock('oxTiramizoo_RetailLocationList', array('loadAll'), array(), '', false);
		$oRetailLocationList->assign(array());

        oxTestModules::addModuleObject('oxTiramizoo_RetailLocationList', $oRetailLocationList);

		$oSyncConfigJob->run();
	}

	// with retail list
	public function testRun3()
	{
		$oRetailLocation = $this->getMock('oxTiramizoo_RetailLocation', array(), array(), '', false);
		$aRetailLocationList = array($oRetailLocation, $oRetailLocation);

		$oSyncConfigJob = $this->getMock('oxTiramizoo_SyncConfigJob', array('getRepeats', 'closeJob', 'finishJob'), array(), '', false);
		$oSyncConfigJob->expects($this->any())->method('getRepeats')->will($this->returnValue(oxTiramizoo_SyncConfigJob::MAX_REPEATS - 5));
		$oSyncConfigJob->expects($this->never())->method('closeJob');
		$oSyncConfigJob->expects($this->once())->method('finishJob');

		$oRetailLocationList = $this->getMock('oxTiramizoo_RetailLocationList', array('loadAll'), array(), '', false);
		$oRetailLocationList->assign($aRetailLocationList);

        oxTestModules::addModuleObject('oxTiramizoo_RetailLocationList', $oRetailLocationList);

        $oTiramizooConfig = $this->getMock('oxTiramizoo_SyncConfigJob', array('synchronizeAll'), array(), '', false);
		$oTiramizooConfig->expects($this->exactly(2))->method('synchronizeAll');

		oxRegistry::set('oxTiramizoo_Config', $oTiramizooConfig);

		$oSyncConfigJob->run();
	}

	// throw an exception
	public function testRun4()
	{
		$oRetailLocation = $this->getMock('oxTiramizoo_RetailLocation', array('getApiToken'), array(), '', false);
		$oRetailLocation->expects($this->any())->method('getApiToken')->will($this->throwException(new oxException));
		$aRetailLocationList = array($oRetailLocation);

		$oSyncConfigJob = $this->getMock('oxTiramizoo_SyncConfigJob', array('getRepeats', 'closeJob', 'finishJob', 'refreshJob'), array(), '', false);
		$oSyncConfigJob->expects($this->any())->method('getRepeats')->will($this->returnValue(oxTiramizoo_SyncConfigJob::MAX_REPEATS - 5));
		$oSyncConfigJob->expects($this->never())->method('closeJob');
		$oSyncConfigJob->expects($this->never())->method('finishJob');
		$oSyncConfigJob->expects($this->once())->method('refreshJob');

		$oRetailLocationList = $this->getMock('oxTiramizoo_RetailLocationList', array('loadAll'), array(), '', false);
		$oRetailLocationList->assign($aRetailLocationList);

        oxTestModules::addModuleObject('oxTiramizoo_RetailLocationList', $oRetailLocationList);

        $oTiramizooConfig = $this->getMock('oxTiramizoo_SyncConfigJob', array('synchronizeAll'), array(), '', false);
		$oTiramizooConfig->expects($this->never())->method('synchronizeAll');

		oxRegistry::set('oxTiramizoo_Config', $oTiramizooConfig);

		$oSyncConfigJob->run();
	}


}