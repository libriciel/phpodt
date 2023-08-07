<?php

namespace PhpOdt;

class OdtSubList extends OdtList
{
    public function __construct($items = null)
    {
        parent::__construct($items, false);
    }
}
