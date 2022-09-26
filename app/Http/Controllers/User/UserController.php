<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PacketRequisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        $requisitionData= DB::connection('sqlsrv')
            ->table('PacketRequisition')
            ->where('showroom_name', Auth::user()->sales_point_name)
            ->where('showroom_external_id', Auth::user()->shop_id)->orderBy('id','desc')->get();
        return view('auth.content',compact('requisitionData'));
    }

    public function requisition(Request $request)
    {
        if($request->isMethod('post'))
        {
            //sql server save data
            DB::connection('sqlsrv')
                ->table('PacketRequisition')->insert([
                    'showroom_name' => Auth::user()->sales_point_name,
                    'showroom_external_id' => Auth::user()->shop_id,
                    'pride_small_packet_current_quantity' => $request->get('pride_small_packet_current_quantity'),
                    'pride_medium_packet_current_quantity' => $request->get('pride_medium_packet_current_quantity'),
                    'pride_large_packet_current_quantity' => $request->get('pride_large_packet_current_quantity'),
                    'pride_packet_quantity_small' => $request->get('pride_packet_quantity_small'),
                    'pride_packet_quantity_medium' => $request->get('pride_packet_quantity_medium'),
                    'pride_packet_quantity_large' => $request->get('pride_packet_quantity_large'),
                    'urban_truth_packet_current_quantity' => $request->get('urban_truth_packet_current_quantity'),
                    'urban_truth_packet_quantity' => $request->get('urban_truth_packet_quantity'),
                    'status' => '2',
                    'date' => date("Y-m-d")
                ]);

            //local server save data
                $packetReq = new PacketRequisition();
                $packetReq->user_id = Auth::user()->id;
                $packetReq->physical_qty_small = $request->get('pride_small_packet_current_quantity');
                $packetReq->physical_qty_medium = $request->get('pride_medium_packet_current_quantity');
                $packetReq->physical_qty_large = $request->get('pride_large_packet_current_quantity');
                $packetReq->request_qty_small = $request->get('pride_packet_quantity_small');
                $packetReq->request_qty_medium = $request->get('pride_packet_quantity_medium');
                $packetReq->request_qty_large = $request->get('pride_packet_quantity_large');
                $packetReq->ut_physical_qty = $request->get('urban_truth_packet_current_quantity');
                $packetReq->ut_request_qty = $request->get('urban_truth_packet_quantity');
                $packetReq->status = '2';
                $packetReq->date = date("Y-m-d");
                $packetReq->save();

        //send SMS
        $user_mobile = "01843215702";
        $showroom= Auth::user()->sales_point_name;
        $sms_text = "You have a notification from packet requisition for $showroom.Please check The panel for details";
        $user = "userName";
        $pass = "Password";
        $sid = "stackHolderId";
        //$sid="PrideLtdBng";
        $url = "Url";
        $param = "user=$user&pass=$pass&sms[0][0]=$user_mobile&sms[0][1]=". $sms_text . "&sms[0][2]=1234567890&sid=$sid";
        $crl = curl_init();
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_HEADER, 0);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_POST, 1);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $param);
        $response = curl_exec($crl);
        curl_close($crl);
        //send SMS
           return  back();
        }
        else
        {

            //Fetch data
            $requestData= DB::connection('sqlsrv')
                ->table('PacketRequisition')
                ->where('showroom_name', Auth::user()->sales_point_name)
                ->where('showroom_external_id', Auth::user()->shop_id)->where('status', '2')->orderBy('id','desc')->first();

                return view('auth.requisition',compact('requestData'));


        }

    }
}
