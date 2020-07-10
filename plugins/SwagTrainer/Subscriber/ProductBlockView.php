<?php


namespace SwagTrainer\Subscriber;


use Enlight\Event\SubscriberInterface;
use function Shopware;

class ProductBlockView implements SubscriberInterface {

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatchSecureFrontend',
        ];
    }

    /**
     * @param \Enlight_Controller_ActionEventArgs $args
     */
    public function onPostDispatchSecureFrontend(\Enlight_Controller_ActionEventArgs $args) {

        $view = $args->getSubject()->View();

        $articles = $view->getAssign('sArticles');
        $productList = array_filter($articles, function ($item) {
            return $item['product_sale'];
        });
        $output = array_map(function ($item) {
            return $item['articleName'];
        }, $productList);
        //        return $item['articleName'];
        $view->assign('productList', $output);
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
    }
}
