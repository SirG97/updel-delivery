<?php

namespace App\Controllers;

use App\Classes\CSRFToken;
use App\Classes\Random;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\Validation;
use App\Classes\Encryption;
use App\Models\District;
use RandomLib;
use SecurityLib;


class PinController extends BaseController{
    public $table_name = 'pins';
    public $pins;
    public $links;
    public function __construct()
    {
        if(!isAuthenticated()){
            Redirect::to('/login');
        }
    }
//    public function __construct(){
//        $total = District::all()->count();
//        $object = new District();
//
//        list($this->pins, $this->links) = paginate(20, $total, $this->table_name, $object);
//    }

    public function index()
    {

        $total = District::all()->count();
        $object = new District();

        list($pins, $links) = paginate(10, $total, $this->table_name, $object);
        $pins = $this->decryptPins($pins);
        return view('user/generated', ['pins' => $pins, 'links' => $links]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function generate_form(){
        return view('user/generate');
    }

    private function decryptPins($pins){
        $encryption = new Encryption();
        foreach ($pins as $pin){
            $pin['pin'] = $encryption->decrypt($pin['pin']);
        }
        return $pins;
    }

    public function generate(){
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $encryption = new Encryption();
                $factory = new RandomLib\Factory;
                $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));

                $amt5H = $request->amt500;
                $qty5H = $request->qty500;

                $amt1k = $request->amt1000;
                $qty1k = $request->qty1000;

                $amt2k = $request->amt2000;
                $qty2k = $request->qty2000;

                $amt3k = $request->amt3000;
                $qty3k = $request->qty3000;

                $amt5k = $request->amt5000;
                $qty5k = $request->qty5000;


                $dataToInsert = array();
                $batchNo = $generator->generateString(8, 'FASTRAK0123456789');
                $lastInserted = $this->getLastInserted();
                var_dump($lastInserted);

                $lastInserted += 1;

                for($i = 0; $i < $qty5H; $i++){
                    $dataToInsert[] = array(
                        'serial' => $this->appendSerialPrefix($lastInserted),
                        'pin' => $encryption->encrypt($generator->generateString(12, '1234567890')),
                        'amount' => $amt5H,
                        'batch_no' => $batchNo

                    );
                    $lastInserted++;
                }
                // for #1000
                for($i = 0; $i < $qty1k; $i++){
                    $dataToInsert[] = array(
                        'serial' => $this->appendSerialPrefix($lastInserted),
                        'pin' => $encryption->encrypt($generator->generateString(12, '1234567890')),
                        'amount' => $amt1k,
                        'batch_no' => $batchNo

                    );
                    $lastInserted++;
                }

                // for #1000
                for($i = 0; $i < $qty2k; $i++){
                    $dataToInsert[] = array(
                        'serial' => $this->appendSerialPrefix($lastInserted),
                        'pin' => $encryption->encrypt($generator->generateString(12, '1234567890')),
                        'amount' => $amt2k,
                        'batch_no' => $batchNo

                    );
                    $lastInserted++;
                }

                // for #1000
                for($i = 0; $i < $qty3k; $i++){
                    $dataToInsert[] = array(
                        'serial' => $this->appendSerialPrefix($lastInserted),
                        'pin' => $encryption->encrypt($generator->generateString(12, '1234567890')),
                        'amount' => $amt3k,
                        'batch_no' => $batchNo

                    );
                    $lastInserted++;
                }

                // for #1000
                for($i = 0; $i < $qty5k; $i++){
                    $dataToInsert[] = array(
                        'serial' => $this->appendSerialPrefix($lastInserted),
                        'pin' => $encryption->encrypt($generator->generateString(12, '1234567890')),
                        'amount' => $amt5k,
                        'batch_no' => $batchNo

                    );
                    $lastInserted++;
                }

                District::insert($dataToInsert);

                Request::refresh();
                Session::add('success', 'Pins generated successfully');

                Redirect::to('/pins');
                exit();
            }
            die('token error');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     */

    public function getLastInserted(){
        $usedPinsCount = District::get()->count();
        if($usedPinsCount > 0){
            $usedPins = District::limit(1)->latest()->orderBy('id', 'desc')->get();
            return $usedPins[0]['id'];
        }else{
            $empty = 0;
            return $empty;
        }

    }

    public function appendSerialPrefix($last){
        if($last < 10){
            return 'FSTK000000000' . $last;
        }elseif($last < 100){
            return 'FSTK00000000' . $last;
        }elseif($last < 1000){
            return 'FSTK0000000' . $last;
        }elseif($last < 10000){
            return 'FSTK000000' . $last;
        }elseif($last < 100000){
            return 'FSTK00000' . $last;
        }elseif($last < 1000000){
            return 'FSTK0000' . $last;
        }elseif($last < 10000000){
            return 'FSTK000' . $last;
        }elseif($last < 100000000){
            return 'FSTK00' . $last;
        }elseif($last < 1000000000){
            return 'FSTK0' . $last;
        }else{
            return 'FSTK' . $last;
        }
    }

    public function store(){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //

    }

    public function setLivePin(Request $request){
        $setFrom = 'generated';
        $setTo = 'live';
        $sql = "update pins set status= $setFrom WHERE status = $setTo";
        $setlive = DB::statement('UPDATE pins SET `status` = "live" WHERE `status` ="generated"');
        return redirect('live')->with('setpin', 'Pins set to LIVE Successfully');
    }

    public function live(){
        $total = District::where('status', 'live')->count();
        $object = new District();
        $filter = ['status' => 'live'];
        list($pins, $links) = paginate(20, $total, $this->table_name, $object, $filter);

        return view('user/generated', ['pins' => $pins, 'links' => $links]);
    }

    public function used(){
        $total = District::where('status', 'used')->count();
        $object = new District();
        $filter = ['status' => 'used'];
        list($pins, $links) = paginate(20, $total, $this->table_name, $object, $filter);

        return view('user/generated', ['pins' => $pins, 'links' => $links]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
}