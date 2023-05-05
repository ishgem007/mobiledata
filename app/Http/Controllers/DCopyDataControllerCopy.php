<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * https://github.com/kobotoolbox/kobocat/blame/b5b507d7e543e69a1d3a3b190407fecf42a1efa7/onadata/apps/api/viewsets/data_viewset.py#L185
         * 
         * 'https://kc.kobotoolbox.org/api/v1/data/214918?query={ "group_Location/Q7_Auditor_Name_Field_Worker_l": "Blessing"}'
         * https://kc.kobotoolbox.org/api/v1/data/214918?query={"_submission_time": {"$gt": "2019-07-28"}}
         */
//       $token = "d778dcd59c45b3350bc4e392a9bf989e97c0f55";
//       $credentials = base64_encode('ishgem007:ChangeIt333');


        $client = new Client();
       $response = $client->get('https://kc.kobotoolbox.org/api/v1/data/214918?query={"_submission_time": {"$gt": "2019-07-28"}}',
           [
                'auth' => [
                    'ishgem007',
                    'ChangeIt333'
                ],
                'token'=>[
                    'ed778dcd59c45b3350bc4e392a9bf989e97c0f55'
                ]
           ]);

      
        $data = $response->getBody();
      
         
        $data=  json_decode($data, true);

        $items =[];
        foreach ($data as $item) {
            $items[] = $item["group_smart_and_mobile"];
        }
        $collection = collect($items);
        $collapsed = $collection->collapse();

        $collections = $collapsed->all();
        // return $collections;

        $newArray = [];
        foreach ($collections as $collection) {
            $arr = [];
            foreach ($collection as $key => $value) {
                if (strpos($key, 'Unit_Price') !== false) {
                    $newKey = "G_Unit price";
                    $arr[$newKey] = $value;
                } else if(strpos($key, 'Sales_Units') !== false) {
                    $newKey = "F_Sales units";
                    $arr[$newKey] = $value;
                } else if(strpos($key, 'Brands') !== false) {
                    $newKey = "A_Brands";
                    if ( strtolower($value) != "others") {
                        $arr[$newKey] = $value;
                    }
                } else if (strpos($key, 'Enter_Brand_Name') !== false) {
                    $newKey = "B_Brand Name";
                    $arr['A_Brands'] = $value;
                } else if (strpos($key, 'Select_A') !== false) {
                    $newKey = "C_Model";
                    if ( strtolower($value) != "others") {
                        $arr[$newKey] = $value;
                    }
                } else if (strpos($key, 'Others') !== false && strpos($key, 'Model') !== false) {
                    $arr['C_Model'] = $value;
                } else if (strpos($key, 'Product_Name') !== false) {
                    $newKey = "E_Product model";
                    $arr['C_Model'] = $value;
                } else if (strpos($key, 'MOB_SMP') !== false) {
                    $newKey = "H_MOB SMP";
                    $arr[$newKey] = $value;
                }
            }
            $newArray[] = collect($arr)->sortKeys()->all();
            
        }
        // return $newArray;
        $collections = $newArray;
        // return $collections;

        return view('data', compact('collections'));
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
