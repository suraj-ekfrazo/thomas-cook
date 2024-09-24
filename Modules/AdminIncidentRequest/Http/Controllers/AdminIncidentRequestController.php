<?php

namespace Modules\AdminIncidentRequest\Http\Controllers;

use App\Models\Incidents;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminIncidents\Entities\DocumentComments;
use Modules\AdminIncidents\Entities\Incident;
use Modules\AdminIncidents\Entities\IncidentBuyDocuments;
use Modules\AdminIncidents\Entities\IncidentCurrency;
use Modules\AdminIncidents\Entities\IncidentSellDocuments;
use Modules\AdminIncidents\Entities\IncidentUpdate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class AdminIncidentRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        return view('adminincidentrequest::index');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $searchValue = $input['search_keywords']; // Search value
        $array = [
            'id', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number',
            'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number', 'inci_number',
            'inci_number',
            'created_at'
        ];
        $column = $input['order'][0]['column'];
        $query = Incident::with([
            'incidentUpdate',
            'incidentCurrency',
            'buyDocuments',
            'sellDocuments',
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ])->where('inci_number', 'like', '%' . $searchValue . '%')->orderBy($array[$column], $input['order'][0]['dir']);

        if ($input['from_date'] != '' && $input['to_date'] != '') {
	    
            $from_date = date('Y-m-d H:i:s', strtotime($input['from_date']));
            $to_date = date('Y-m-d H:i:s', strtotime($input['to_date']));

            $query = Incident::with([
                
                'incidentCurrency',
                'buyDocuments',
                'sellDocuments',
                'incidentAssign' => function ($query) {
                    $query->select('id', 'name', 'user_code', 'email');
                }, 'agent' => function ($query) {
                    $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
                }
            ])->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                $query->where('created_at', '>=', $from_date)->where('created_at', '<=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
	    	    
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query = Incident::with([
                'incidentUpdate',
                'incidentCurrency',
                'buyDocuments',
                'sellDocuments',
                'incidentAssign' => function ($query) {
                    $query->select('id', 'name', 'user_code', 'email');
                }, 'agent' => function ($query) {
                    $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
                }
            ])->where('inci_number', 'like', '%' . $searchValue . '%')->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('created_at', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('created_at', '=', $to_date);
            })->orderBy($array[$column], $input['order'][0]['dir']);
        }

        $result['draw'] = $input['draw'];
        $result['recordsTotal'] = $query->count();
        $result['recordsFiltered'] = $query->count();
        $result['data'] = $query->skip($input['start'])->take($input['length'])->get()->toArray();
        if ($result) {
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Success', 'data' => $result['data'], 'recordsTotal' => $result['recordsTotal'], 'recordsFiltered' => $result['recordsFiltered']));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }

    public function getDocumentList($id)
    {
      
        $incidentDetails = Incident::find($id);
        if ($incidentDetails) {
       
            // default variable set
            // $incidentDocuments = array();
            $incidentImageDetails = array();
           
            $incidentImageDetails=Incidents::with('buy_incident','sell_incident')->where('inci_number', $id)->first();
           // $incidentImageDetails['incedent_doc'] = (object)[];
            if(isset($incidentImageDetails['buy_incident']) && !empty($incidentImageDetails['buy_incident'])) {
                $incidentImageDetails['incedent_doc'] = $incidentImageDetails['buy_incident'];
            } else if(isset($incidentImageDetails['sell_incident']) && !empty($incidentImageDetails['sell_incident'])) {
                $incidentImageDetails['incedent_doc'] = $incidentImageDetails['sell_incident'];
            }
            unset($incidentImageDetails['buy_incident']);
            unset($incidentImageDetails['sell_incident']);
        
            $incidentUpdateDetails = Incidents::where('inci_key', '=', $incidentDetails->inci_key)->first();
           
            if ($incidentUpdateDetails) {
                if ($incidentDetails->inci_buy_sell_req == 1) {
                    $incidentImageDetails = IncidentSellDocuments::where('incident_number', $incidentDetails->inci_number)->orderBy('id','DESC')->limit(1)->get();
                } else {
                    $incidentImageDetails = IncidentBuyDocuments::where('incident_number', $incidentDetails->inci_number)->orderBy('id','DESC')->limit(1)->get();
                }
                $documentComments = DocumentComments::where('incident_number', $incidentDetails->inci_number)->get();
                $currencyRecords = IncidentCurrency::where('incident_id', $incidentDetails->inci_number)->get();
                $incDate = date('y-m-d', strtotime($incidentDetails->inci_create_time));
            } else {
                return redirect()->route('admin-incident-requests.index')->with('error', 'Incident update details not found!');
            }

//echo json_encode($incidentImageDetails);exit;
            // return view('admin.bookingRequestDetails-v2', compact('incidentUpdateDetails', 'incidentImageDetails', 'incidentDetails', 'newDate', 'incDate', 'documentComments', 'incidentDetails', 'currencyRecords', 'incidentDocuments'));
		//print_r($incidentImageDetails);exit;
            return view('adminincidentrequest::documents', compact('incidentImageDetails', 'incidentUpdateDetails', 'incidentDetails', 'incDate', 'documentComments', 'incidentDetails', 'currencyRecords'));
        } else {
            return redirect()->route('admin-incident-requests.index')->with('error', 'No incident found!');
        }
    }


    public function getImage($path)
    {
        //Here we use mime for getting particular file type
        if (!file_exists(url($path))) {
            return $imageAns = "''";
        }
        $fileType = mime_content_type($path);

        //then here we divided file type
        $fileExtension = '';
        $pieces = explode("/", $fileType);

        if ($pieces[0] == "application")
            $fileExtension = $pieces[1];
        elseif ($pieces[0] == "text")
            $fileExtension = $pieces[1];
        else
            $fileExtension = $pieces[0];
        $imageAns = '';


        switch ($fileExtension) {
            case "pdf":
                return $imageAns = "https://i.ibb.co/bQQv8pM/kisspng-pdf-computer-icons-download-pdf-5b3643b8acb769-6550170315302829367075.jpg";

            case "zip":
                return $imageAns = "https://i.ibb.co/bHD0yvT/zip.png";
            case "msword": //.doc
                return $imageAns = "https://i.ibb.co/gmvKb0b/Microsoft-Word-logo.png";

            case "json": //json
                return $imageAns = "https://i.ibb.co/QP5507Q/5ea1a1bc9c.png";

            case "rtf": //Rict Text
                return $imageAns = "https://i.ibb.co/rQkXg6v/v-40-512.png";

            case "vnd.ms-excel": //Excel
                return $imageAns = "https://i.ibb.co/CwYkbC2/kisspng-microsoft-excel-training-computer-software-microso-excel-5ad7d9f121bed2-0123007315240954731382.jpg";

            case "video":
                return $imageAns = "https://i.ibb.co/LrbVrd0/kisspng-sound-recording-copyright-symbol-registered-tradem-video-5abcbe30d0f376-7701066915223188968559.jpg";

            case "audio":
                return $imageAns = "https://i.ibb.co/smD5rjs/53824.png";

            case "image":
                return $imageAns = " https://i.ibb.co/LSwFJr4/no-image.png";

            case "html":
                return $imageAns = "https://i.ibb.co/0FBSYt6/kisspng-html-computer-icons-html-css-5b3e4919d736f3-2258832915308086018815.jpg";


            case "xml":
                return $imageAns = "https://i.ibb.co/y8GG3dP/kisspng-xml-document-type-definition-markup-language-html-mcqueen-5ac8726fad7942-1640253115230859357106.jpg";

            case "sql":
                return $imageAns = "https://i.ibb.co/y8GG3dP/kisspng-xml-document-type-definition-markup-language-html-mcqueen-5ac8726fad7942-1640253115230859357106.jpg";

            case "xls":
                return $imageAns = "https://i.ibb.co/y8GG3dP/kisspng-xml-document-type-definition-markup-language-html-mcqueen-5ac8726fad7942-1640253115230859357106.jpg";

            case "plain":
                return $imageAns = "https://i.ibb.co/TLwt4xM/083-duplicate-text-document-copy-files-doc-512.png";

            case "javascript":
                return $imageAns = "https://i.ibb.co/1dJ5gSv/js-512.png";

            default:
                return $imageAns = "https://i.ibb.co/XYKR10g/file-blank-empty-default-512.png";
        }
    }

    //Export Buy data
    public function tableDataExport(Request $request)
    {

        $input = $request->all();
        $query = Incident::with([
            'incidentUpdate',
            'incidentCurrency',
            'buyDocuments',
            'sellDocuments',
            'incidentAssign' => function ($query) {
                $query->select('id', 'name', 'user_code', 'email');
            }, 'agent' => function ($query) {
                $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
            }
        ]);

        if ($input['from_date'] != '' && $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                $query->where('inci_create_time', '>=', $from_date)->where('inci_recived_date', '<=', $to_date);
            });
        } else if ($input['from_date'] != '' || $input['to_date'] != '') {
            $from_date = date('Y-m-d', strtotime($input['from_date']));
            $to_date = date('Y-m-d', strtotime($input['to_date']));

            $query->where(function ($query) use ($from_date, $to_date) {
                if ($from_date != '')
                    $query->where('inci_create_time', '=', $from_date);
                else if ($to_date != '')
                    $query->Where('inci_create_time', '=', $to_date);
            });
        }

        $result['data'] = $query->orderBy('id','DESC')->get()->toArray();

        if ($result) {

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Incident Number');
            $sheet->setCellValue('B1', 'TC User Name ');
            $sheet->setCellValue('C1', 'Agent Code');
            $sheet->setCellValue('D1', 'Agent Name');
            $sheet->setCellValue('E1', 'Card number');
            $sheet->setCellValue('F1', 'Passport No.');
            $sheet->setCellValue('G1', 'Transaction Type');
            $sheet->setCellValue('H1', 'FX Currency');
            $sheet->setCellValue('I1', 'FX Amount');
            $sheet->setCellValue('J1', 'FX Rate');
            $sheet->setCellValue('K1', 'INR Amount');
            $sheet->setCellValue('L1', 'With Documents?');
            $sheet->setCellValue('M1', 'Status');
            $sheet->setCellValue('N1', 'Travel Departure Date');
            $sheet->setCellValue('O1', 'Comment');
            $sheet->setCellValue('P1', 'Bordx No.');
            $sheet->setCellValue('Q1', 'Cashier');
            $sheet->setCellValue('R1', 'Booking Date');
            $sheet->setCellValue('S1', 'Booking Time');
            $sheet->setCellValue('T1', 'Doc Upload Date');
            $sheet->setCellValue('U1', 'Doc Upload Time');
            $sheet->setCellValue('V1', 'Completed Date');
            $sheet->setCellValue('W1', 'Completed Time');
            /*$sheet->setCellValue('X1', 'Create Date');*/
            $rows = 2;

            foreach ($result['data'] as $key => $value) {
                $sheet->setCellValue('A' . $rows, ucwords($value['inci_number']));
                $sheet->setCellValue('B' . $rows, ucwords($value['incident_assign'] ? $value['incident_assign']['user_code'] : '' ));
                $sheet->setCellValue('C' . $rows, ucwords($value['agent']['agent_key']));
                $sheet->setCellValue('D' . $rows, ucwords($value['agent']['first_name'] . ' ' . $value['agent']['last_name']));
                $sheet->setCellValue('E' . $rows, ucwords($value['inci_forex_card_no']));
                $sheet->setCellValue('F' . $rows, ucwords($value['inci_passport_number']));
                $transactionType = $value['transaction_type'];
                if($transactionType==1){
                    $transactionName = "Activation";
                } else if ($transactionType == '2') {
                    $transactionName = "Reload";
                } else if ($transactionType == '3') {
                    $transactionName = "Activation + Reload";
                } else{
                    $transactionName = "Encashment";
                }

                $sheet->setCellValue('G' . $rows, ucwords($transactionName));

                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $internationalCurrency = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $currencyType = $data['inci_currency_type'];
                        $internationalCurrency = $currencyType;
                    }

                }

                $sheet->setCellValue('H' . $rows, ucwords($internationalCurrency));
                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $amount = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $amount = $data['inci_frgn_curr_amount'];
                    }
                }
                $sheet->setCellValue('I' . $rows, ucwords($amount));

                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $rate = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $rate = $data['inci_currency_rate'];
                    }

                }
                $sheet->setCellValue('J' . $rows, ucwords($rate));
                if ($value['incident_currency'] && count($value['incident_currency']) > 0) {
                    $inr_amount = '';
                    foreach($value['incident_currency'] as $key => $data) {
                        $inr_amount = $data['inci_inr_amount'];
                    }
                }
                $sheet->setCellValue('K' . $rows, ucwords($inr_amount));
                if (($value['buy_documents'] && count($value['buy_documents']) > 0) || ($value['sell_documents'] && count($value['sell_documents']) > 0)) {
                    $buyYesNo = 'Yes';
                } else {
                    $buyYesNo = 'No';
                }
                $sheet->setCellValue('L' . $rows, $buyYesNo);
                $acceptStatus = '';
                if (isset($value['inci_status']))
                    $acceptStatus = $value['inci_status'];
                if ($acceptStatus == '0')
                    $acceptStatusStr = 'Rejected';
                else if ($acceptStatus == '1')
                    $acceptStatusStr = 'Approved';
                else if ($acceptStatus == '2')
                    $acceptStatusStr = 'Expired';
                else
                    $acceptStatusStr = 'Under Process';
                $sheet->setCellValue('M' . $rows, $acceptStatusStr);
                $sheet->setCellValue('N' . $rows, ucwords($value['inci_departure_date']));
                $sheet->setCellValue('O' . $rows, isset($value['inci_status_message']) ? ucwords($value['inci_status_message']) : '');
                $sheet->setCellValue('P' . $rows, isset($value['bordox_no']) ? ucwords($value['bordox_no']) : '');
                $sheet->setCellValue('Q' . $rows, ucwords("Admin"));
                $sheet->setCellValue('R' . $rows, isset($value['inci_create_time']) ? date('d-m-Y', strtotime($value['inci_create_time'])) : '');
                $sheet->setCellValue('S' . $rows, isset($value['inci_create_time']) ? date('H:i:s', strtotime($value['inci_create_time'])) : '');
                $sheet->setCellValue('T' . $rows, isset($value['inci_recived_date']) ? date('d-m-Y', strtotime($value['inci_recived_date'])) : '');
                $sheet->setCellValue('U' . $rows, isset($value['inci_recived_time']) ? $value['inci_recived_time'] : '');
                $sheet->setCellValue('V' . $rows, isset($value['completed_at']) ? date('d-m-Y',strtotime($value['completed_at'])) : '');
                $sheet->setCellValue('W' . $rows, isset($value['completed_at']) ? date('h:i:s',strtotime($value['completed_at'])) : '');
                //$sheet->setCellValue('W' . $rows, date('d-m-Y', strtotime($value['created_at'])));
                $rows++;
            }

            $fileName = "reports.xlsx";
            $writer = new Xlsx($spreadsheet);
            $writer->save(public_path("filereport/" . $fileName));
            $path = url("filereport/" . $fileName);
            return response()->json(array('type' => 'SUCCESS', 'message' => 'Success', 'data' => array('path' => $path)));
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Something Went Wrong', 'data' => []));
        }
    }				
}
