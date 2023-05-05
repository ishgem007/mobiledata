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
    private $firstDayOfMonth = "";
    private $lastDayOfMonth = "";
    private $october = "";
    private $month;

    public function caseSwitch()
    {
        if (!request()->has('month')) {
            return $this->displayForm();
        }

        request()->validate([
            'month' => 'required|string|min:2'
        ]);

        $this->formatDate();
        if ($this->firstDayOfMonth < Carbon::createFromDate('2019', '10')->firstOfMonth()->isoFormat('YYYY-MM-DD')) {
            return $this->query();
        } else {
            return $this->newIndex();
        }
    }
    
    public function missing()
    {
        if (!request()->has('month')) {
            return $this->displayMissingForm();
        }

        request()->validate([
            'month' => 'required|string|min:2'
        ]);

        $this->formatDate();
        $this->lastDayOfMonth = Carbon::parse($this->lastDayOfMonth)->addMonth()->isoFormat('YYYY-MM-DD');
        // return $this->query();
        return $this->newIndex();

    }
    

    public function getMonth()
    {
        return view('data/create');
    }

    public function query()
    {
        $data = $this->getDataFromApi();

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
        session(['month' => $this->month]);

        return view('data', compact('collections'));
    }

    public function download()
    {
        $monthName = session('month') . '.xlsx';
        return Excel::download(new DataExport, $monthName);
    }

    public function newIndex()
    {
        $data = $this->getDataFromApi();
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
            $temp = [];
            foreach ((array) $collection as $key => $value) {

                if (strpos($key, 'Price') !== false) {
                    $temp["G_Unit price"] = $value;
                } else if (strpos($key, 'Units') !== false) {
                    $temp["F_Sales units"] = $value;
                } else if (strpos($key, 'Brands') !== false) {
                    if (strtolower($value) != "others") {
                        $temp["A_Brands"] = $value;
                    } 
                } else if (strpos($key, 'Brand_Name') !== false) {
                    $temp['A_Brands'] = $value;
                } else if (strpos($key, 'Model') !== false) {
                    if (strtolower($value) != "others") {
                        $temp["C_Model"] = $value;
                    } 
                } else if (strpos($key, 'Model') !== false) {
                    $temp["C_Model"] = $value;
                } else if (strpos($key, 'MOB_SMP') !== false) {
                    $temp["H_MOB SMP"] = $value;
                } else if (strpos($key, 'city') !== false) {
                    $temp["City"] = $value;
                } else if (strpos($key, 'retailer') !== false) {
                    $temp["Retailer"] = $value;
                }
            }
            $newArray[] = $temp;
        }
        $collections = $newArray;
        session(['collections' => $collections]);
        session(['month' => $this->month]);

        return view('data', compact('collections'));

    }

    private function displayForm()
    {
        return view('data');
    }
    
    private function displayMissingForm()
    {
        return view('data-missing');
    }

    private function formatDate()
    {
        $formatDate = explode('-', request('month'));
        $this->month = Carbon::createFromDate($formatDate[0], $formatDate[1])->firstOfMonth()->format('FY');
        $this->firstDayOfMonth = Carbon::createFromDate($formatDate[0], $formatDate[1])->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $this->lastDayOfMonth = Carbon::createFromDate($formatDate[0], $formatDate[1])->lastOfMonth()->addDay()->isoFormat('YYYY-MM-DD');
    }

    private function getDataFromApi()
    {
        // $this->formatDate();
        $client = new Client();
        $response = $client->get(
            'https://kc.kobotoolbox.org/api/v1/data/214918?query={"$and": [{"_submission_time": {"$gte": "' . $this->firstDayOfMonth . '"}},{"_submission_time": {"$lt": "' . $this->lastDayOfMonth . '"}}] }',
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

        return json_decode($response->getBody(), true);
    }
}
