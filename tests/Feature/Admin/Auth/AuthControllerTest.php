<?php

namespace ProwectCMS\Core\Tests\Feature\Admin\Auth;

use ProwectCMS\Core\Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testViewLogin()
    {
        $this->get(route('prowectcms.admin.login'))
            ->assertOk()
            ->assertViewIs('prowectcms::admin.page.auth.login')
            ->assertSee('ProwectCMS');
    }
}