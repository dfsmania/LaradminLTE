<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Footer;

use Illuminate\View\Component;
use Illuminate\View\View;

class DefaultFooterContent extends Component
{
    /**
     * The version of the admin panel.
     *
     * @var string
     */
    public $version;

    /**
     * The name of the company that owns and develops the admin panel.
     *
     * @var string
     */
    public $company;

    /**
     * The url site of the company that owns and develops the admin panel.
     *
     * @var string
     */
    public $companyUrl;

    /**
     * The year when the development of your admin panel started.
     *
     * @var string
     */
    public $startYear;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Setup the properties of the component by reading the configuration
        // file.

        $this->version = config('ladmin.basic.version', '1.0.0');
        $this->company = config('ladmin.basic.company', 'Company Name');
        $this->companyUrl = config('ladmin.basic.company_url', '#');
        $this->startYear = config('ladmin.basic.start_year', '2024');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.footer.default-footer-content');
    }
}