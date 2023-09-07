<?php

use Ausi\SlugGenerator\SlugGenerator;
use Ausi\SlugGenerator\SlugOptions;

class CoachHelper
{
    public static function generateSlug(string $name, ?int $id = null): ?string
    {
        global $wpdb;
        $name = trim($name);
        $nameOriginal = $name;
        $slug = null;
      
        if (!$name) {
            return null;
        }
        
        $generator = new SlugGenerator((new SlugOptions)
            ->setValidChars('a-zA-Z0-9')
            ->setLocale('en')
            ->setDelimiter('-')
        );
      
        $count = 1;
        while (true) {
            $slug = $generator->generate($name);  // Aepfel_und_Baeume
            $slug = mb_strtolower($slug);
      
            $sql = "SELECT *
              FROM a_coaches 
              where slug = '". addslashes($slug)."'
            ";
            
            if ($id) {
                $sql .= " and id != ".$id;
            }

            $result = $wpdb->get_results($sql, ARRAY_A);
            
            $item = $result[0]?? null;
            
            if (!$item) {
                break;
            }
            
            $count++;
            $name = $nameOriginal.$count;
        }
        
        return $slug;
    }
}
