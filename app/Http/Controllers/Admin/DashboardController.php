<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PacketRequisition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $requisitionData= DB::connection('sqlsrv')
            ->table('PacketRequisition')
            ->orderBy('id','desc')->get();
        return view('admin.layouts.content',compact('requisitionData'));
    }

    public function requsitionDetails($id, Request $request)
    {

        if($request->isMethod('post'))
        {
            DB::connection('sqlsrv')
                ->table('PacketRequisition')->where('id', $id)->update(
                [
                    'pride_approved_quantity_small'=>$request->get('pride_packet_approve_quantity_small'),
                    'pride_approved_quantity_medium'=>$request->get('pride_packet_approve_quantity_medium'),
                    'pride_approved_quantity_large'=>$request->get('pride_packet_approve_quantity_large'),
                    'urban_truth_approved_quantity'=>$request->get('urban_truth_approve_quantity'),
                    'status' => '1'
                ]
            );

            PacketRequisition::where('id', $id)->update([
                    'approved_qty_small'=>$request->get('pride_approved_quantity_small'),
                    'approved_qty_medium'=>$request->get('pride_approved_quantity_medium'),
                    'approved_qty_large'=>$request->get('pride_approved_quantity_large'),
                    'ut_approved_qty'=>$request->get('urban_truth_approved_quantity'),
                    'status' => '1'
                ]);

            //send SMS
            $user_mobile = "01737119662";
            $showroom= $request->showroom;
            $sms_text = "Hello Warehouse,$showroom packet requisition request has been approved.";
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

            return back()->with('success', 'your message,here');
        }
        else
        {
            $requisitionData= DB::connection('sqlsrv')
                ->table('PacketRequisition')->where('id',$id)
                ->first();
            $pktQty=[
                'smallPkt'=>DB::connection('sqlsrv')->table('vwWareHouseItemwisestock')->where('Barcode', '392002100390')->first(),
                'mediumPkt'=>DB::connection('sqlsrv')->table('vwWareHouseItemwisestock')->where('Barcode', '391002100391')->first(),
                'largePkt'=>DB::connection('sqlsrv')->table('vwWareHouseItemwisestock')->where('Barcode', '390002100016')->first(),
                'utPkt'=>DB::connection('sqlsrv')->table('vwWareHouseItemwisestock')->where('Barcode', '219867031822')->first(),
            ];
            return view('admin.layouts.details',compact('requisitionData','pktQty'));
        }
    }


    public function regionWiseRequisition()
    {
        $sales=json_decode(DB::connection('sqlsrv')
            ->table('vwSalesInvoicewisepacketIssue')->orderBy('Region','ASC')->get()
            ->groupBy('salespoint'),true);
//
//        $sales= DB::connection('sqlsrv')
//            ->table('vwSalesInvoicewisepacketIssue')
//            ->select('salespoint','Region','Bag')
//            ->groupBy('salespoint','Region','Bag')->get();

        return view('admin.layouts.regionwise',compact('sales'));
    }

    public function zoneWiseDetails($name)
    {
        $details= DB::connection('sqlsrv')
            ->table('vwSalesInvoicewisepacketIssue')
            ->where('salespoint',$name)->get();

        dd($details);
    }


//warehouse Control
    public function requsitionViews($id, Request $request)
    {

        if($request->isMethod('post'))
        {
            $request->validate([
                'challan_number' => 'required',
            ]);
            $data= DB::connection('sqlsrv')
                ->table('PacketRequisition')->where('id', $id)->first();
            //updateChallan Number
            DB::connection('sqlsrv')
                ->table('PacketRequisition')->where('id', $id)->update(
                [
                    'challan_number'=>$request->get('challan_number'),
                    'status' => '3'
                ]
            );
            //updateChallan Number

            //update local Data
            PacketRequisition::where('id', $id)->update([
                'challan_number'=>$request->get('challan_number'),
                'status' => '3'
            ]);
            //update local Data

            //send SMS
            $user_mobile = "01843215702";
            $showroom= $data->showroom_name;
            $sms_text = "Packet requisition request for $showroom has been delivered.";
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
            return back()->with('success', 'your message,here');
        }
        else
        {
            $requisitionData= DB::connection('sqlsrv')
                ->table('PacketRequisition')->where('id',$id)
                ->first();
            $pktQty=[
                'smallPkt'=>DB::connection('sqlsrv')->table('vwWareHouseItemwisestock')->where('Barcode', '392002100390')->first(),
                'mediumPkt'=>DB::connection('sqlsrv')->table('vwWareHouseItemwisestock')->where('Barcode', '391002100391')->first(),
                'largePkt'=>DB::connection('sqlsrv')->table('vwSalesPointNItemwisestock')->where('Barcode', '390002100016')->first(),
                'utPkt'=>DB::connection('sqlsrv')->table('vwSalesPointNItemwisestock')->where('Barcode', '219867031822')->first(),
            ];
            return view('admin.layouts.view',compact('requisitionData','pktQty'));
        }
    }
}
