<?php

namespace ProwectCMS\Core\Tests\Feature\Settings;

use ProwectCMS\Core\Settings\GeneralSettings;
use ProwectCMS\Core\Tests\TestCase;

class GetGeneralSiteNameSettingTest extends TestCase
{
    public function testGetGeneralSiteNameSetting()
    {
        $settings = app(GeneralSettings::class);

        $this->assertInstanceOf(GeneralSettings::class, $settings);
        $this->assertEquals('Your site name', $settings->site_name);
    }
}