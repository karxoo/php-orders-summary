<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed. Use POST."]);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["error" => "Please upload a CSV file using form-data with key 'file'."]);
    exit;
}

$tmpPath = $_FILES['file']['tmp_name'];
if (!file_exists($tmpPath)) {
    http_response_code(400);
    echo json_encode(["error" => "Uploaded file not found."]);
    exit;
}

$rows = [];
if (($handle = fopen($tmpPath, "r")) === false) {
    http_response_code(400);
    echo json_encode(["error" => "Unable to open uploaded CSV file."]);
    exit;
}

$header = fgetcsv($handle, 0, ",", '"', "\\");
if ($header === false) {
    fclose($handle);
    http_response_code(400);
    echo json_encode(["error" => "CSV appears to be empty."]);
    exit;
}

$required = ["sku", "quantity", "price"];
$missing = array_diff($required, $header);
if (!empty($missing)) {
    fclose($handle);
    http_response_code(400);
    echo json_encode(["error" => "Missing required columns: " . implode(", ", $missing)]);
    exit;
}

$skuIndex = array_search("sku", $header);
$qtyIndex = array_search("quantity", $header);
$priceIndex = array_search("price", $header);

while (($data = fgetcsv($handle, 0, ",", '"', "\\")) !== false) {
    $sku = isset($data[$skuIndex]) ? trim($data[$skuIndex]) : "";
    $qty = isset($data[$qtyIndex]) ? (float)$data[$qtyIndex] : 0;
    $price = isset($data[$priceIndex]) ? (float)$data[$priceIndex] : 0;

    if ($sku === "" || $qty < 0 || $price < 0) {
        fclose($handle);
        http_response_code(400);
        echo json_encode(["error" => "Invalid row detected (empty SKU or negative values)."]);
        exit;
    }

    $rows[] = ["sku" => $sku, "quantity" => $qty, "price" => $price];
}
fclose($handle);

$totalRevenue = 0.0;
foreach ($rows as $r) {
    $totalRevenue += $r["quantity"] * $r["price"];
}
$totalRevenue = round($totalRevenue, 2);

$skuTotals = [];
foreach ($rows as $r) {
    $skuTotals[$r["sku"]] = ($skuTotals[$r["sku"]] ?? 0) + $r["quantity"];
}
uksort($skuTotals, function ($a, $b) use ($skuTotals) {
    if ($skuTotals[$a] === $skuTotals[$b]) {
        return strcmp($a, $b);
    }
    return $skuTotals[$b] <=> $skuTotals[$a];
});
$bestSku = array_key_first($skuTotals);
$bestQty = $skuTotals[$bestSku];

echo json_encode([
    "total_revenue" => $totalRevenue,
    "best_selling_sku" => [
        "sku" => $bestSku,
        "total_quantity" => (int)$bestQty
    ]
], JSON_PRETTY_PRINT);