# PowerShell script to extract and execute INSERT statements
$sqlFile = "backup_production_data.sql"
$insertStatements = Get-Content $sqlFile | Where-Object { $_ -like "*INSERT INTO*" }

Write-Host "Found $($insertStatements.Count) INSERT statements"

# Create a clean SQL file with only INSERT statements
$cleanInserts = @()
foreach ($statement in $insertStatements) {
    $cleanInserts += $statement.Trim()
}

# Save to a new file
$cleanInserts | Out-File -FilePath "insert_statements_only.sql" -Encoding UTF8

Write-Host "Created clean INSERT file: insert_statements_only.sql"
Write-Host "First statement:"
Write-Host $cleanInserts[0]
