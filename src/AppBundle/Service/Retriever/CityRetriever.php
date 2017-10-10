<?php

namespace AppBundle\Service\Retriever;

class CityRetriever
{
    /**
     * @var Buzz\Browser
     */
    private $browser;

    /**
     * @var string
     */
    private $key;

    public function __construct($browser, $key)
    {
        $this->browser = $browser;
        $this->key = $key;
    }

    public function retrieve($name)
    {
        $url = str_replace(' ', '%20', sprintf(
            'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=%s&key=%s&regions=locality&langage=fr&components=country:fr',
            $name,
            $this->key
        ));


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $cities = json_decode($response, true);

        if (array_key_exists('error_message', $cities)) {
            throw new \Exception($cities['error_message']);
        }

        if (!is_array($cities) || !array_key_exists('predictions', $cities)) {
            return [];
        }

        $citiesList = array();
        foreach ($cities['predictions'] as $city) {
            if (array_key_exists('description', $city)) {
                $citiesList[] = array('id' => $city['description'], 'text' => $city['description']);
            }
        }

        return $citiesList;
    }

    public function getNeighborhoods($city)
    {
        return array(
            'Annappes' => 'Annappes',
            'Ascq' => 'Ascq',
            'Babylone' => 'Babylone',
            'Breucq' => 'Breucq',
            'Chateau' => 'Chateau',
            'Cousinerie' => 'Cousinerie',
            'Flers Bourg' => 'Flers Bourg',
            'Haute Borne' => 'Haute Borne',
            'Hotel de ville' => 'Hotel de ville',
            'Les Pres' => 'Les Pres',
            'Pont de bois' => 'Pont de bois',
            'Recueil' => 'Recueil',
            'Résidence' => 'Résidence',
            'Triolo' => 'Triolo',
        );
    }
}
