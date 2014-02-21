<?php

namespace carousel;

/**
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @license http://opensource.org/licenses/lgpl-3.0.html
 */
class Module extends \Module implements \SettingDefaults {

    public function __construct()
    {
        parent::__construct();
        $this->setTitle('carousel');
        $this->setProperName('Carousel for Bootstrap themes');
    }

    public function getController(\Request $request)
    {
        $cmd = $request->shiftCommand();
        if ($cmd == 'admin' && \Current_User::allow('carousel')) {
            $admin = new \carousel\Controller\Admin($this);
            return $admin;
        }
    }

    public function runTime(\Request $request)
    {
        if (!$request->isVar('module')) {
            $display = $this->display();
            if (!empty($display)) {
                \Layout::add($display, 'carousel', 'slides');
            }
        }
    }

    public function getSettingDefaults()
    {
        $s['min_width'] = '1000';
        $s['min_height'] = 100;
        return $s;
    }

    private function getSlides()
    {
        $result = \carousel\SlideFactory::getSlides(true);

        if (empty($result)) {
            return null;
        }

        foreach ($result as $slide) {
            $tpl[$slide['id']]['src'] = $slide['filepath'];
            $tpl[$slide['id']]['title'] = $slide['title'];
            $tpl[$slide['id']]['caption'] = $slide['caption'];
            $tpl[$slide['id']]['url'] = $slide['url'];
        }
        return $tpl;
    }

    private function display()
    {
        javascript('jquery');
        $script = '<script type="text/javascript" src="' . PHPWS_SOURCE_HTTP . 'mod/carousel/javascript/onclick.js"></script>';
        \Layout::addJSHeader($script, 'url-onclick');
        $slides = $this->getSlides();
        if (empty($slides)) {
            return null;
        }

        $tpl['slides'] = $slides;
        $template = new \Template($tpl);

        $template->setModuleTemplate('carousel', 'slides.html');
        return $template->get();
    }

}

?>
