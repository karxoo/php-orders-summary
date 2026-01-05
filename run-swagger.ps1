# run-swagger.ps1
# Starts PHP API server and Swagger UI, then opens browser

# Path to php.exe
$phpPath = "C:\php\php.exe"

# Path to your API project (contains orders.php and openapi.yaml)
$apiPath = "C:\Users\LENOVO\Desktop\app\php-orders-summary"

# Path to Swagger UI distribution folder (contains index.html, swagger-ui.css, etc.)
$swaggerPath = "C:\swagger-ui"

# Start API server on port 8000
Start-Process powershell -ArgumentList "cd `"$apiPath`"; & `"$phpPath`" -S localhost:8000"

# Start Swagger UI server on port 8080
Start-Process powershell -ArgumentList "cd `"$swaggerPath`"; & `"$phpPath`" -S localhost:8080"

# Wait a moment for servers to start
Start-Sleep -Seconds 2

# Open Swagger UI in default browser
Start-Process "http://localhost:8080"