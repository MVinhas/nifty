<?php

namespace Nifty;

use Nifty\Exceptions\SiteException;
use Exception;

class Migrations
{
    private static $tables = [
        'home_menu',
        'resume_section_entries',
        'resume_sections'
    ];

    public static function migrate(array $args = [])
    {
        if (empty($args)) {
            self::createTables();
        }

        foreach ($args ?? [] as $arg) {
            try {
                self::{$arg}();
            } catch (Exception $e) {
                throw SiteException::MigrationArgNotFound();
            }
        }
    }
    
    private static function home_menu()
    {
        $fields = [
            '`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`title` VARCHAR(100) NOT NULL'
        ];
        Db::create(__FUNCTION__, $fields);
    }

    private static function resume_sections()
    {
        $fields = [
            '`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`title` VARCHAR(200) NOT NULL'
        ];
        Db::create(__FUNCTION__, $fields);
    }

    private static function resume_section_entries()
    {
        $fields = [
            '`id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
            '`section_id` INT(6) UNSIGNED NOT NULL',
            '`position` VARCHAR(200) NOT NULL',
            '`at` VARCHAR(100) NOT NULL',
            '`description` TEXT',
            '`from` DATE',
            '`to` DATE'
        ];
        Db::create(__FUNCTION__, $fields);
    }

    private static function populate_home_menu()
    {
        $menu_items = ['Home', 'Resume', 'Blog'];
        foreach ($menu_items as $item) {
            $fields = ["`title`"];
            $values = ["'".$item."'"];
            Db::insert('home_menu', $fields, $values);
        }
    }

    private static function populate_resume_sections()
    {
        $menu_items = [
            'About',
            'Experience',
            'Personal Projects',
            'Education',
            'Technical Knowledge',
            'Misc'
        ];
        foreach ($menu_items as $item) {
            $fields = ["`title`"];
            $values = ["'".$item."'"];
            Db::insert('resume_sections', $fields, $values);
        }  
    }

    private static function populate_resume_section_entries()
    {
        $positions = [
            'About Me',
            'PHP Developer',
            'Web Developer',
            'Simple CMS Blog',
            'Informatics Engineering',
            'PHP',
            'CSS',
            'Runner'
        ];
        $at = [
            '',
            'Super Enterprise',
            'EcoStore',
            '',
            'High School of Oporto',
            '',
            '',
            ''
        ];
        $random_lorem = file_get_contents('http://loripsum.net/api');
        $from = ['', '2020-01-01', '2021-01-01', '', '', '', '', ''];
        $to = ['', '2020-12-31', '', '', '', '', '', ''];
        $section_id = [1, 2, 2, 3, 4, 5, 5, 6];
        $total = count($positions);

        for ($i = 0; $i < $total; $i++) {
            $fields = [
                "`position`",
                "`at`",
                "`description`",
                "`from`",
                "`to`",
                "`section_id`"
            ];
            $values = [
                "'".$positions[$i]."'",
                "'".$at[$i]."'",
                "'".$random_lorem."'",
                "'".$from[$i]."'",
                "'".$to[$i]."'",
                "'".$section_id[$i]."'",
            ];
            Db::insert('resume_section_entries', $fields, $values);
        }
    }

    private static function createTables()
    {
        foreach(self::$tables as $table) {
            self::{$table}();
        }
    }

    private static function populate()
    {
        self::createTables();
        foreach(self::$tables as $table) {
            $func = 'populate_'.$table;
            self::{$func}();
        }        
    }

    private static function cleanTables()
    {
        foreach (self::$tables as $table) {
            Db::clean($table);
        }
    }

    private static function dropTables()
    {
        self::cleanTables();
        foreach (self::$tables as $table) {
            Db::drop($table);
        }
    }
}