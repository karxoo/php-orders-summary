<?php
// CLI: php main.php --input orders_data.csv --output orders_summary.json

$options = getopt("", ["input:", "output:"]);
$inputFile = $options["input"] ?? null;
$outputFile = $options["output"] ?? "orders_summary.json";

if (!$inputFile || !file_exists($inputFile)) {
    die("Error: Input CSV file not found.\n");
}

$rows = [];
if (($handle = fopen($inputFile, "r")) !== false) {
    $header = fgetcsv($handle, 0, ",", '"', "\\");
    $required = ["sku", "quantity", "price"];
    $missing = array_diff($required, $header);
    if (!empty($missing)) {
        die("Error: Missing required columns: " . implode(", ", $missing) . "\n");
    }

    $skuIndex = array_search("sku", $header);
    $qtyIndex = array_search("quantity", $header);
    $priceIndex = array_search("price", $header);

    while (($data = fgetcsv($handle, 0, ",", '"', "\\")) !== false) {
        $rows[] = [
            "sku" => trim($data[$skuIndex]),
            "quantity" => (int)$data[$qtyIndex],
            "price" => (float)$data[$priceIndex]
        ];
    }
    fclose($handle);
}

$totalRevenue = 0.0;
foreach ($rows as $row) {
    $totalRevenue += $row["quantity"] * $row["price"];
}

$skuTotals = [];
foreach ($rows as $row) {
    $skuTotals[$row["sku"]] = ($skuTotals[$row["sku"]] ?? 0) + $row["quantity"];
}
arsort($skuTotals);
$bestSku = array_key_first($skuTotals);
$bestQty = $skuTotals[$bestSku];

$result = [
    "total_revenue" => round($totalRevenue, 2),
    "best_selling_sku" => [
        "sku" => $bestSku,
        "total_quantity" => $bestQty
    ]
];

file_put_contents($outputFile, json_encode($result, JSON_PRETTY_PRINT));
echo json_encode($result, JSON_PRETTY_PRINT) . "\n";