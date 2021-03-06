<?php
/*
 * This file is part of the RedKite CMS Application and it is distributed
 * under the MIT LICENSE. To use this application you must leave intact this copyright
 * notice.
 *
 * Copyright (c) RedKite Labs <info@redkite-labs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.redkite-labs.com
 *
 * @license    MIT LICENSE
 *
 */

namespace RedKiteLabs\RedKiteCms\TwitterBootstrapBundle\Core\Block\Button;

use RedKiteLabs\RedKiteCms\RedKiteCmsBundle\Core\Content\Block\JsonBlock\BlockManagerJsonBlockContainer;

/**
 * Defines the Block Manager to handle a Bootstrap Button
 *
 * @author RedKite Labs <info@redkite-labs.com>
 */
class BlockManagerBootstrapButtonBlock extends BlockManagerJsonBlockContainer
{
    protected $blockTemplate = 'TwitterBootstrapBundle:Content:Button/button.html.twig';

    /**
     * Defines the App-Block's default value
     *
     * @return array
     */
    public function getDefaultValue()
    {
        $value = '
            {
                "0" : {
                    "button_text": "Button 1",
                    "button_type": "",
                    "button_attribute": "",
                    "button_block": "",
                    "button_enabled": ""
                }
            }
        ';

        return array('Content' => $value);
    }

    /**
     * Renders the App-Block's content view
     *
     * @return string|array
     */
    protected function renderHtml()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => $this->blockTemplate,
            'options' => array_merge($this->extraOptions, array(
                'data' => $items[0], 
            )),
        ));
    }

    /**
     * Defines the parameters passed to the App-Block's editor
     *
     * @return array
     */
    public function editorParameters()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];

        $bootstrapFormFactory = $this->container->get('twitter_bootstrap.bootstrap_form_factory');
        $form = $bootstrapFormFactory->createForm('Button', 'ButtonType', $item);

        return array(
            "template" => "TwitterBootstrapBundle:Editor:Button/button_editor.html.twig",
            "title" => $this->translator->translate('button_block_editor_title', array(), 'TwitterBootstrapBundle'),
            "form" => $form->createView(),
        );
    }
}
