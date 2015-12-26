<?php
class NewLocation extends GD_Test
{
    public function setUp()
    {
        parent::setUp();

        //skip test if already completed.
        if ($this->skipTest($this->getCurrentFileNumber(pathinfo(__FILE__, PATHINFO_FILENAME)), $this->getCompletedFileNumber())) {
            $this->markTestSkipped('Skipping '.pathinfo(__FILE__, PATHINFO_FILENAME).' since its already completed......');
            return;
        }
    }

    public function testNewLocation()
    {
        $this->logInfo('Testing new location......');
        //make sure multi locations plugin active
        $this->maybeAdminLogin(self::GDTEST_BASE_URL.'wp-admin/plugins.php');
        $this->waitForPageLoadAndCheckForErrors();
        $is_active = $this->byId("geodirectory-location-manager")->attribute('class');
        $this->assertFalse( strpos($is_active, 'inactive'), "Location Manager plugin not active");
        if (strpos($is_active, 'inactive')) {
            return;
        }

        $this->url(self::GDTEST_BASE_URL.'wp-admin/admin.php?page=geodirectory&tab=managelocation_fields&subtab=geodir_location_addedit');
        $this->waitForPageLoadAndCheckForErrors();
        $this->byId('gd_city')->value('texas');
        $this->byId('gd_set_address_button')->click();
        $this->waitForPageLoadAndCheckForErrors();
        $this->byId('geodir_location_save')->click();
        $this->waitForPageLoadAndCheckForErrors();
        $this->assertTrue( $this->isTextPresent("Location saved successfully."), "Not in Author page");
    }

    public function tearDown()
    {
        //write current file number to completed.txt
        $CurrentFileNumber = $this->getCurrentFileNumber(pathinfo(__FILE__, PATHINFO_FILENAME));
        $completed = fopen("tests/selenium/completed.txt", "w") or die("Unable to open file!");
        fwrite($completed, $CurrentFileNumber);
    }
}
?>