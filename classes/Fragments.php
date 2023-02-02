<?php
namespace X;

use Kirby\Cms\App;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;

class Fragments
{
    private static $fragments = null;
    private static $fragmentsRaw = null;

    /**
     * Retreives a fragment based on the key given. If nothing is found the Key will be returned
     *
     * @param mixed $fragment
     * @param mixed $placeholders
     *
     * @return string
     */
    public static function fragment($fragment, $placeholders = []): string|array
    {
        if(empty(self::$fragments))
        {
            self::$fragments = self::getFragments();
        }

        if(key_exists($fragment, self::$fragments))
        {
            $fragment = self::$fragments[$fragment]->fragValue();
        }

        if(!key_exists($fragment,self::$fragments))
        {
            if(option('genxbe.k3-fragments.autoPopulate') === true && option('debug') === true)
            {
                if(empty(self::$fragmentsRaw))
                {
                    self::$fragmentsRaw = self::getFragmentsRaw();
                }

                App::instance()->impersonate('kirby');

                $addFragment = [
                    $fragment => [
                        'key' => $fragment,
                        'value' => $fragment,
                    ],
                ];

                if(!empty(self::$fragmentsRaw))
                {
                    $addFragment = array_merge($addFragment, self::$fragmentsRaw);
                }

                $site = site()->update(['fragments' => \Yaml::encode($addFragment)]);
                self::$fragmentsRaw = $addFragment;
            }
        }

        return Str::template($fragment, $placeholders);
    }

    /**
     * Get raw fragments for auto populate
     *
     * @return array
     */
    private static function getFragmentsRaw(): array
    {
        $siteFragments = App::instance()->site()->fragments();

        $parts = array();

        if($siteFragments->isNotEmpty())
        {
            foreach($siteFragments->toStructure() as $fragment)
            {
                $parts[$fragment->key()->value] = $fragment->content()->toArray();
            }
        }

        if(empty($parts))
        {
            $parts = array();
        }

        return $parts;
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

        if(empty($parts))
        {
            $parts = array();
        }

        return $parts;
    }
}
