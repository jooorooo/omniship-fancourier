<?php

namespace Omniship\Fancourier;

use App\Http\Controllers\Controller;
use Infifni\FanCourierApiClient\Client as ApiClient;
use Omniship\Fancourier\Lib\City;
use Omniship\Fancourier\Http\AbstractRequest;
use Infifni\FanCourierApiClient\Request\City as ApiCity;
use Omniship\Fancourier\Lib\Street;
use Omniship\Helper\Collection;

class Client
{
    protected $username;
    protected $password;
    protected $client_id;
    protected $language;

    public function __construct($username, $password, $client_id, $language)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client_id = $client_id;
        $this->language = $language;
    }

    protected $cityFields = [
        'ro' => [
            'city' => 'localitate',
            'fan_city_id' => 'id_localitate_fan',
            'county' => 'judet'
        ],
        'en' => [
            'city' => 'city',
            'fan_city_id' => 'fan_city_id',
            'county' => 'county'
        ],
    ];

    protected $streetFileds = [
        'ro' => [
            'street_id' => 'id_strada',
            'county' => 'judet',
            'city' => 'localitate',
            'name' => 'strada',
            'zipcode' => 'cod_postal'
        ],
        'en' => [
            'street_id' => 'street_id',
            'county' => 'county',
            'city' => 'city',
            'name' => 'street',
            'zipcode' => 'zip_code'

        ]
    ];

    public function getCities($zone = null, $name = null, $report_type = null)
    {
        $collection = [];
        $cities =(new ApiClient($this->client_id,$this->username,$this->password))->city([ 'language' => $this->language]);

        if (!empty($cities) && !empty($cities)) {
            $collection = array_map(function($city) {
                return new City([
                    'id' => $city[$this->cityFields[$this->language]['fan_city_id']],
                    'name' => $city[$this->cityFields[$this->language]['city']],
                    'state' => $city[$this->cityFields[$this->language]['county']]
                ]);
            },$cities);
        }
        return new Collection($collection[0]);
    }

    public function getStreet($state = null, $local = null){
        $streets = (new ApiClient($this->client_id, $this->username, $this->password))->streets(['judet' => $state, 'localitate' => $local, 'language' => $this->language]);
        if(!empty($streets)){
            $collection = array_map(function ($street){
               return new Street([
                   'id' => $street[$this->streetFileds[$this->language]['street_id']],
                   'name' => $street[$this->streetFileds[$this->language]['name']],
                   'zipcode' => $street[$this->streetFileds[$this->language]['zipcode']],
                   'county' =>  $street[$this->streetFileds[$this->language]['county']],
                   'city' =>  $street[$this->streetFileds[$this->language]['city']],
               ]);
            }, $streets);
        }
        return new Collection($collection);
    }


}
