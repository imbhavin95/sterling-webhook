<?php

namespace App\Http\Controllers;

use App\Models\PrefixCode;
use App\Models\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Http;

class RouteController extends Controller
{
    public function index()
    {
        return view('create');
    }

    public function storeWebhook(Request $request)
    {
        try {
            $validateData = Validator::make($request->all(), [
                'title' => ['required'],
                'description' => ['required'],
            ]);
            if ($validateData->fails()) {
                return redirect()->back()->with('errors', $validateData->errors);
            }
            $uniqueId = Str::uuid();
            Webhook::create([
                'unique_id' => $uniqueId,
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $connectionCode = PrefixCode::where('name', 'CONNECTION_CODE')->first();
            $connection = decrypt($connectionCode->code);
            $filePath = storage_path('app/public/compiler/' . $uniqueId . '.php');
            file_put_contents($filePath, $connection);
            chmod($filePath, 0777);
            return redirect()->route('home')->with('success', 'Successfully Added');

        } catch (\Exception $e) {
            Log::info('Message ' . $e->getMessage() . ' Line no ' . $e->getLine() . ' File ' . $e->getFile());
            return redirect()->back()->with('error', 'Something Went Wrong');
        }

    }

    public function addNewUrl($id)
    {
        $data = Webhook::where('id', $id)->first();
        return view('code', compact('data'));
    }

    public function storeCode(Request $request)
    {
        $webhook = Webhook::where('id', $request->webhook_id)->first();
        $uniqueId = $webhook->unique_id;
        $webhook->enc_key = encrypt($request->code);
        $webhook->update();
        $filePath = storage_path('app/public/compiler/' . $uniqueId . '.php');
        $connectionCode = PrefixCode::where('name', 'CONNECTION_CODE')->first();
        $connection = decrypt($connectionCode->code);
        if ($request->editCode == 1) {
            $editData = $connection . $request->code;
            file_put_contents($filePath, $editData);
            chmod($filePath, 0777);
            $second_info = file_get_contents($filePath);
        } else {
            file_put_contents($filePath, $request->code, FILE_APPEND);
            chmod($filePath, 0777);
            $second_info = file_get_contents($filePath);
        }
        return redirect()->route('home');
    }

    public function compiler(Request $request, $id)
    {
//        $data = Webhook::where('unique_id', $id)->first();
//        $file = storage_path("app/public/compiler/".$data->unique_id .'.php');
//        include($file);

        Log::info($request->all());
        return json_encode($request->all());
    }

    public function destroy($id)
    {
        $data = Webhook::where('id',$id)->first();
        $data->delete();
        return response()->json(['success' => true ,'message' => 'Successfully Deleted Webhook']);
    }
}
