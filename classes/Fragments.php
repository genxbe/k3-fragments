<?php
namespace X;

class Fragments
{
    private static $fragments = null;

    public static function fragment($fragment, $placeholders)
    {
        if(self::$fragments == null)
        {
            self::$fragments = self::getFragments();
        }

        if(property_exists(self::$fragments,$fragment))
        {
            return \Str::template(self::$fragments->$fragment->value(), $placeholders);
        }
        else
        {
            return \Str::template($fragment, $placeholders);
        }
    }

    private static function getFragments()
    {
        $pageFragments = page()->fragments();
        $siteFragments = site()->fragments();

        $parts = array();

        if($siteFragments->isNotEmpty())
        {
            foreach($siteFragments->toStructure() as $fragment)
            {
                $parts[$fragment->key()->value] = $fragment->value();
            }
        }

        if($pageFragments->isNotEmpty())
        {
            foreach($pageFragments->toStructure() as $fragment)
            {
                $parts[$fragment->key()->value] = $fragment->value();
            }
        }

        $parts = (object)$parts;

        if(empty($parts))
        {
            $parts = (object)array();
        }

        return $parts;
    }
}
