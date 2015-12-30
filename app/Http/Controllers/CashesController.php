<?php

namespace Salesfly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Salesfly\Salesfly\Repositories\CashRepo;
use Salesfly\Salesfly\Managers\CashManager;
use Salesfly\User;
use Salesfly\Salesfly\Entities\Cash;
use Salesfly\Salesfly\Entities\CashHeader;

class CashesController extends Controller
{
    protected $cashRepo;

    public function __construct(CashRepo $cashRepo)
    {
        $this->cashRepo = $cashRepo;
    }

    public function all()
    {
        $cashes = $this->cashRepo->paginate(15);
        return response()->json($cashes);
        //var_dump($materials);
    }

    public function paginatep(){
        $cashes = $this->cashRepo->paginate(15);
        return response()->json($cashes);
    }

    public function find($id)
    {
        $cash = $this->cashRepo->find($id);

        $cash->montoBruto = $this->cashRepo->calculateMontoBruto($id);
        return response()->json($cash);
    }

    public function search($q)
    {
        $cashes = $this->cashRepo->search($q);

        return response()->json($cashes);
    }

    public function index()
    {
        return View('cashes.index');
    }

    public function form_create()
    {
        return View('cashes.form_create');
    }
    public function form_edit()
    {
        return View('cashes.form_edit');
    }
    public function create(Request $request)
    {
        $cash = $this->cashRepo->getModel();

        $request->merge(['user_id' => \Auth::user()->id ]);

        //var_dump($request->all());

        $manager = new CashManager($cash,$request->all());
        $manager->save();

        return response()->json(['estado'=>true, 'nombre'=>$cash->fechaInicio]);
    }
    public function edit(Request $request)
    {
        //var_dump($request->all()); die();
        $cash = $this->cashRepo->find($request->id);

        $cantidadTickets = \DB::table('ticket') //no se utiliza
                            ->join('detCash','ticket.detCash_id','=','detCash.id')
                            ->where('cash_id',$request->id)
                            ->count('ticket.id');

        //var_dump($cantidadTickets);

        $cantidadPersonas = \DB::table('ticket') //cantidad de personas sin contar los botes
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$request->id)
            ->where('concepto_id','!=',2)
            ->sum('ticket.cantidad');

        //var_dump($cantidadPersonas); die();

        $montoMovimientoEfectivo = \DB::table('detCash')
            ->where('cash_id',$request->id)
            ->sum('montoMovimientoEfectivo');

        $montoTickets = \DB::table('ticket')
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$request->id)
            ->where('ticket.estado',1)
            ->sum('ticket.montoFinal');

        $montoBruto = $montoTickets + $cash->montoInicial; //aqui sumo los ingresos y egresos

        //var_dump($cantidadPersonas);
        //var_dump($montoTickets);
        //die();

        $table = \DB::select(\DB::raw('SELECT sum(ticket.cantidad) AS cantidad,concepto.nombre AS nombre,sum(ticket.montoFinal) AS total  FROM ticket INNER JOIN detCash ON ticket.detCash_id = detCash.id
											INNER JOIN cashes ON detCash.cash_id = cashes.id
											INNER JOIN concepto ON concepto.id = ticket.concepto_id

WHERE cashes.id = 3
GROUP BY ticket.concepto_id'));

        /*foreach($table as $row)
        {
            var_dump($row->cantidad);
        }

        var_dump($table); die();*/



        if($montoBruto == $request->montoBruto){
            $manager = new CashManager($cash,$request->all());
            $manager->save();
            return response()->json(['estado'=>true, 'nombre'=>$cash->nombre]);
        }else{
            return response()->json(['estado'=>false, 'msje'=>'Monto Bruto no coincide con el calculado en este instante.']);
        }

    }

    public function printCash($cash_id){

        $oCash = $this->cashRepo->find($cash_id);

        //$oCash = Cash::find($cash_id);

        $cantidadTickets = \DB::table('ticket') //no se utiliza
        ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->count('ticket.id');

        $cantidadPersonas = \DB::table('ticket') //cantidad de personas sin contar los botes
        ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->where('concepto_id','!=',2)
            ->where('ticket.estado',1)
            ->sum('ticket.cantidad');

        $montoTickets = \DB::table('ticket')
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->where('ticket.estado',1)
            ->sum('ticket.montoFinal');

        $cantidadTicketsAnulados = \DB::table('ticket') //
        ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->where('ticket.estado',0)
            ->count('ticket.id');

        $montoTicketsAnulados = \DB::table('ticket')
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->where('ticket.estado',0)
            ->sum('ticket.montoFinal');

        //var_dump($cantidadPersonas); die();

        $table = \DB::select(\DB::raw('SELECT sum(ticket.cantidad) AS cantidad,concepto.nombre AS nombre,sum(ticket.montoFinal) AS total  FROM ticket INNER JOIN detCash ON ticket.detCash_id = detCash.id
											INNER JOIN cashes ON detCash.cash_id = cashes.id
											INNER JOIN concepto ON concepto.id = ticket.concepto_id

                                            WHERE cashes.id = '.$cash_id.'
                                            AND ticket.estado = 1
                                            GROUP BY ticket.concepto_id'));

        $ticketIni = \DB::table('ticket')
                    ->join('detCash','ticket.detCash_id','=','detCash.id')
                    ->where('cash_id',$cash_id)
                    ->OrderBy('ticket.id', 'asc')->first();

        $ticketLast = \DB::table('ticket')
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->OrderBy('ticket.id', 'desc')->first();

        $userName = User::find($oCash->user_id)->name;

        //var_dump($oUser); die();

        //var_dump($ticketLast); die();

        $output = $this->generateResumePaper($oCash,$cantidadTickets,$cantidadPersonas,$table,$montoTickets,$ticketIni,$ticketLast,$userName,$cantidadTicketsAnulados,$montoTicketsAnulados);
        if($output == true){
            //\DB::commit();
            return response()->json(['estado'=>true]);
        }else{
            return response()->json(['estado'=>false]);
        }
        //de xx1--xx2
        //
        //var_dump($openCash->cashHeader->msje); die();
        //return response()->json(['estado'=>true, 'nombre'=>$oCash->nombre]);
    }

    public function consultarCajero()
    {
        $id = \Auth::user()->id;
        $openCash = Cash::where('estado', 1)->where('user_id', $id)->first();
        if (count($openCash)) {

            $cashHeader = CashHeader::join('cashes', 'cashes.cashHeader_id', '=', 'cashHeaders.id')
                ->join('users', 'users.id', '=', 'cashes.user_id')
                ->where('cashes.id', $openCash->id)
                ->first();

            $openCash->data = $cashHeader;
        }
                        //->select('')
                    ///->join('detCash','cashes.id','=','detCash.cash_id');


        return response()->json($openCash);
    }

    public function resumenCaja($cash_id){

        $oCash = $this->cashRepo->find($cash_id);

        //$oCash = Cash::find($cash_id);

        $cantidadTickets = \DB::table('ticket') //
        ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->count('ticket.id');

        $cantidadPersonas = \DB::table('ticket') //cantidad de personas sin contar los botes
        ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->where('concepto_id','!=',2)
            ->where('ticket.estado',1)
            ->sum('ticket.cantidad');

        $montoTickets = \DB::table('ticket')
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->where('ticket.estado',1)
            ->sum('ticket.montoFinal');

        $cantidadTicketsAnulados = \DB::table('ticket') //
                                    ->join('detCash','ticket.detCash_id','=','detCash.id')
                                    ->where('cash_id',$cash_id)
                                    ->where('ticket.estado',0)
                                    ->count('ticket.id');

        $montoTicketsAnulados = \DB::table('ticket')
                                    ->join('detCash','ticket.detCash_id','=','detCash.id')
                                    ->where('cash_id',$cash_id)
                                    ->where('ticket.estado',0)
                                    ->sum('ticket.montoFinal');

        //var_dump($cantidadPersonas); die();

        $table = \DB::select(\DB::raw('SELECT sum(ticket.cantidad) AS cantidad,concepto.nombre AS nombre,sum(ticket.montoFinal) AS total  FROM ticket INNER JOIN detCash ON ticket.detCash_id = detCash.id
											INNER JOIN cashes ON detCash.cash_id = cashes.id
											INNER JOIN concepto ON concepto.id = ticket.concepto_id

                                            WHERE cashes.id = '.$cash_id.'
                                            AND ticket.estado = 1
                                            GROUP BY ticket.concepto_id'));

        $ticketIni = \DB::table('ticket')
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->OrderBy('ticket.id', 'asc')->first();

        $ticketLast = \DB::table('ticket')
            ->join('detCash','ticket.detCash_id','=','detCash.id')
            ->where('cash_id',$cash_id)
            ->OrderBy('ticket.id', 'desc')->first();

        $userName = User::find($oCash->user_id)->name;

        //var_dump($oUser); die();

        //var_dump($ticketLast); die();

        //$this->generateResumePaper($oCash,$cantidadTickets,$cantidadPersonas,$table,$montoTickets,$ticketIni,$ticketLast,$userName,,,);
        //de xx1--xx2
        $resumen = array('caja' => $oCash,
                            //'cajaFin' => $oCash->fechaFin,
                            'cantidadTickets' => $cantidadTickets,
                            'cantidadPersonas' => $cantidadPersonas,
                            'table' => $table,
                            'montoTickets' => $montoTickets,
                            'ticketIni' => $ticketIni,
                            'ticketLast' => $ticketLast,
                            'userName' => $userName,
                            'cantidadTicketsAnulados' => $cantidadTicketsAnulados,
                            'montoTicketsAnulados' => $montoTicketsAnulados
                        );
        //
        //var_dump($openCash->cashHeader->msje); die();
        return response()->json(['estado'=>true, 'data' => $resumen]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function generateResumePaper($oCash,$cantidadTickets,$cantidadPersonas,$table,$montoTickets,$ticketIni,$ticketLast,$userName,$cantidadTicketsAnulados,$montoTicketsAnulados){
        $txt = '<?php require_once(dirname(__FILE__) . "/escpos-php-master/Escpos.php");
							//$logo = new EscposImage("images/productos/tostao.jpg");
							$printer = new Escpos();
							/* Print top logo */
                            $printer -> setJustification(Escpos::JUSTIFY_CENTER);
                            //$printer -> graphics($logo);
							$printer -> selectPrintMode(Escpos::MODE_DOUBLE_WIDTH);';
        if($oCash->estado == 0)
        {
                    $txt .= '$printer -> text("RESUMEN FINAL\nDE CAJA");'; }elseif($oCash->estado == 1)
        {
            $txt .= '$printer -> text("RESUMEN PARCIAL\nDE CAJA");';
        }

        $txt .= '$printer -> feed();
							$printer -> selectPrintMode();
							$printer -> setJustification(Escpos::JUSTIFY_LEFT);
							$printer -> feed();
							$printer -> text("Cajero: '.$userName.'\n");
							$printer -> feed();
							$printer -> text("Caja: '.$oCash->cashHeader->nombre.'  ");
							$printer -> text("# Ref. Caja: '.$oCash->id.'\n");
							$printer -> feed();
							$printer -> text("Fec.Inic/Fec.Fin: '.$oCash->fechaInicio.' - '.$oCash->fechaFin.' \n");
							$printer -> feed();
							$printer -> text("Tick.Inic/Tick.Fin: '.$ticketIni->id.' - '.$ticketLast->id.' \n");
							$printer -> text("# Tickets (Totales): '.$cantidadTickets.'");
							$printer -> feed();
							$printer -> text("# Tickets Anul.: '.$cantidadTicketsAnulados.'");
							$printer -> feed();
							$printer -> text("Monto Tickets Anul.: S/.'.$montoTicketsAnulados.'");
							$printer -> feed();
							$printer -> text("# Personas: '.number_format($cantidadPersonas,0).'.(No se cont. Paseo bote)\n");
							$printer -> text("------------------------------------------\n");
							$printer -> setEmphasis(true);
							$printer -> text("Cant.     Concepto                 Total\n");
                            $printer -> setEmphasis(false);';

                    foreach($table as $row){
                        $txt .= '$printer -> text(" '.number_format($row->cantidad,0).'   '.str_pad(substr($row->nombre,0,22),22,' ').'    S/.'.$row->total.' \n");';
                    }

        $txt .= '$printer -> text("------------------------------------------\n");';
        $txt .= '$printer -> setEmphasis(true);';
        $txt .= '$printer -> text("Monto Total Tickets S/. '.$montoTickets.'\n");';
        $txt .= '$printer -> setEmphasis(false);';
        $txt .= '$printer -> feed();';
        $txt .= '$printer -> text("Fecha de Impr.: '.date("d-m-Y").' '.date("H:i:s").'\n");';
        $txt .= '$printer -> text("**No válido como documento contable**\n");';
        $txt .= '$printer -> feed();';
        $txt .= '$printer -> cut();';
        $txt .= '$printer -> close();';

        $myfile = fopen("../resources/ticket.php", "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
        //$cmd = 'php '.base_path("/resources/").'ticket.php  > '.base_path("resources/").'ticket.txt';
        //$cmd = 'lpr -P Photosmart-Plus-B209a-m /var/www/html/4Rest/public/newfile.php';
        //shell_exec($cmd);//exec('sudo -u myuser ls /');

        $cmdInic = 'netcat -z '.$oCash->cashHeader->printerName.' 9100 && echo "ok" || echo "failed"';

        $output = shell_exec($cmdInic);


        if($output=="ok\n"){
            //print_r('OKKKTRUE'); die();
            $cmd = 'php '.base_path("/resources/").'ticket.php | nc '.$oCash->cashHeader->printerName.' 9100';
            shell_exec($cmd);
            return true;
        }else{
            //print_r('OKKKFALSE'); die();
            return false;
        }

        //$cmd2 = 'lpr -P '.$oCash->cashHeader->printerName.' -o raw '.base_path("resources/").'ticket.txt';
        //shell_exec($cmd2);

        //return response()->json('true');
    }


}
