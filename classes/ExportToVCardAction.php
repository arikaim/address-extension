<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address\Classes;

use Arikaim\Core\Content\Type\Action;
use Arikaim\Core\Utils\Text;

/**
 * Address export to VCard
 */
class ExportToVCardAction extends Action
{
    const DEFUALT_VERSION = '3.0';

    /**
     * Init action
     *
     * @return void
     */
    public function init(): void
    {
        $this->setName('vcard');
        $this->setType('export');
        $this->setTitle('Export content to VCard format.');
    }

    /**
     * Execute action
     *
     * @param ContentItemInterface $content    
     * @param array|null $options
     * @return mixed
     */
    public function execute($content, ?array $options = []) 
    {
        $options['version'] = $options['version'] ?? Self::DEFUALT_VERSION;
        $content = $content->getDataArray();

        $latitude = $content['latitude'] ?? null;
        $longitude = $content['longitude'] ?? null;
        $links = $content['links'] ?? null;

        $text  = "BEGIN:VCARD\n";
        $text .= "VERSION:{{ version }}\n";
        $text .= "N:{{ last_name }};{{ first_name }}\n";
        $text .= "FN;CHARSET=UTF-8:{{ first_name }} {{ last_name }}\n";
        $text .= "ORG:{{ company_name }}\n";
        $text .= "TITLE:{{ title }}\n";
        $text .= "TEL;TYPE#HOME,VOICE:{{ phone }}\n";
        $text .= "EMAIL:{{ email }}\n";
        $text .= $this->getProperty($content,'CATEGORIES');
        $text .= $this->getProperty($content,'NICKNAME');
        $text .= $this->getProperty($content,'NOTE');
        $text .= $this->getProperty($content,'SOURCE');
        $text .= $this->getProperty($content,'UUID');
        $text .= $this->getProperty($content,'ROLE');
        $text .= $this->getPhotoProperty($content);
        $text .= $this->getUrlProperty($content,'URL');
        // add custom links
        if (\is_array($links) == true) {
            foreach($links as $link) {
                $text .= $this->getUrlProperty($content,'URL',$link);
            }            
        }
        // add map location
        if (empty($latitude) == false && empty($longitude) == false) {
            $text .= "GEO:$latitude,$longitude\n";
        }
       
        $text .= "ADR;TYPE#HOME:;;{{ address }}{{ address_2 }};{{ city }};{{ state }};{{ zip_code }};{{ country }}\n";
        $text .= "END:VCARD\n";

        $params = \array_merge($content,$options);
        $text = Text::render($text,$params);

        return $text;
    }

    /**
     * Get vcard property
     *
     * @param array  $content
     * @param string $name
     * @return string
     */
    public function getProperty(array $content, string $name): string
    {
        $property = $content[\strtolower($name)] ?? null;

        return (empty($property) == false) ? "$name:$property\n" : '';
    } 

    /**
     * Get url prop
     *
     * @param array      $content
     * @param string     $name
     * @param array|null $property
     * @return string
     */
    public function getUrlProperty(array $content, string $name, array $property = null): string
    {
        if (\is_array($property) == true) {
            $value = $property['url'] ?? null;
            $type = $property['type'] ?? null;
        } else {
            $value = $content[\strtolower($name)] ?? null;
            $type = $content[\strtolower($name) . '_type'] ?? null;
        }
       
        if (empty($value) == true) {
            return '';
        }
        $type = (empty($type) == false) ? ";TYPE=$type" : '';

        return $name . $type . ":$value\n";       
    }

    /**
     * Get photo prop
     *
     * @param array $content
     * @return string
     */
    public function getPhotoProperty(array $content): string
    {
        $photoType = $content['photo_type'] ?? null;
        $photoEncoded = $content['photo_encoded'] ?? null;

        if (empty($photoEncoded) == false && empty($photoType) == false) {
            return "PHOTO;ENCODING=BASE64;TYPE=$photoType:$photoEncoded\n";
        }

        return '';
    }
}
