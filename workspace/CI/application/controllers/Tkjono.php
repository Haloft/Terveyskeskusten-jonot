<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../vendor/autoload.php';
use GuzzleHttp\Client;

define('REST_SERVER', 'https://api.ouka.fi/v1/chc_waiting_times_monthly_stats');

class Tkjono extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }
    
        public function index($sortBy = NULL) {
            $client = new Client ([
                'base_url' => REST_SERVER, 
                'timeout' => 2.0,
                'verify' => false
                ]);
            
            if ($sortBy == NULL && isset($_SESSION['sortby'])) {
                $sortBy = $_SESSION['sortby'];
            }   
                
//Haetaan kaikki tiedot aikajärjestyksessä            
            $response = $client->get(REST_SERVER . '?order=year.desc,month.desc,day.desc');
            $result = json_decode($response->getBody(), true);
        
//Haetaan klinikat listaan ja järjestetään aakkosjärjestykseen
            $clinics = array_unique(array_column($result, 'chc'));
            sort($clinics);
        
            $firstInstances = array();
        
//Haetaan jokaisen klinikan ensimmäinen (uusin) merkintä. Tämän voi varmaan toteuttaa nätimminkin funktioilla
            for ($i = 0; $i < count($clinics); $i++) {
                for ($j = 0; $j < count($result); $j++) {
                    if ($result[$j]['chc'] == $clinics[$i]) {
                        $firstInstances[] = $result[$j];
                        break;
                    }
                }
            }
        
//Karsitaan turhat tiedot        
            $clinicWaitingTimes = array();
            foreach ($firstInstances as $firstInstance) {
                $clinicWaitingTimes[] = array ('date' => $firstInstance['time'], 'clinic' => $firstInstance['chc'], 'doctor_queue' => $firstInstance['doctor_queue'], 'nurse_queue' => $firstInstance['nurse_queue']); 
            }
   
//Järjestetään tarpeen vaatiessa. En ymmärrä miksi globaaliksi julistettu $sortBy ei toimi funktion sisällä        
            if ($sortBy != NULL) {
                $_SESSION['sortby'] = $sortBy;
                usort($clinicWaitingTimes, function ($a, $b) use ($sortBy) {
                    if ($a[$sortBy] - $b[$sortBy] != 0) {
                        return $a[$sortBy] - $b[$sortBy];    
                    } else {
                        return strcmp($a['clinic'], $b['clinic']);
                    }
                });
            }
            
//lisätään odotusajat $data-listaan              
            $data['clinicWaitingTimes'] = $clinicWaitingTimes;
        
//Ladataan sivut
            $this->load->view('templates/header');
            $this->load->view('tkjono/index', $data);
            $this->load->view('templates/footer');        
        
        }
        
        public function view_clinic($clinic = NULL) {
            $client = new Client ([
                'base_url' => REST_SERVER, 
                'timeout' => 2.0,
                'verify' => false
                ]);
            
            $response = $client->get(REST_SERVER . '?order=year.desc,month.desc,day.desc&chc=fts.' . $clinic);
            $result = json_decode($response->getBody(), true);
            
             
            
            $data['clinic'] = $result[0]['chc'];
            
            $data['latest'] = array ('date' => $result[0]['time'], 'doctor_queue' => $result[0]['doctor_queue'], 'nurse_queue' => $result[0]['nurse_queue']);
            $data['lastMonth'] = array ('date' => $result[1]['time'], 'doctor_queue' => $result[1]['doctor_queue'], 'nurse_queue' => $result[1]['nurse_queue']);
            $doctorAverage = ceil(($result[0]['doctor_queue'] + $result[1]['doctor_queue'] + $result[2]['doctor_queue'] + $result[3]['doctor_queue'] + $result[4]['doctor_queue'] + $result[5]['doctor_queue']) / 6);
            $nurseAverage = ceil(($result[0]['nurse_queue'] + $result[1]['nurse_queue'] + $result[2]['nurse_queue'] + $result[3]['nurse_queue'] + $result[4]['nurse_queue'] + $result[5]['nurse_queue']) / 6);
            $data['averages'] = array ('doctorAverage' => $doctorAverage, 'nurseAverage' => $nurseAverage);
            $data['averageDates'] = array ('startingPoint' => $result[5]['time'], 'endingPoint' => $result[0]['time']);
            
            $this->load->view('templates/header');
            $this->load->view('tkjono/view', $data);
            $this->load->view('templates/footer');      
        }
    
}

