<?php

namespace App\Http\Controllers;

use App\Models\caoUsuario;
use App\Models\permissaoSistema;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PerformanceComercialController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        $from = '';
        $to = '';
        $selected = '';
        $totalProfit = 0;
        $fixedCost = 0;
        $comision = 0;
        $report = [];
        $subtotal = [];
        $graphic = [];
        $pizza = [];
        $buttonValue = '';

        $consultores = DB::table('cao_usuario')
            ->join("permissao_sistema", "cao_usuario.co_usuario", "=", "permissao_sistema.co_usuario")
            ->select('cao_usuario.co_usuario','cao_usuario.no_usuario')
            ->where('permissao_sistema.co_sistema','=', 1)
            ->where('permissao_sistema.in_ativo','=', 'S')
            ->whereIn('permissao_sistema.co_tipo_usuario', [0,1,2])
            ->orderBy('cao_usuario.no_usuario','asc')
            ->get();

        return view('performanceComercial.performanceComercial', compact('from','to','consultores','selected','totalProfit','fixedCost','comision','report','subtotal','graphic','pizza','buttonValue'));
    }

    public function report(Request $request){
        $from = $request->input('from');
        $to = $request->input('to');
        $buttonValue = $request->input('buttonValue');

        $totalProfit = 0;
        $fixedCost = 0;
        $comision = 0;
        $graphic = [];
        $pizza = [];


        $from1 = '01-'.$request->input('from');
        $to1 = '01-'.$request->input('to');
        $selected = $request->input('selected');

        $from1 = Carbon::parse($from1)->format('Y-m-d');
        $to1 = Carbon::parse($to1)->format('Y-m-t');

        $consultores = DB::table('cao_usuario')
            ->join("permissao_sistema", "cao_usuario.co_usuario", "=", "permissao_sistema.co_usuario")
            ->select('cao_usuario.co_usuario','cao_usuario.no_usuario')
            ->where('permissao_sistema.co_sistema','=', 1)
            ->where('permissao_sistema.in_ativo','=', 'S')
            ->whereIn('permissao_sistema.co_tipo_usuario', [0,1,2])
            ->orderBy('cao_usuario.no_usuario','asc')
            ->get();
      
        $sql = "set lc_time_names = 'es_ES';";
        DB::unprepared($sql);

        $report = DB::table('cao_fatura')
            ->join('cao_cliente','cao_fatura.co_cliente','=','cao_cliente.co_cliente')
            ->join('cao_sistema','cao_fatura.co_cliente','=','cao_sistema.co_cliente')
            ->join('cao_os','cao_os.co_sistema','=','cao_sistema.co_sistema')
            ->join('cao_usuario','cao_os.co_usuario','=','cao_usuario.co_usuario')
            ->leftjoin('cao_salario','cao_salario.co_usuario','=','cao_usuario.co_usuario')
            ->where('cao_fatura.data_emissao','>=', $from1)
            ->where('cao_fatura.data_emissao','<=', $to1)
            ->selectRaw('cao_usuario.no_usuario, cao_usuario.co_usuario, min(cao_salario.brut_salario) as brut_salario, sum(cao_fatura.valor - cao_fatura.valor * cao_fatura.total_imp_inc/100) as ganancia, concat(year(cao_fatura.data_emissao),if (month(cao_fatura.data_emissao) < 10, concat(0,month(cao_fatura.data_emissao)) , month(data_emissao) )) as periodo, min(DATE_FORMAT(data_emissao,"%M %Y")) as periodo_desc, sum((cao_fatura.valor - (cao_fatura.valor *cao_fatura.total_imp_inc/100)) * cao_fatura.comissao_cn/100) as comision')
            ->whereIn('cao_usuario.co_usuario', explode (',' , $selected))
            ->groupBy('cao_usuario.no_usuario','cao_usuario.co_usuario','periodo')
            ->get();

        $subtotal = array();
        foreach ($report as $item) {
            $key = $item->co_usuario;
            if (!array_key_exists($key, $subtotal)) {
                $subtotal[$key] = array(
                    'co_usuario' => $item->co_usuario,
                    'no_usuario' => $item->no_usuario,
                    'brut_salario' => $item->brut_salario,
                    'ganancia' => $item->ganancia,
                    'periodo' => $item->periodo,
                    'comision' => $item->comision,
                    'beneficio' => $item->ganancia - ($item->brut_salario + $item->comision),
                );
            } else {
                $subtotal[$key]['brut_salario'] = $subtotal[$key]['brut_salario'] + $item->brut_salario;
                $subtotal[$key]['ganancia'] = $subtotal[$key]['ganancia'] + $item->ganancia;
                $subtotal[$key]['comision'] = $subtotal[$key]['comision'] + $item->comision;
                $subtotal[$key]['beneficio'] = $subtotal[$key]['beneficio'] + ($item->ganancia - ($item->brut_salario + $item->comision));
            }
        }

        foreach ($report as $rep){
            $totalProfit += $rep->ganancia;
            $fixedCost += $rep->brut_salario;
            $comision += $rep->comision;
        }

        return view('performanceComercial.performanceComercial', compact('from','to','consultores','selected','report','totalProfit','fixedCost','comision','subtotal','graphic','pizza','buttonValue'));

    }

    public function graphic(Request $request){
        $from = $request->input('from');
        $to = $request->input('to');

        $totalProfit = 0;

        $from1 = '01-'.$request->input('from');
        $to1 = '01-'.$request->input('to');
        $selected = $request->input('selected');
        $subtotal = [];
        $report = [];
        $fixedCost = 0;
        $comision = 0;

        $from1 = Carbon::parse($from1)->format('Y-m-d');
        $to1 = Carbon::parse($to1)->format('Y-m-t');

        $consultores = DB::table('cao_usuario')
            ->join("permissao_sistema", "cao_usuario.co_usuario", "=", "permissao_sistema.co_usuario")
            ->select('cao_usuario.co_usuario','cao_usuario.no_usuario')
            ->where('permissao_sistema.co_sistema','=', 1)
            ->where('permissao_sistema.in_ativo','=', 'S')
            ->whereIn('permissao_sistema.co_tipo_usuario', [0,1,2])
            ->orderBy('cao_usuario.no_usuario','asc')
            ->get();
           
        $sql = "set lc_time_names = 'es_ES';";
        DB::unprepared($sql);

        $graphic = DB::table('cao_fatura')
            ->join('cao_cliente','cao_fatura.co_cliente','=','cao_cliente.co_cliente')
            ->join('cao_sistema','cao_fatura.co_cliente','=','cao_sistema.co_cliente')
            ->join('cao_os','cao_os.co_sistema','=','cao_sistema.co_sistema')
            ->join('cao_usuario','cao_os.co_usuario','=','cao_usuario.co_usuario')
            ->leftjoin('cao_salario','cao_salario.co_usuario','=','cao_usuario.co_usuario')
            ->where('cao_fatura.data_emissao','>=', $from1)
            ->where('cao_fatura.data_emissao','<=', $to1)
            ->selectRaw('cao_usuario.no_usuario, cao_usuario.co_usuario, min(cao_salario.brut_salario) as brut_salario, sum(cao_fatura.valor - cao_fatura.valor * cao_fatura.total_imp_inc/100) as ganancia, concat(year(cao_fatura.data_emissao),if (month(cao_fatura.data_emissao) < 10, concat(0,month(cao_fatura.data_emissao)) , month(data_emissao) )) as periodo, min(DATE_FORMAT(data_emissao,"%b %Y")) as periodo_desc')
            ->whereIn('cao_usuario.co_usuario', explode (',' , $selected))
            ->groupBy('cao_usuario.no_usuario','cao_usuario.co_usuario','periodo')
            ->get();

        $data = array();
        $i = -1;

        $legend = array();
        $period = array();
        $show_graphic = array();
       
        $series = array();
        $values = array();
        $val = array();
        $brut_salario = 0;
        $brut_salario1 = array();

        foreach ($graphic as $item) {
            if (!in_array($item->no_usuario, $legend)) {
                array_push($legend, $item->no_usuario);
                $brut_salario += $item->brut_salario;
               
                array_push($series,  array(
                    'name' => $item->no_usuario,
                    'type' => 'bar',
                    'data' => array(),
                ));
            }
            if (!in_array($item->periodo_desc, $period)) {
                array_push($period, $item->periodo_desc);
            }
        }
        if (count($graphic)){
            array_push($legend, 'Costo Fijo Promedio');
            $brut_salario1 = array_fill(0, count($period), $brut_salario/count($legend));
        }

        $user = '';

        foreach ($series as &$serie) {
            $serie['data'] = array_fill(0, count($period), 0);
            $graphic_user = $graphic->where('no_usuario', $serie['name']);

            foreach ($graphic_user as $user) {
                $index = array_search($user->periodo_desc, $period);
                $serie['data'][$index] = $user->ganancia;
            }
        }

        array_push($series,  array(
            'name' => 'Costo Fijo Promedio',
            'type' => 'line',
            'data' => $brut_salario1,
        ));

        array_push($show_graphic, $legend, $period, $series);

        return $show_graphic;
    }

    public function pizza(Request $request){
        $selected = $request->input('selected');
        $legend = array();
        $show_pizza = array();
        $data = array();

        $pizza = DB::table('cao_fatura')
            ->join('cao_cliente','cao_fatura.co_cliente','=','cao_cliente.co_cliente')
            ->join('cao_sistema','cao_fatura.co_cliente','=','cao_sistema.co_cliente')
            ->join('cao_os','cao_os.co_sistema','=','cao_sistema.co_sistema')
            ->join('cao_usuario','cao_os.co_usuario','=','cao_usuario.co_usuario')
            ->selectRaw('cao_usuario.no_usuario, sum(cao_fatura.valor - cao_fatura.valor * cao_fatura.total_imp_inc/100) as ganancia')
            ->whereIn('cao_usuario.co_usuario', explode (',' , $selected))
            ->groupBy('cao_usuario.no_usuario')
            ->get();

        foreach ($pizza as $item) {
            if (!in_array($item->no_usuario, $legend)) {
                array_push($legend, $item->no_usuario);
               
                array_push($data,  array(
                    'name' => $item->no_usuario,
                    'value' => $item->ganancia
                ));
            }
        }

        array_push($show_pizza, $legend, $data);

        return $show_pizza;
    }
}
