<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Auth;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Auth\AuthLogo;
use Illuminate\View\View;

class AuthLogoTest extends TestCase
{
    public function test_it_sets_defaults_from_configuration(): void
    {
        $logo = new AuthLogo;

        $this->assertSame('LaradminLTE', $logo->label);

        $this->assertSame(
            '/vendor/ladmin/img/LaradminLTE-Auth.png',
            $logo->logoUrl
        );

        $this->assertSame('55px', $logo->logoHeight);
        $this->assertSame('55px', $logo->logoWidth);
        $this->assertSame('LaradminLTE Logo', $logo->logoAlt);
        $this->assertSame('shadow-sm me-1', $logo->logoClasses);
    }

    public function test_it_decodes_html_entities_in_the_label(): void
    {
        config(['ladmin.auth.logo.text' => 'My &amp; App']);

        $logo = new AuthLogo;

        $this->assertSame('My & App', $logo->label);
    }

    public function test_it_has_no_label_classes_when_label_is_empty(): void
    {
        config(['ladmin.auth.logo.text' => '']);

        $logo = new AuthLogo;

        $this->assertNull($logo->labelClasses);
    }

    public function test_it_builds_label_classes_from_configuration(): void
    {
        config(['ladmin.auth.logo.text_classes' => ['fw-bold', '']]);

        $logo = new AuthLogo;

        $this->assertSame('fw-bold', $logo->labelClasses);
    }

    public function test_it_has_no_logo_classes_when_no_image_is_config(): void
    {
        config(['ladmin.auth.logo.image' => '']);

        $logo = new AuthLogo;

        $this->assertNull($logo->logoClasses);
    }

    public function test_it_builds_logo_classes_when_image_is_configured(): void
    {
        config([
            'ladmin.auth.logo.image' => '/images/logo.png',
            'ladmin.auth.logo.image_classes' => ['shadow', ''],
        ]);

        $logo = new AuthLogo;

        $this->assertSame('/images/logo.png', $logo->logoUrl);
        $this->assertSame('shadow', $logo->logoClasses);
    }

    public function test_it_ignores_non_array_class_configuration(): void
    {
        config([
            'ladmin.auth.logo.image' => '/images/logo.png',
            'ladmin.auth.logo.image_classes' => 'not-an-array',
        ]);

        $logo = new AuthLogo;

        $this->assertSame('', $logo->logoClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new AuthLogo)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::auth.auth-logo', $view->getName());
    }
}
