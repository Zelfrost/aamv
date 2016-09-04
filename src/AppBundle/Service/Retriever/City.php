<?php

namespace AppBundle\Service\Retriever;

class City
{
    private $browser;
    private $login;
    private $key;

    public function __construct($browser, $login, $key)
    {
        $this->browser = $browser;
        $this->login = $login;
        $this->key = $key;
    }

    public function retrieve($name)
    {
        $baseUrl = 'http://www.citysearch-api.com/fr/city?login=%s&apikey=%s&cp=%d';
        $postalCode = 59;

        if (is_numeric($name)) {
            $postalCode = (int) $name;
        } else {
            $baseUrl .= '&ville=%s';
        }

        $url = sprintf(
            $baseUrl,
            $this->login,
            $this->key,
            $postalCode,
            $name
        );

        $cities = json_decode($this->browser->get($url)->getContent(), true);

        $citiesList = array();
        foreach ($cities['results'] as $city) {
            $citiesList[] = array('id' => $city['ville'], 'text' => $city['ville']);
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
