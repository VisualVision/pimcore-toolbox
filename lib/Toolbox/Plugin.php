<?php

namespace Toolbox;

use Pimcore\API\Plugin as PluginLib;

use Toolbox\Plugin\Install;

class Plugin extends PluginLib\AbstractPlugin implements PluginLib\PluginInterface {

    public function __construct() {

        define('TOOLBOX_CONFIGURATION_FILE', PIMCORE_CONFIGURATION_DIRECTORY . '/toolbox_configuration.php');

    }

    public function preDispatch($e) {


        $e->getTarget()->registerPlugin(new Controller\Plugin\Assets());
        $e->getTarget()->registerPlugin(new Controller\Plugin\Frontend());

    }

    public function init() {

        parent::init();

    }

	public static function install () {

        $install = new Install();

        $install->installConfigFile();
        $install->addUserData();

        return 'Toolbox has been successfully installed.';

	}

	public static function uninstall () {

        return true;

	}

	public static function isInstalled () {

        $install = new Install();

        return $install->isInstalled();

	}

    public static function getTranslationFileDirectory() {
        return PIMCORE_PLUGINS_PATH . '/Toolbox/lang';
    }

    /**
     *
     * @param string $language
     * @return string $languageFile for the specified language relative to plugin directory
     */
    public static function getTranslationFile($language) {

        if (is_file(self::getTranslationFileDirectory() . "/$language.csv")) {
            return "/Toolbox/lang/$language.csv";
        }

        return '/Toolbox/lang/en.csv';

    }

}
