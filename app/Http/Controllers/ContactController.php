<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contact;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Writer;


class ContactController extends Controller
{
    //index view
    public function index(){
        return view('contact.index');
    }

    // import contact function
    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv');

        $csvData = file_get_contents($file->getRealPath());
        $rows = array_map("str_getcsv", explode("\n", $csvData));

        $errorMessages = [];

        foreach ($rows as $rowIndex => $row) {
            $row = array_map(function ($field) {
                return trim($field, '"');
            }, $row);

            // Validate row data
            $validator = Validator::make($row, [
                '0' => 'required|string',
                '1' => 'required|string',
                '2' => 'required|url',
                '3' => 'required|date_format:Y-m-d',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errorMessages[] = "Row " . ($rowIndex + 1) . ": " . implode(', ', $errors);
                continue; 
            }

            // Create contacts record
            contact::create([
                'firstname' => $row[0],
                'lastname' => $row[1],
                'profile_pic' => $row[2],
                'DOB' => $row[3]
            ]);
        }

        if (!empty($errorMessages)) {
            session()->flash('errors', $errorMessages);
            return redirect()->back()->withInput();
        }

        return redirect()->back()->with('success', 'Contacts imported successfully');
    }

    //contact view
    public function contactview(){
        return view('contact.contacts');
    }

    //get contact data
    public function getContacts()
    {
        $contacts = contact::paginate(10); 
        return response()->json($contacts);
    }

    // export contact
    public function exportData()
    {
        $data = contact::all();
        $csv = Writer::createFromString(''); 
        foreach ($data as $item) {
            $csv->insertOne([$item->firstname, $item->lastname, $item->profile_pic,$item->DOB]);
        }
        $response = new StreamedResponse(function () use ($csv) {
            echo $csv->getContent();
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="data.csv"');

        return $response;
    }
}
