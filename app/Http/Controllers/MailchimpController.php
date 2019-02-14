<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MailchimpController extends Controller
{
    public function index()
    {
        $url = "https://us20.api.mailchimp.com/3.0/lists";
        $curl = curl_init();
        curl_setopt_array($curl,array(
            CURLOPT_URL=>$url,
            CURLOPT_USERPWD=>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requested Headers
                'Content-Type: application/json;charset="utf-8"',
            ),
            CURLOPT_RETURNTRANSFER => true
            ));
        $resp = curl_exec($curl);
        $resp_array = json_decode($resp,true);
        //return $resp_array['lists'][0];
        curl_close($curl);

        //Get Campaign
        $c_url = "https://us20.api.mailchimp.com/3.0/campaigns";
        $c_curl = curl_init();
        curl_setopt_array($c_curl,array(
            CURLOPT_URL=>$c_url,
            CURLOPT_USERPWD=>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requested Headers
                'Content-Type: application/json;charset="utf-8"',
            ),
            CURLOPT_RETURNTRANSFER => true
        ));
        $c_resp = curl_exec($c_curl);
        $campaign_array = json_decode($c_resp, true);

        return view('mailchimp')
            ->with(['resp_array'=>$resp_array])
            ->with(['campaign_array'=>$campaign_array]);
    }

    public function create(Request $request)
    {
        $data = json_encode($this->prepare_list($request));

        $url = "https://us20.api.mailchimp.com/3.0/lists";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_USERPWD =>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requested Headers
                'Content-Type: application/json;charset="utf-8"'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ));
        $output = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        return redirect('/mailchimp');
    }

    public function prepare_list(Request $request)
    {
        $data = array(
            'name'=> $request->name,
            'contact'=>array(
                'company'=> $request->company_name,
                'address1'=> $request->address1,
                'address2'=> '',
                'city'=> $request->city,
                'state'=> $request->state,
                'zip'=> $request->zip,
                'country'=>'MY',
                'phone'=>''),
            'permission_reminder'=>'permission reminder',
            'user_archive_bar'=>true,
            'campaign_defaults'=>array(
                'from_name'=>'from nameee',
                'from_email'=>'whoseemail12345@gmail.com',
                'subject'=>'the subject',
                'language'=>'en'),
            'notify_on_subscribe'=>'',
            'notify_on_unsubscribe'=>'',
            'email_type_option'=>false,
            'visibility'=>'pub',
            'double_optin'=>false,
            'marketing_permissions'=>false
        );
        return $data;
    }

    public function add_member(Request $request)
    {
        $data = json_encode($this->prepare_member($request));
        $url = "https://us20.api.mailchimp.com/3.0/lists/".$request->list."/members";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_USERPWD =>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requested Headers
                'Content-Type: application/json;charset="utf-8"'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ));
        $output = curl_exec($curl);
        $info = curl_getinfo($curl);

        if(curl_error($curl)){
            return curl_error($curl);
        }
        curl_close($curl);
        //return dd($output,$info);
        return redirect('/mailchimp');
    }

    public function prepare_member(Request $request)
    {
        $data = array(
            'email_address'=>$request->email,
            'status'=>'subscribed');
        return $data;
    }

    public function prepare_campaign(Request $request)
    {

        $data = array(
            'type'=>'plaintext',
            'recipients'=>array('list_id'=>$request->list),
            'settings'=>array(
                'subject_line'=>$request->subject_line,
                'preview_text'=>$request->preview_text,
                'title'=>$request->title,
                'from_name'=>$request->from_name,
                'reply_to'=>'lamky.personaltest@gmail.com')
        );
        return $data;
    }

    public function prepare_content(Request $request)
    {
        $data = array('plain_text'=>$request->plain_text);

        return $data;
    }

    public function create_campaign(Request $request)
    {
        $data = json_encode($this->prepare_campaign($request));
        $url = "https://us20.api.mailchimp.com/3.0/campaigns";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_USERPWD =>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requested Headers
                'Content-Type: application/json;charset="utf-8"'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ));
        $output = curl_exec($curl);
        $info = curl_getinfo($curl);

        if(curl_error($curl)){
            return curl_error($curl);
        }
        curl_close($curl);

        $campaign_resp = json_decode($output,true);
        $request->campaign_id = $campaign_resp['id'];
        $content_resp = $this->create_content($request);
        //return dd($output,$content_resp);
        return redirect('/mailchimp');
    }

    public function create_content(Request $request)
    {
        $curl = curl_init();
        $data = json_encode($this->prepare_content($request));
        $url = "https://us20.api.mailchimp.com/3.0/campaigns/".$request->campaign_id."/content";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_USERPWD =>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function launch_campaign(Request $request)
    {
        $curl = curl_init();
        $url = "https://us20.api.mailchimp.com/3.0/campaigns/".$request->id."/actions/send";
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_USERPWD =>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"

            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            //return $response;
            return redirect('/mailchimp');
        }
    }



    //For Testing
    public function test()
    {
        $data = array(
            'name'=>'test name',
            'contact'=>array(
                'company'=>'company name',
                'address1'=>'address for 1',
                'address2'=>'',
                'city'=>'city field',
                'state'=>'state field',
                'zip'=>'53300',
                'country'=>'MY',
                'phone'=>''),
            'permission_reminder'=>'permission reminder',
            'user_archive_bar'=>true,
            'campaign_defaults'=>array(
                'from_name'=>'from nameee',
                'from_email'=>'whoseemail12345@gmail.com',
                'subject'=>'the subject',
                'language'=>'en'),
            'notify_on_subscribe'=>'',
            'notify_on_unsubscribe'=>'',
            'email_type_option'=>false,
            'visibility'=>'pub',
            'double_optin'=>false,
            'marketing_permissions'=>false
        );
        return $data;
    }

    public function create_list()
    {
        $url = "https://us20.api.mailchimp.com/3.0/lists";
        $curl = curl_init();

        $data = json_encode($this->test());

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_USERPWD =>"any:".env('MAILCHIMP_APIKEY'),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requested Headers
                'Content-Type: application/json;charset="utf-8"'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ));
        $output = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        return dd($info,$output);
        //return "OUTPUT:".$output."INFO:".$info;
    }
}