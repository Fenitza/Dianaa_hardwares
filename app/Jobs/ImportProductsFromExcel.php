<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Support\Facades\Log;

class ImportProductsFromExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        ini_set('memory_limit', '1024M');
        Log::info("Starting Excel import for file: " . $this->filePath);

        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $spreadsheet = $reader->load($this->filePath);

        $sheet = $spreadsheet->getSheetByName('Sheet1');
        $codesSheet = $spreadsheet->getSheetByName('Codes');

        // Load mapping from Codes sheet
        $codeRows = $codesSheet->toArray();
        $codeMap = [];
        foreach ($codeRows as $row) {
            if (!empty($row[0]) && !empty($row[2])) {
                $subcatKey = strtolower(trim($row[0]));
                $manufKey = strtolower(trim($row[2]));
                $codeMap[$subcatKey . '||' . $manufKey] = [
                    'SubCategoryID' => $row[1],
                    'ManufacturerID' => $row[3],
                ];
            }
        }

        $highestRow = $sheet->getHighestRow();
        $headers = $sheet->rangeToArray('A5:Z5')[0];

        for ($row = 6; $row <= $highestRow; $row++) {
            try {
                $rowData = array_combine($headers, $sheet->rangeToArray("A{$row}:Z{$row}")[0]);
                Log::debug("Row {$row} raw data", $rowData);

                $sku = trim($rowData['SKU'] ?? '');
                $subcatName = strtolower(trim($rowData['Subcategory'] ?? ''));
                $manufName = strtolower(trim($rowData['Manufacturer'] ?? ''));

                $mapKey = $subcatName . '||' . $manufName;
                $mappedIds = $codeMap[$mapKey] ?? null;

                if (!$sku) {
                    Log::warning("Row {$row} skipped: missing SKU");
                    continue;
                }

                if (!$mappedIds) {
                    Log::warning("Row {$row} skipped: mapping not found for key '{$mapKey}'");
                    continue;
                }

                $productData = [
                    'sku' => $sku,
                    'description' => trim($rowData['Description'] ?? ''),
                    'chapterID' => trim($rowData['ChapterID'] ?? ''),
                    'ManufacturerID' => $mappedIds['ManufacturerID'],
                    'SubCategoryID' => $mappedIds['SubCategoryID'],
                    'standardISO' => trim($rowData['Standard ISO'] ?? ''),
                    'grade' => trim($rowData['Grade'] ?? ''),
                    'threadType' => trim($rowData['Thread Type'] ?? ''),
                    'size' => trim($rowData['Size'] ?? ''),
                    'color' => trim($rowData['Color'] ?? ''),
                    'length' => trim($rowData['Length'] ?? ''),
                    'type' => trim($rowData['Type'] ?? ''),
                    'pitch' => $rowData['Pitch'] ?? null,
                    'salePrice' => $rowData['Sale Price'] ?? null,
                    'discount' => $rowData['Discount'] ?? null,
                    'moq' => $rowData['MOQ'] ?? null,
                    'weight' => $rowData['Weight'] ?? null,
                    'quantity' => $rowData['Quantity'] ?? 0,
                    'basePrice' => $rowData['Base Price'] ?? 0,
                    'vendorPrice' => $rowData['Vendor Price'] ?? 0,
                ];

                Product::updateOrCreate(['sku' => $sku], $productData);
                Log::info("Row {$row} imported successfully with SKU: {$sku}");

            } catch (\Exception $e) {
                Log::error("Row {$row} failed: " . $e->getMessage());
            }
        }

        Log::info("Excel import completed for file: " . $this->filePath);
    }
}
