<?php

namespace Fay\Api\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Contact extends Field
{
    public function render(AbstractElement $element)
    {
        return '<div class="contact" style="text-align: center;">
                <p>For more info please visit - <a href="https://www.faythefairy.com/">https://www.faythefairy.com/</a></p>
                <p><a href="mailto:support@faythefairy.com">Or email us</a></p>
                </div>';
    }
}
