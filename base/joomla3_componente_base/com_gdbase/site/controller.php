<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

class gdbaseController extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {
       // JRequest::setVar('view', 'default'); // force it to be the search view

        
        return parent::display($cachable, $urlparams);
    }

}
