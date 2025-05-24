<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Product;
use App\Models\Manufacturer;
use App\Models\SubCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $spreadsheet = IOFactory::load($this->filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $manufacturerMap = Manufacturer::pluck('ManufacturerID', 'name')->toArray();
        $subCategoryMap = SubCategory::pluck('SubCategoryID', 'name')->toArray();
        $productImagePath = storage_path('app/public/products/');

        $highestRow = $sheet->getHighestRow();

        for ($row = 6; $row <= $highestRow; $row++) {
            $manufacturerName = trim($sheet->getCell('F' . $row)->getValue());
            $subCategoryName = trim($sheet->getCell('G' . $row)->getValue());
            $sku = trim($sheet->getCell('C' . $row)->getValue());

            $imagesRaw = $sheet->getCell('Z' . $row)->getValue(); // Adjust if needed
            $imageArray = explode("\n", $imagesRaw);
            $imagePaths = [];
            $mainImage = null;

            foreach ($imageArray as $i => $imageName) {
                $imageName = trim($imageName);
                if (!$imageName) continue;

                $srcPath = public_path('uploads/temp/' . $imageName); // adjust accordingly
                if (!file_exists($srcPath)) continue;

                $uniqueName = md5($imageName . time()) . '.' . pathinfo($srcPath, PATHINFO_EXTENSION);
                $destPath = $productImagePath . $uniqueName;

                if (copy($srcPath, $destPath)) {
                    $key = 'image_' . ($i + 1);
                    $imagePaths[$key] = 'products/' . $uniqueName;
                    if ($i == 0) $mainImage = $imagePaths[$key];
                }
            }

            $productData = [
                'sku' => $sku,
                'description' => trim($sheet->getCell('D' . $row)->getValue()),
                'chapterID' => trim($sheet->getCell('E' . $row)->getValue()),
                'ManufacturerID' => $manufacturerMap[$manufacturerName] ?? null,
                'SubCategoryID' => $subCategoryMap[$subCategoryName] ?? null,
                'standardISO' => trim($sheet->getCell('H' . $row)->getValue()),
                'grade' => trim($sheet->getCell('I' . $row)->getValue()),
                'threadType' => trim($sheet->getCell('J' . $row)->getValue()),
                'size' => trim($sheet->getCell('K' . $row)->getValue()),
                'color' => trim($sheet->getCell('L' . $row)->getValue()),
                'length' => trim($sheet->getCell('M' . $row)->getValue()),
                'type' => trim($sheet->getCell('N' . $row)->getValue()),
                'pitch' => $sheet->getCell('O' . $row)->getValue(),
                'salePrice' => $sheet->getCell('P' . $row)->getValue(),
                'discount' => $sheet->getCell('Q' . $row)->getValue(),
                'moq' => $sheet->getCell('R' . $row)->getValue(),
                'weight' => $sheet->getCell('S' . $row)->getValue(),
                'image_paths' => json_encode($imagePaths),
                'product_image' => $mainImage,
                'quantity' => 100,
                'basePrice' => 0,
                'vendorPrice' => 0,
            ];

            Product::updateOrCreate(['sku' => $sku], $productData);
        }
    }
}
