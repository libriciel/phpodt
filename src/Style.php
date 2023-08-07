<?php

namespace PhpOdt;

/**
 * Base class for paragraph & text styles.
 */
class Style
{
    /**
     * The DOMDocument representing the styles xml file
     * @access private
     * @var DOMDocument
     */
    protected $styleDocument;
    /**
     * The name of the style
     * @access private
     * @var string
     */
    protected $name;
    /**
     * The DOMElement representing this style
     * @access private
     * @var DOMElement
     */
    protected $styleElement;

    /**
     * The constructor initializes the properties, then creates a <style:style>
     * element representing this specific style, and add it to <office:styles> element
     *
     * @param DOMDocument $styleDoc
     * @param string $name
     */
    public function __construct($name)
    {
        $this->styleDocument = Odt::getInstance()->getStyleDocument();
        $this->name = $name;
        $this->styleElement = $this->styleDocument->createElement('style:style');
        $this->styleElement->setAttribute('style:name', $name);
        $this->styleDocument->getElementsByTagName('office:styles')->item(0)->appendChild($this->styleElement);
    }

    /**
     * return the name of this style
     * @return string
     */
    public function getStyleName()
    {
        return $this->name;
    }

    public function setStyleName($name)
    {
        $this->name = $name;
    }
}
