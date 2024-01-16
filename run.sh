rm -rfv esp-idf-master
rm -rfv master.zip

wget https://github.com/espressif/esp-idf/archive/refs/heads/master.zip
unzip master.zip
rm -rfv master.zip

php check_soc_csv.php >soc.csv
php check_soc_html.php >soc.html

rm -rfv esp-idf-master
