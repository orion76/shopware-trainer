<?php


namespace SwagTrainer\Subscriber;


use Enlight\Event\SubscriberInterface;

class BackendProductDetail implements SubscriberInterface {

    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory) {
        $this->pluginDirectory = $pluginDirectory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        $n = 0;
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Article' => 'onPostDispatchBackend',
        ];
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onPostDispatchBackend(\Enlight_Controller_ActionEventArgs $args) {

        /** @var \Shopware_Controllers_Backend_Customer $controller */
        $controller = $args->getSubject();

        $view = $controller->View();
        $request = $controller->Request();

        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');

        if ($request->getActionName() == 'load') {
            $view->extendsTemplate('backend/swag_trainer/view/detail/window.js');
        }
    }
}
