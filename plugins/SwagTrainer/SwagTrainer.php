<?php


namespace SwagTrainer;


use Shopware\Bundle\AttributeBundle\Service\TypeMappingInterface;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;



class SwagTrainer extends Plugin {


    private function getAttributes() {

        $attributes[] = [
            'tableName' => 's_articles_attributes',
            'columnName' => 'product_sale',
            'columnType' => TypeMappingInterface::TYPE_BOOLEAN,
            'position' => 1,
            'options' => [
                'label' => 'Sale',
                'supportText' => 'Sale',
                'helpText' => 'Sale',
            ],
        ];

        return $attributes;
    }

    public function install(InstallContext $installContext) {

        $service = $this->container->get('shopware_attribute.crud_service');


        foreach ($this->getAttributes() as $attribute_config) {

            $service->update($attribute_config['tableName'], $attribute_config['columnName'], $attribute_config['columnType'], [
                    'translatable' => TRUE,
                    'displayInBackend' => TRUE,
                    'entity' => 'Shopware\Models\Article\Article',
                    'position' => $attribute_config['position'] + 100,
                    'custom' => TRUE,
                ] + $attribute_config['options']);
        }
    }

    public function activate(ActivateContext $activateContext) {
        $activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function deactivate(DeactivateContext $deactivateContext) {
        $deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $uninstallContext) {
        $uninstallContext->scheduleClearCache(UninstallContext::CACHE_LIST_ALL);

        /** @var $service \Shopware\Bundle\AttributeBundle\Service\CrudServiceInterface */
        $service = $this->container->get('shopware_attribute.crud_service');

        foreach ($this->getAttributes() as $attribute_config) {
            if ($service->get($attribute_config['tableName'], $attribute_config['columnName'])) {
                $service->delete($attribute_config['tableName'], $attribute_config['columnName']);
            }
        }
    }
}
