<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api_Model extends CI_Model {

    public function api(){
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://weatherapi-com.p.rapidapi.com/forecast.json?q=Kolkata&days=3",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"x-rapidapi-host: weatherapi-com.p.rapidapi.com",
				"x-rapidapi-key: dfaa79d350mshe1c64d43396c71bp1cdd04jsn2f5eda3e7fd8"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// $response = file_get_contents($response);
			$responseData = json_decode($response,true);
			$data = $responseData;
			if($data){
				return $data;
			}
				
		}
    }
    public function getByCity($city){
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://weatherapi-com.p.rapidapi.com/forecast.json?q=".$city."&days=3",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"x-rapidapi-host: weatherapi-com.p.rapidapi.com",
				"x-rapidapi-key: dfaa79d350mshe1c64d43396c71bp1cdd04jsn2f5eda3e7fd8"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// $response = file_get_contents($response);
			$responseData = json_decode($response,true);
			$data = $responseData;
			if(isset($data['forecast']) && isset($data['location'])){
                $forecast = '';
                foreach($data['forecast']['forecastday'] as $x):
                $forecast .= '<li class="col-4 col-sm-4 pl-1 text-center">
                                    <h3 class="h5">'.date("D", strtotime($x['date'])).'</h3>
                                    <p style="font-size: 13px;"><img src="'.$x['day']['condition']['icon'] .'" alt=""><br>'.$x['day']['mintemp_c'].'&deg; /'.$x['day']['maxtemp_c'].'&deg;</p>
                                </li>';
                endforeach;
                $output = '<div class="main container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-12 col-sm-6 offset-sm-3 col-lg-4 offset-lg-4 row weather-panel">
                                        <div class="col-6 pt-3">
                                            <h2> '.strtoupper($data['location']['name'])  .'<br><small> '.date("M d, Y", strtotime($data['location']['localtime'])) .'</small></h2>
                                            <p class="h3" style="font-size: 25px!important;"><img src=" '.$data['forecast']['forecastday'][0]['day']['condition']['icon']  .'">  '.$data['forecast']['forecastday'][0]['day']['condition']['text']  .'</p>
                                        </div>
                                        <div class="col-6 text-center">
                                            <div class="h1 temperature pt-5">
                                                <span> '.$data['forecast']['forecastday'][0]['day']['avgtemp_c'].'&deg;</span>
                                                <br>
                                                <small> '.$data['forecast']['forecastday'][0]['day']['mintemp_c'].'&deg; / '.$data['forecast']['forecastday'][0]['day']['maxtemp_c'].'&deg;</small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <ul class="list-inline row justify-content-center forecast">
                                                '.$forecast.'
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                return $output;
            }else{
                $city = 'kolkata';
                getByCity($city);
            }
		}
    }
}

?>