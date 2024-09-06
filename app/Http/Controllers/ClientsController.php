<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends Controller
{
    private $clients_path;

    public function __construct() {
      $this->clients_path = base_path().'/resources/clients/';
    }

    public function index($id = null) {
      $array_for_view = [
        'js' => ['form']
      ];

      if ($id && session('admin') != null && file_exists($this->getFileName($id))) {
        $data = json_decode($this->getJsonFile($id), true);
        $data['law_status'] = $data['law_status'] == 'Firma' ? 'company' : 'person';
        $data['id'] = $id;
      } else {
        $data = ['law_status' => 'person', 'street' => '', 'local' => '', 'city' => '', 'zip_code' => '', 'region' => '', 'phone_start' => '', 'phone' => '', 'email' => '', 'person_name' => '', 'person_id' => '', 'company_name' => '', 'company_id' => ''];
      }

      return view('form', array_merge($array_for_view, $data));
    }

    public function store(Request $req) {
      $data = $req->all();
      $keys = ['law_status', 'street', 'local', 'city', 'zip_code', 'region', 'phone_start', 'phone', 'email'];

      $law_status = $data['law_status'] ?? null;
      switch ($law_status) {
        case 'person':
          array_push($keys, 'person_name', 'person_id');
          $data['law_status'] = "Osoba prywatna";
          break;
        case 'company':
          array_push($keys, 'company_name', 'company_id');
          $data['law_status'] = "Firma";
          break;
        default: break;
      }

      $validation = true;
      $validators = [
        'zip_code' => ['regexp' => '/^\d{2}-\d{3}$/', 'errorText' => 'Błędny kod pocztowy'],
        'phone_start' => ['regexp' => '/^(\+\d{2})?$/', 'errorText' => 'Błędny numer kierunkowy'],
        'phone' => ['regexp' => '/^\d{9}$/', 'errorText' => 'Błędny numer telefonu'],
        'email' => ['errorText' => 'Nieprawidłowy email'],
        'person_id' => ['regexp' => '/^\d{11}$/', 'errorText' => 'Błędny pesel'],
        'company_id' => ['regexp' => '/^\d{10}$/', 'errorText' => 'Błędny nip']
      ];

      $json = [];
      $errors = [];

      foreach($keys as $k) {
        if (isset($data[$k])) {
          if (isset($validators[$k])) {
            if ($k == 'email') {
              if (! filter_var($data[$k], FILTER_VALIDATE_EMAIL)) {
                $errors[$k] = $validators[$k]['errorText'];
                $validation = false;
              }
            } else {
              if (! preg_match($validators[$k]['regexp'], $data[$k])) {
                $errors[$k] = $validators[$k]['errorText'];
                $validation = false;
              }
            }
          }
          $json[$k] = $data[$k];
        }
      }

      $id = time();

      if (isset($data['id']) && session('admin') != null && file_exists($this->getFileName($data['id']))) {
        $id = $data['id'];
      }

      if ($validation) {
        file_put_contents($this->clients_path."$id.json", json_encode($json));
        echo json_encode(['success' => true, 'id' => $id]);
      } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
      }
      exit;
    }

    public function read(Request $req) {
      $scan = scandir($this->clients_path);
      if (! $scan) {

      }

      $clients = [];

      for ($i = 3, $imax = count($scan); $i < $imax; $i++) {
        $clients[] = rtrim($scan[$i], '.json');
      }
      return view('clients', [
        'css' => ['clients'],
        'clients' => $clients
      ]);
    }

    public function show(Request $req, $id) {
      return view('client', array_merge(
        [
          'css' => ['client'],
          'id' => $id
        ],
        json_decode($this->getJsonFile($id), true)
      ));
    }

    public function json(Request $req, $id) {
      header('Content-Type: application/json');
      echo $this->getJsonFile($id);
      exit;
    }

    public function delete(Request $req) {
      $filename = $this->getFileName($req->input('id'));
      if (file_exists($filename)) {
        unlink($filename);
      }
      return redirect('/clients');
    }

    private function getJsonFile($id) {
      return file_get_contents($this->getFileName($id));
    }

    private function getFileName($id) {
      return $this->clients_path."$id.json";
    }
}
