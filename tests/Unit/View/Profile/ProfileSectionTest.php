<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Profile;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Profile\ProfileSection;
use Illuminate\View\View;

class ProfileSectionTest extends TestCase
{
    public function test_it_decodes_html_entities_in_title_or_description(): void
    {
        $section = new ProfileSection(
            'Account &amp; security',
            'Manage your &quot;profile&quot;.'
        );

        $this->assertSame('Account & security', $section->title);
        $this->assertSame('Manage your "profile".', $section->description);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new ProfileSection('Account', 'Details'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::profile.profile-section', $view->getName());
    }
}
