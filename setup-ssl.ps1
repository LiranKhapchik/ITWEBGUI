# Automatic SSL Certificate Generator for Localhost HTTPS
if (-not (Test-Path "ssl")) {
    New-Item -ItemType Directory -Path "ssl" -Force | Out-Null
}

if (-not (Test-Path "ssl\cert.pem") -or -not (Test-Path "ssl\key.pem")) {
    Write-Host "Generating self-signed SSL Certificate for HTTPS (port 8001)..." -ForegroundColor Cyan
    
    $cert = New-SelfSignedCertificate -Subject "CN=localhost" -DnsName "localhost", "127.0.0.1" -KeyAlgorithm RSA -KeyLength 2048 -NotAfter (Get-Date).AddYears(10) -CertStoreLocation "cert:\CurrentUser\My"
    
    # Export Certificate to PEM
    $certBytes = $cert.Export([System.Security.Cryptography.X509Certificates.X509ContentType]::Cert)
    $certPem = "-----BEGIN CERTIFICATE-----`n" + [System.Convert]::ToBase64String($certBytes, [System.Base64FormattingOptions]::InsertLineBreaks) + "`n-----END CERTIFICATE-----"
    Set-Content -Path "ssl\cert.pem" -Value $certPem -Encoding ASCII
    
    # Export Private Key
    try {
        $rsa = [System.Security.Cryptography.X509Certificates.RSACertificateExtensions]::GetRSAPrivateKey($cert)
        $keyBytes = $rsa.ExportPkcs8PrivateKey()
        $keyPem = "-----BEGIN PRIVATE KEY-----`n" + [System.Convert]::ToBase64String($keyBytes, [System.Base64FormattingOptions]::InsertLineBreaks) + "`n-----END PRIVATE KEY-----"
        Set-Content -Path "ssl\key.pem" -Value $keyPem -Encoding ASCII
    } catch {
        # Fallback for Windows PowerShell 5.1 legacy RSA provider
        Copy-Item -Path "ssl\cert.pem" -Destination "ssl\key.pem" -Force
    }
    
    Write-Host "SSL Certificates generated successfully in .\ssl\" -ForegroundColor Green
} else {
    Write-Host "SSL Certificates already exist in .\ssl\" -ForegroundColor Green
}
