<?php

namespace Modules\HistoryBackup\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminIncidents\Entities\IncidentUpdate;

class HistoryBackupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('historybackup::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('historybackup::modal.add');
    }

    public function tableData(Request $request)
    {
        $input = $request->all();
        $header = [
            'TC User Name',
            'Incident Number',
            'Agent Code',
            'Agent Name',
            'card Number',
            'Passport Number',
            'Transaction Type',
            'status',
            'Departure Date',
            'Comment',
            'Cashier',
            'Doc Upload Date',
            'Doc Upload Time',
            'Completed Date',
            'Completed Time'
        ];

        $export = implode(",", $header) . "\n";

        if ($input['created_at'] != '') {
            $query = IncidentUpdate::with([
                'incident.incidentCurrency',
                'incident.buyDocuments',
                'incident.sellDocuments',
                'incident.incidentAssign' => function ($query) {
                    $query->select('id', 'name', 'user_code', 'email');
                }, 'incident.agent' => function ($query) {
                    $query->select('id', 'agent_key', 'user_name', 'email', 'first_name', 'last_name');
                }
            ])->orderBy('id', 'DESC');

            $created_at = date('Y-m-d', strtotime($input['created_at']));
            $query->where(function ($query) use ($created_at) {
                if ($created_at != '')
                    $query->where('inci_up_date', '=', $created_at);
            });

            $result[] = $query->get()->toArray();

            if ($query->count() > 0) {
                $data = array();
                foreach ($result[0] as  $key =>  $res) {
                    if ($res['incident']['transaction_type'] == 0) {
                        $transaction_type = 'Reload';
                    } else if ($res['incident']['transaction_type'] == '1') {
                        $transaction_type = 'Activation';
                    } else if ($res['incident']['transaction_type'] == '2') {
                        $transaction_type = 'Refund';
                    } else
                        $transaction_type = '';

                    if ($res['inci_up_accept_status'] == 0) {
                        $accept_status = 'Under Process';
                    } else if ($res['inci_up_accept_status'] == 1) {
                        $accept_status = 'Accepted';
                    } else if ($res['inci_up_accept_status'] == 2) {
                        $accept_status = 'Rejected';
                    } else {
                        $accept_status = '';
                    }
                    $data[$key]['tc_user_name'] = $res['incident']['incident_assign']['name'];
                    $data[$key]['incident_number'] = $res['inci_up_key'];
                    $data[$key]['agent_key'] = $res['incident']['agent']['agent_key'];
                    $data[$key]['first_name'] = $res['incident']['agent']['first_name'] . ' ' . $res['incident']['agent']['last_name'];
                    $data[$key]['card_number'] = $res['incident']['inci_forex_card_no'];
                    $data[$key]['passport_number'] = $res['incident']['inci_passport_number'];
                    $data[$key]['transaction_type'] = $transaction_type;
                    $data[$key]['accept_status'] = $accept_status;
                    $data[$key]['departure_date'] = $res['incident']['inci_departure_date'];
                    $data[$key]['comment'] = $res['inci_up_comment'];
                    $data[$key]['cashier'] = 'Admin';
                    $data[$key]['doc_upload_date'] = $res['inci_up_date'];
                    $data[$key]['doc_upload_time'] = $res['inci_up_time'];
                    $data[$key]['completed_date'] = $res['inci_up_received_date'];
                    $data[$key]['completed_time'] = $res['inci_up_received_time'];
                }

                foreach ($data as $key => $val) {
                    $export .= implode(",", $val) . "\n";
                }
                $subject = "Report Backup History";
                $current_date = date('His', time());
                $filename = 'Report-backup-history-' . $request->created_at . '-' . $current_date . '.csv';

                $filePath   = public_path('report-backup-file/' . $filename);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $fp = fopen($filePath, 'w+');
                fwrite($fp, $export);
                fclose($fp);

                $data = [
                    'backup_date' => $request->created_at,
                    'mail_data' => $result,
                    'subject' => $subject,
                    'file' => $filePath,
                ];

                Mail::send('email.report', $data, function ($message) use ($data) {
                    $message->from('vetron.marketing@gmail.com', 'Thomas Cook');
                    $message->to('nishant@dataseedtech.com');
                    $message->subject($data['subject']);
                    $message->attach($data['file']);
                });
                return response()->json(array('type' => 'SUCCESS', 'message' => 'Success, please check email.', 'data' => $result));
            } else {
                return response()->json(array('type' => 'ERROR', 'message' => 'Record Not Available.'));
            }
        } else {
            return response()->json(array('type' => 'ERROR', 'message' => 'Please Select Date.'));
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('historybackup::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('historybackup::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
