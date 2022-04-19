<?php

namespace TSG\Infrastructure\Converter;


use Ecotone\Messaging\Attribute\Converter;
use TSG\Domain\Label\ValueObject\LabelShortName;

class LabelShortNameConverter
{
    #[Converter]
    public function convertFrom(LabelShortName $shortName): string
    {
        return $shortName->getShortName();
    }

    #[Converter]
    public function convertTo(string $shortName): LabelShortName
    {
        return new LabelShortName($shortName);
    }
}