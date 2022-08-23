<?php

interface DataLoaderInterface //TODO - SUGGESTION: very nice! now that you already have 3 compatible services, why not encapsulate them on a factory pattern?
{
    public function getCustomerNames(): array;
}
