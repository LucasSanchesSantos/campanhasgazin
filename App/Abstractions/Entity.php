<?php

namespace App\Abstractions;

abstract class Entity
{
    public function toArray(bool $snakeCase = false, array $unwantedProperties = null): array
    {
        $objProperties = get_object_vars($this);

        if (!empty($unwantedProperties)) {
            foreach ($unwantedProperties as $unwantedProperty) {
                unset($objProperties[$unwantedProperty]);
            }
        }
        
        $props = [];
        foreach ($objProperties as $name => $value) {
            $getter = "get" . ucfirst($name);
            if (!method_exists($this, $getter)) {
                continue;
            }
            if ($snakeCase) {
                $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
            }

            $props["{$name}"] = $this->$getter();
        }

        return $props;
    }
}
