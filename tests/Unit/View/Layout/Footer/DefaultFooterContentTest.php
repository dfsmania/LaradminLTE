<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Footer;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Footer\DefaultFooterContent;
use Illuminate\View\View;

class DefaultFooterContentTest extends TestCase
{
    public function test_it_sets_defaults_when_configuration_is_null(): void
    {
        config([
            'ladmin.main.basic.version' => null,
            'ladmin.main.basic.company' => null,
            'ladmin.main.basic.company_url' => null,
            'ladmin.main.basic.start_year' => null,
        ]);

        $content = new DefaultFooterContent;

        $this->assertSame('1.0.0', $content->version);
        $this->assertSame('Company Name', $content->company);
        $this->assertSame('#', $content->companyUrl);
        $this->assertSame('2024', $content->startYear);
    }

    public function test_it_reads_values_from_configuration(): void
    {
        config([
            'ladmin.main.basic.version' => '2.5.0',
            'ladmin.main.basic.company' => 'Acme Inc.',
            'ladmin.main.basic.company_url' => 'https://acme.test',
            'ladmin.main.basic.start_year' => '2020',
        ]);

        $content = new DefaultFooterContent;

        $this->assertSame('2.5.0', $content->version);
        $this->assertSame('Acme Inc.', $content->company);
        $this->assertSame('https://acme.test', $content->companyUrl);
        $this->assertSame('2020', $content->startYear);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new DefaultFooterContent)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame(
            'ladmin::layout.footer.default-footer-content',
            $view->getName()
        );
    }
}
