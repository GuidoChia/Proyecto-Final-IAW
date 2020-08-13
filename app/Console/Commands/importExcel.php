<?php

namespace App\Console\Commands;

use App\Buy;
use App\Customer;
use App\ExtraBuy;
use App\TwelveBuy;
use App\TwentyBuy;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    private $startRow = 4;
    private $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

    /**  Get the list of rows and columns to read  */
    public function __construct()
    {
    }

    public function readCell($column, $row, $worksheetName = '')
    {

        if ($row >= $this->startRow and $row < 6) {
            if (in_array($column, $this->columns)) {
                return true;
            }
        }
        return false;
    }
}

class importExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports excel files from the public/excel directory to the database';

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
        $folderPath = public_path('excel');
        $folderContent = scandir($folderPath);
        foreach ($folderContent as $file) {
            $extension = pathinfo($file)['extension'];
            if ($extension == 'xls' or $extension == 'xlsx') {
                importExcel::importFile($folderPath . "\\" . $file);
            }
        }

        return 0;
    }

    private function importFile($file)
    {
        $inputFileType = IOFactory::identify($file);

        $customerName = basename($file, "." . strtolower($inputFileType));
        $customer = new Customer();
        $customer->name = $customerName;
        $customer->save();

        $reader = IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($file);
        $firstSheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $dataArray = $firstSheet->toArray(
            0, false, true, false
        );

        for ($i = 3; $i < count($dataArray); $i++) {
            $dateString = $dataArray[$i][0];
            $date = $this->formatDate($dateString);
            $twentyBought = $dataArray[$i][1];
            $twelveBought = $dataArray[$i][2];
            $totalPrice = $dataArray[$i][3];
            $paid = $dataArray[$i][4];
            $twentyReturned = $dataArray[$i][6];
            $twelveReturned = $dataArray[$i][8];
            $description = $dataArray[$i][11];
            $prices = $this->getPricesFromTotal($totalPrice);
            $twentyPrice = $prices[0];
            $twelvePrice = $prices[1];
            $extraPrice = $prices[2];

            $buy = new Buy();
            $buy->customer_id = $customer->id;
            $buy->date = $date;
            $buy->paid = $paid;
            $buy->save();

            if ($twentyBought != 0 or $twentyReturned) {
                $twentyBuy = new TwentyBuy();
                $twentyBuy->bought = $twentyBought;
                $twentyBuy->returned = $twentyReturned;
                $twentyBuy->price = $twentyPrice;
                $twentyBuy->buy_id = $buy->id;
                $twentyBuy->save();

            }
            if ($twelveBought != 0 or $twelveReturned) {
                $twelveBuy = new TwelveBuy();
                $twelveBuy->bought = $twelveBought;
                $twelveBuy->returned = $twelveReturned;
                $twelveBuy->price = $twelvePrice;
                $twelveBuy->buy_id = $buy->id;
                $twelveBuy->save();
            }
            if ($extraPrice != 0) {
                $extraBuy = new ExtraBuy();
                $extraBuy->price = $extraPrice;
                $extraBuy->description = $description;
                $extraBuy->buy_id = $buy->id;
                $extraBuy->save();
            }
        }
    }

    private function getPricesFromTotal($totalPrice)
    {
        if (!is_string($totalPrice)) {
            return [0, 0, intval($totalPrice)];
        } else {
            $asteriskSplit = explode("*", $totalPrice);
            $plusSplit = explode("+", $asteriskSplit[1]);
            return [intval($plusSplit[0]), intval($asteriskSplit[2]), 0];
        }
    }

    private function formatDate($dateString)
    {
        $date = date_create_from_format('d/m/Y', $dateString);
        return $date;
    }
}
