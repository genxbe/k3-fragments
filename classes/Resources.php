<?php
namespace X;

use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;

class Resources
{
    private static $resources = [];

    /**
     * Retreives a resource based on the key given. If nothing is found the Key will be returned
     *
     * @param mixed $resource
     * @param mixed $placeholders
     *
     * @return string
     */
    public static function resource($resource, $placeholders = []): string|array
    {
        if(key_exists($resource,self::$resources))
        {
            return Str::template(self::$resources[$resource], $placeholders);
        }

        if(!key_exists($resource,self::$resources))
        {
            self::load();

            $resArr = self::$resources;

            if(!empty($resArr[$resource]))
            {
                if(is_array($resArr[$resource]))
                {
                    return $resArr[$resource];
                }

                return Str::template($resArr[$resource], $placeholders);
            }

            $segmentCheck = '';

            foreach(explode('.', $resource) as $segment)
            {
                if(is_array($resArr) && array_key_exists($segment, $resArr))
                {
                    $segmentCheck .= $segment.'.';
                    $resArr = $resArr[$segment];
                }
                elseif(is_array($resArr))
                {
                    if(array_key_exists($segment, $resArr) && is_array($resArr[$segment]))
                    {
                        return $resArr[$segment];
                    }

                    if(array_key_exists($segment, $resArr))
                    {
                        return Str::template($resArr[$segment], $placeholders);
                    }

                }
            }

            $segmentCheck = trim($segmentCheck, '.');

            if(self::$resources != $resArr)
            {
                if($segmentCheck != $resource)
                {
                    $subFragment = Str::replace($resource, $segmentCheck.'.', '');

                    if(!empty($resArr[$subFragment]))
                    {
                        if(is_array($resArr[$subFragment]))
                        {
                            return $resArr[$subFragment];
                        }

                        return Str::template($resArr[$subFragment], $placeholders);
                    }

                    if(is_array($resource))
                    {
                        return $resource;
                    }

                    return Str::template($resource, $placeholders);
                }

                if(is_array($resArr))
                {
                    return $resArr;
                }

                return Str::template($resArr, $placeholders);
            }
        }

        return Str::template($resource, $placeholders);
    }

    private static function load()
    {
        if(empty(self::$resources))
        {
            $kirby = kirby();

            /**
             * If no language strings are found use the default language
             */
            $path = 'resources/'.option('genxbe.k3x-core.languages.default').'/';
            $resources = $kirby->roots()->root().'/'.$path;

            foreach(glob($resources.'*.php') as $file)
            {
                if(file_exists($file))
                {
                    $base = str_replace('.php','', basename($file));
                    self::$resources[$base] = include($file);
                }
            }

            /**
             * Overwrite defaults with translated resources
             */
            $path = 'resources/'.$kirby->languageCode().'/';
            $resources = $kirby->roots()->root().'/'.$path;

            foreach(glob($resources.'*.php') as $file)
            {
                if(file_exists($file))
                {
                    $base = str_replace('.php','', basename($file));
                    self::$resources[$base] = include($file);
                }
            }
        }
    }
}
