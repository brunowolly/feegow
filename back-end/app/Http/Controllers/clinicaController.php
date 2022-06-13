<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Infrastructure\Gateway\Feegow;
use App\Models\Appointment;
use Carbon\Carbon;

class clinicaController extends Controller
{
    private $feegow = null;

    public function __construct()
    {
        $this->feegow = new Feegow();
    }

    public function index()
    {
        try{
            return $this->feegow->callFeegow('specialties/list');

        } catch (\Exception $e) {
            return [];
        }

    }

    public function store(Request $request)
    {

         $input = $request->all();
         $appointment = new Appointment();
         $appointment->fill($input);
         $appointment->birthdate = Carbon::createFromFormat('d/m/Y', $appointment->birthdate);
         $appointment->date_time = date("Y-m-d H:i:s");


         try {
             $appointment->save();
             return response()->json([
                'message' => 'Agendamento feito com sucesso!'], 200);

         } catch (\Exception $e) {
            http_response_code(400);
            return response()->json([
                'message' => 'Não foi possível realizar agendamento! ' .  $e], 400);
         }

    }

    public function getById($id = 0)
    {
        try {
            return $this->feegow->callFeegow('professional/list?especialidade_id='.$id);
        } catch (\Exception $e) {
            return [];
        }

    }

    public function listAppointments()
    {
        try{
            $appointments = Appointment::get();
            $data['content']=$appointments;
            $data['success']=true;

            return response()->json($data,200);

        } catch (\Exception $e) {
            return response()->json(["success"=>false],400);
        }

    }

    public function getProfissionais($id)
    {
        try {
            $data = $this->GetApiData('professional/list?especialidade_id='.$id);
            return response()->json($data);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getHowDidYouMeetUs()
    {
       return $this->feegow->callFeegow('patient/list-sources');

    }



}
