<?php

namespace Aamv\Bundle\SiteBundle\Retriever;

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

            $url = sprintf(
                $baseUrl,
                $this->login,
                $this->key,
                $postalCode
            );
        } else {
            $url = sprintf(
                $baseUrl . '&ville=%s',
                $this->login,
                $this->key,
                $postalCode,
                $name
            );
        }


        $cities = json_decode($this->browser->get($url)->getContent(), true);

        $citiesList = array();
        foreach ($cities['results'] as $city) {
            $citiesList[] = array('id' => $city['ville'], 'text' => $city['ville']);
        }

        return $citiesList;
    }
}
