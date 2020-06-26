<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
  private function cmp($a, $b)
  {
    return $a['to_year'] === -1 ? -1 : (
      ($a['to_year'] > $b['to_year']) ? -1 : 1
    );
  }
  public function search(Request $request, $query='')
  {
    $query = trim($query);
    $response = Http::get('https://s3-ap-southeast-2.amazonaws.com/reejig.com/code-test/data.json');
    if($response->successful()){
      $contacts = $response->json()['contacts'];
      if($query)
        $keywords = explode(' ', $query);
      else
        $keywords = [];

      foreach($contacts as $key => $contact) {
        foreach($keywords as $keyword){
          if(stripos($contact['city'], $keyword)===false 
            && (strtolower($contact['gender']) !== strtolower($keyword))
            && stripos($contact['firstname'], $keyword)===false
            && stripos($contact['lastname'], $keyword)===false
          ){
              unset($contacts[$key]);
              continue 2;
          }
        }
        usort($contact['experiences'], array($this, 'cmp'));
        $contacts[$key]['current_company'] =   $contact['experiences'][0]['company']['name'];
        $contacts[$key]['current_job_title'] = $contact['experiences'][0]['job_title'];
        unset($contacts[$key]['experiences']);
      }
      return response()->json($contacts, 200);
    }else{
      return response()->json([
          'error' => 'Service unavailable',
        ], 503)
        ->header("Access-Control-Allow-Origin",  "*");
    }
  }
}

?>