cscript C:\Windows\System32\Printing_Admin_Scripts\en-US\prndrvr.vbs -a -m "S:\SelfService\Printers\Snuit\IT5PCL6Winx64_11120EN" -i "KOAXPJ__.INF"
cscript C:\Windows\System32\Printing_Admin_Scripts\en-US\prnport.vbs -a -r 180.112.88.66 -h 180.112.88.66 -o raw
cscript C:\Windows\System32\Printing_Admin_Scripts\en-US\prnmngr.vbs -a -p "Big printer - Snunit" -m "KONICA MINOLTA C759SeriesPCL" -r 180.112.88.66
net use Z: \\180.112.100.30\sharing