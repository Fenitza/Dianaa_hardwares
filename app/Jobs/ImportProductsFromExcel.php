<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
\DB::enableQueryLog();

use Illuminate\Support\Facades\DB;
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
        Log::info("🟡 Starting Excel import: {$this->filePath}");

        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($this->filePath);

        $sheet = $spreadsheet->getSheetByName('Sheet1');
        $codesSheet = $spreadsheet->getSheetByName('Codes');

        // Build SubCategory-Manufacturer mapping
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

        $headers = $sheet->rangeToArray('A5:Z5')[0];
        $highestRow = $sheet->getHighestRow();

        for ($row = 6; $row <= $highestRow; $row++) {
            try {
                $rowData = array_combine($headers, $sheet->rangeToArray("A{$row}:Z{$row}")[0]);
                Log::debug("🔍 Row {$row} raw data: ", $rowData);

                $errors = [];

                $sku = trim($rowData['Part Number'] ?? '');
                if (!$sku) {
                    $errors[] = "Missing Part Number (SKU)";
                }

                $subcatName = strtolower(trim($rowData['Subcategory'] ?? ''));
                $manufName = strtolower(trim($rowData['Manufacturer'] ?? ''));
                $mapKey = $subcatName . '||' . $manufName;
                $mappedIds = $codeMap[$mapKey] ?? null;

                if (!$subcatName) $errors[] = "Missing Subcategory";
                if (!$manufName) $errors[] = "Missing Manufacturer";
                if ($subcatName && $manufName && !$mappedIds) {
                    $errors[] = "Mapping not found for '{$subcatName}' and '{$manufName}'";
                }

                if (count($errors)) {
                    Log::warning("⚠️ Row {$row} skipped: " . implode('; ', $errors));
                    continue;
                }

                $productData = [
                    'sku' => $sku,
                    'description' => trim($rowData['Item Description'] ?? ''),
                    'ManufacturerID' => $mappedIds['ManufacturerID'],
                    'SubCategoryID' => $mappedIds['SubCategoryID'],
                    'standard' => trim($rowData['Standard ISO'] ?? ''),
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
                Log::info("✅ Row {$row} imported with SKU: {$sku}");

            } catch (\Exception $e) {
                Log::error("❌ Row {$row} failed: " . $e->getMessage());
            }
        }

        Log::info("✅ Excel import completed: {$this->filePath}");
    }
}
