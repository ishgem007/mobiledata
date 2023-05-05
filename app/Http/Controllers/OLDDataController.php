<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use Illuminate\Http\Request;

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Excel as MaatwebsiteExcel;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


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
            $group = $item["group_smart_and_mobile"];
            $city = $item["group_Location/Q2_City_location"];
            $retailer = $item["group_Location/Q3_Shop_Name_location"];
            foreach ($group as &$value) {
                if ($city) {
                    $value['city'] = $city ?? " ";
                }
                if ($retailer) {
                    $value['retailer'] = $retailer ?? " ";
                }
            }
            $items[] = $group;
        }
        $collection = collect($items);
        $collapsed = $collection->collapse();

        $collections = $collapsed->all();

        $newArray = [];
        foreach ($collections as $collection) {
            $arr = [];
            foreach ( (array) $collection as $key => $value) {
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
                } else if (strpos($key, 'city') !== false) {
                    $newKey = "City";
                    $arr[$newKey] = $value;
                } else if (strpos($key, 'retailer') !== false) {
                    $newKey = "Retailer";
                    $arr[$newKey] = $value;
                }
            }
            $newArray[] = collect($arr)->sortKeys()->all();
            
        }
        $collections = $newArray;

        return view('data', compact('collections'));
      
    }

    public function getMonth()
    {
        return view('data/create');
    }

    public function query()
    {
        if (! request()->has('month')) {
            return view('data');
        }
        $attributes = request()->validate([
            'month' => 'required|string|min:2'
        ]);
        $formatDate = explode('-', request('month'));
        $monthName = Carbon::createFromDate($formatDate[0], $formatDate[1])->firstOfMonth()->format('FY');
        $firstDayOfMonth = Carbon::createFromDate($formatDate[0], $formatDate[1])->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $lastDayOfMonth = Carbon::createFromDate($formatDate[0], $formatDate[1])->lastOfMonth()->isoFormat('YYYY-MM-DD');
        $client = new Client();
        $response = $client->get(
            // 'https://kc.kobotoolbox.org/api/v1/data/214918?query={"$and": [{"_submission_time": {"$gte": "2019-08-01"}},{"_submission_time": {"$lt": "2019-08-31"}}] }', 
            'https://kc.kobotoolbox.org/api/v1/data/214918?query={"$and": [{"_submission_time": {"$gte": "' . $firstDayOfMonth . '"}},{"_submission_time": {"$lt": "' . $lastDayOfMonth . '"}}] }', 
            [
                'auth' => [
                    'ishgem007',
                    'ChangeIt333'
                ],
                'token' => [
                    'ed778dcd59c45b3350bc4e392a9bf989e97c0f55'
                ]
            ]
        );

        $data = $response->getBody();


        $data =  json_decode($data, true);

        $items = [];
        foreach ($data as $item) {
            $group = $item["group_smart_and_mobile"];
            $city = $item["group_Location/Q2_City_location"];
            $retailer = $item["group_Location/Q3_Shop_Name_location"];
            foreach ($group as &$value) {
                if ($city) {
                    $value['city'] = $city ?? " ";
                }
                if ($retailer) {
                    $value['retailer'] = $retailer ?? " ";
                }
            }
            $items[] = $group;
        }
        $collection = collect($items);
        $collapsed = $collection->collapse();

        $collections = $collapsed->all();

        $newArray = [];
        foreach ($collections as $collection) {
            $arr = [];
            foreach ((array) $collection as $key => $value) {
                if (strpos($key, 'Unit_Price') !== false) {
                    $newKey = "G_Unit price";
                    $arr[$newKey] = $value;
                } else if (strpos($key, 'Sales_Units') !== false) {
                    $newKey = "F_Sales units";
                    $arr[$newKey] = $value;
                } else if (strpos($key, 'Brands') !== false) {
                    $newKey = "A_Brands";
                    if (strtolower($value) != "others") {
                        $arr[$newKey] = $value;
                    }
                } else if (strpos($key, 'Enter_Brand_Name') !== false) {
                    $newKey = "B_Brand Name";
                    $arr['A_Brands'] = $value;
                } else if (strpos($key, 'Select_A') !== false) {
                    $newKey = "C_Model";
                    if (strtolower($value) != "others") {
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
                } else if (strpos($key, 'city') !== false) {
                    $newKey = "City";
                    $arr[$newKey] = $value;
                } else if (strpos($key, 'retailer') !== false) {
                    $newKey = "Retailer";
                    $arr[$newKey] = $value;
                }
            }
            $newArray[] = collect($arr)->sortKeys()->all();
        }
        $collections = $newArray;

        session(['collections' => $collections]);
        session(['month' => $monthName]);

        return view('data', compact('collections'));
    }

    public function download()
    {
        // $monthData[] = array('Retailer', 'City', 'Brand', 'Model', 'Brand + Model', 'Sales Unit', 'Unit Price', 'Sales Value');
        // foreach (session('collections') as $data) {
        //     $monthData[] = array(
        //         'Retailer' => $data['Retailer'] ?? ' ', 
        //         'City' => $data['City'] ?? ' ', 
        //         'Brand' => $data['A_Brands'] ?? ' ', 
        //         'Model' => $data['C_Model'] ?? ' ', 
        //         'Brand + Model' => ($data['A_Brands'] ?? ' ') . ($data['C_Model'] ?? ' '), 
        //         'Sales Unit' => $data['F_Sales units'] ?? ' ', 
        //         'Unit Price' => $data['G_Unit price'] ?? ' ', 
        //         'Sales Value' => number_format(($data['F_Sales units'] ?? 0) * ($data['G_Unit price'] ?? 0))
        //     );
        // }
        $monthName = session('month') . '.xlsx';
        return Excel::download(new DataExport, $monthName);
    }
}
