<?php namespace App\Http\Controllers;

use App\ActionEvent;
use App\Models\Printer;
use App\Modules\DocumentExcel;
use App\Modules\ExportCSV;
use App\Modules\PrintLogger;
use App\Modules\RandomString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_DataPrinter extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('gets', 'add', 'edit', 'remove', 'find', 'exportXLS');
    }

    public function gets(int $page) {
        $limit = 10;
        $count = Printer::all()->count();

        $offset = ($page * $limit) - $limit;
        $pagination = ceil( $count / $limit);

        $printers = Printer::offset($offset)->limit($limit)->orderBy('id', 'DESC')->get();

        return response()->json([
            'printers'   => $printers,
            'pagination' => $pagination
        ]);
    }

    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'product'   => 'required',
            'model'   => 'required',
            'serial' => 'required',
            'inventory' => 'required|unique:printers'
        ], [
            'product.required'  => 'Производитель не указан',
            'model.required'    => 'Модель не указана',
            'serial.required'   => 'Серийный номер не указан',
            'inventory.unique'  => 'Инвентарь уже существует'
        ]);

        if ($validator->fails()) {
            return response()->json(['result'=>false, 'message' => $validator->errors()->all()]);
        }

        $product   = trim($request->input('product'));
        $model     = trim($request->input('model'));
        $serial    = trim($request->input('serial'));
        $mac       = trim($request->input('mac'));
        $inventory = trim($request->input('inventory'));
        $cartridge = trim($request->input('cartridge'));
        $location  = trim($request->input('location'));
        $cabinet   = trim($request->input('cabinet'));
        $username  = trim($request->input('username'));

        $printer = new Printer();
        $printer->product = $product;
        $printer->model   = $model;
        $printer->serial  = $serial;
        $printer->mac = $mac;
        $printer->inventory = $inventory;
        $printer->cartridge = $cartridge;
        $printer->location = $location;
        $printer->cabinet  = $cabinet;
        $printer->username = $username;
        $result = $printer->save();

        $clientIp = $_SERVER['REMOTE_ADDR'];

        $data = sprintf('Устройство: (%s - %s), инвентарный: %s, s/n: %s', $printer->product, $printer->model, $printer->inventory, $printer->serial);

        $action = ActionEvent::where('event', '=', 'add')->first();

        PrintLogger::commit($clientIp, $action->id, $data, $request->user()->id);

        return response()->json([
            'result'  => $result,
            'printer' => $printer
        ], 200);
    }

    public function edit(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'product'   => 'required',
            'model'   => 'required',
            'serial' => 'required',
        ], [
            'product.required'  => 'Производитель не указан',
            'model.required'    => 'Модель не указана',
            'serial.required'   => 'Серийный номер не указан',
        ]);

        if ($validator->fails()) {
            return response()->json(['result'=>false, 'message' => $validator->errors()->all()]);
        }

        $printer = Printer::find($id);

        $printer->product   = trim($request->input('product'));
        $printer->model     = trim($request->input('model'));
        $printer->serial    = trim($request->input('serial'));
        $printer->mac       = trim($request->input('mac'));
        $printer->inventory = trim($request->input('inventory'));
        $printer->cartridge = trim($request->input('cartridge'));
        $printer->location  = trim($request->input('location'));
        $printer->cabinet   = trim($request->input('cabinet'));
        $printer->username  = trim($request->input('username'));

        $result = $printer->save();

        $clientIp = $_SERVER['REMOTE_ADDR'];

        $action = ActionEvent::where('event', '=', 'edit')->first();

        $data = sprintf('Устройство: (%s - %s), !!!! инвентарный: %s, s/n: %s', $printer->product, $printer->model, $printer->inventory, $printer->serial);
        PrintLogger::commit($clientIp, $action->id, $data, $request->user()->id);

        return response()->json([
           'result' => $result,
           'printer' => $printer
        ]);
    }

    public function remove(Request $request, $id) {
        $printer = Printer::find($id);

        if (empty($printer))
            return response()->json(['result'=>false]);
        else {
            $result = $printer->delete();

            $clientIp = $_SERVER['REMOTE_ADDR'];

            $action = ActionEvent::where('event', '=', 'remove')->first();

            $data = sprintf('Устройство: (%s - %s), инвентарный: %s, s/n: %s', $printer->product, $printer->model, $printer->inventory, $printer->serial);
            PrintLogger::commit($clientIp, $action->id, $data, $request->user()->id);

            return response()->json(['result'=>$result], 200);
        }
    }

    public function find(string $text, string $column = 'model') {
        $printers = Printer::where($column, 'LIKE', '%'.trim($text).'%')->get();
        return response()->json([
            'printers'=>$printers
        ], 200);
    }

    public function exportXLS() {
        $printers = Printer::all();

        $filename = ExportCSV::DIRECTORY.RandomString::generate().'.xls';

        $doc = DocumentExcel::Init();
        $doc->setActiveSheet(0)->setTitle('Экспорт');
        $doc->writeTextCell('A1', 'Учет принтеров')->mergeCells('A1:J1')
            ->alignCell('center')->setBorder()->setFontSize(17);

        $doc->writeTextCell('A2','ID')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('B2','Производитель')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('C2','Модель')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('D2','Серийный номер')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('E2','Мак адрес')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('F2','Инвентарный номер')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('G2','Картридж')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('H2','Расположение')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('I2','Кабинет')->setFontSize(15)->alignCell('center');
        $doc->writeTextCell('J2','Пользователь')->setFontSize(15)->alignCell('center');
        $doc->setBorder('thin','A2:J2');
        $i = 3;
        foreach ($printers as $printer) {
            $doc->writeTextCell('A' . $i, $printer->id);
            $doc->writeTextCell('B' . $i, $printer->product);
            $doc->writeTextCell('C' . $i, $printer->model);
            $doc->writeTextCell('D' . $i, $printer->serial);
            $doc->writeTextCell('E' . $i, $printer->mac);
            $doc->writeTextCell('F' . $i, $printer->inventory);
            $doc->writeTextCell('G' . $i, $printer->cartridge);
            $doc->writeTextCell('H' . $i, $printer->location);
            $doc->writeTextCell('I' . $i, $printer->cabinet);
            $doc->writeTextCell('J' . $i, $printer->username);
            $i++;
        }

        $doc->setAutoSize(['A','B','C','D','E','F','G','H','I','J']);

        if (is_dir(ExportCSV::DIRECTORY)) {
            $doc->save($filename);

            return response()->json([
                'filename' => asset($filename)
            ]);
        } else {
         return response()->json([
             'error' => 'Директория не найдена'
         ]);
        }
    }
}
