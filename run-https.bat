@echo off
chcp 65001 >nul
title הרצת פורטל מחשוב ב-Docker (HTTPS - Port 8001)

echo ===================================================
echo   הפעלת פורטל מחשוב ב-Docker (HTTPS Port 8001)
echo ===================================================
echo.

:: 1. יצירת תעודות SSL אוטומטיות אם אינן קיימות
powershell -ExecutionPolicy Bypass -File "%~dp0setup-ssl.ps1"
echo.

:: 2. בנייה והרצת המכולות ב-Docker Compose
echo [1/3] בונה ומריץ את המכולות ב-Docker (Port 8001 + HTTPS)...
docker compose -f "%~dp0docker-compose-https.yml" up -d --build

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo [שגיאה] ההרצה נכשלה. ודא ש-Docker Desktop פועל במחשב.
    pause
    exit /b 1
)

echo.
echo [2/3] המכולה הופעלה בהצלחה!
echo הנתונים שמורים באופן קבוע בתיקיית data/ בדיסק הפיזי.
echo.
echo [3/3] פותח את האתר בדפדפן בכתובת HTTPS...
start https://localhost:8001

echo.
echo ===================================================
echo   הפורטל פועל כעת בכתובת: https://localhost:8001
echo ===================================================
pause
