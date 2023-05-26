<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class Categories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.eposnowhq.com/api/v1/Category',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer U1RMVUFDSEZOVzRNRFVEQ0pXQU5IV0JSWllWMU0xUTc6Q1Y3STFVSzhJUU5MNEY4RDZRSDdJTEZCNzZLUktBVDI=',
                'Cookie: AWSALB=zgnZYZn4s38+4WwGCCQx61Xt3ymje+X5Qy42uwJOd/ExhqV695GkDG2hRNylaOFUBF5pcoz0c2nlzazOIVNwRxhA+w1qnfHPMbBoZGWpB7+HSJgZEeocsrOf/VNsV2RdJFnjqXZiD1zAlqdOdLvXcOfGUrZEQCMPW1MNK/p3T7awdB+/zrO3RVZQ1eLZgg==; AWSALBCORS=zgnZYZn4s38+4WwGCCQx61Xt3ymje+X5Qy42uwJOd/ExhqV695GkDG2hRNylaOFUBF5pcoz0c2nlzazOIVNwRxhA+w1qnfHPMbBoZGWpB7+HSJgZEeocsrOf/VNsV2RdJFnjqXZiD1zAlqdOdLvXcOfGUrZEQCMPW1MNK/p3T7awdB+/zrO3RVZQ1eLZgg=='
            ),
        ));

        $categories = curl_exec($curl);

        curl_close($curl);
        $categories = json_decode($categories, true);

        foreach ($categories as $category){
            $c = new Category();
            $c->id = $category['CategoryID'];
            $c->name = $category['Name'];
            $c->description = $category['Description'];
            $c->parent_id = $category['ParentID'];
            $c->show_on_till = $category['ShowOnTill'];
            $c->wet = $category['Wet'];
            $c->button_colour_id = $category['ButtonColourID'];
            $c->sort_position = $category['SortPosition'];
            $c->reporting_category_id = $category['ReportingCategoryID'];
            $c->nominal_code = $category['NominalCode'];
            $c->save();
        }

        return 1;
    }
}
