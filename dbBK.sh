#!/bin/sh

# バックアップファイルを何日分残しておくか
period=7
# バックアップファイルを保存するディレクトリ
dirpath='/home/tokoch/toko-channel.com/public_html/db_BK'

# ファイル名を定義(※ファイル名で日付がわかるようにしておきます)
filename=`date +%y%m%d`

# mysqldump実行
#mysqldump --opt --password=yamamototamura40 tokoch_video > $dirpath/$filename.sql
mysqldump -u tokoch_shuron --password=yamamototamura40 -h mysql1.minibird.netowl.jp tokoch_video > $dirpath/$filename.sql

# パーミッション変更
chmod 700 $dirpath/$filename.sql

# 古いバックアップファイルを削除
oldfile=`date --date "$period days ago" +%y%m%d`
rm -f $dirpath/$oldfile.sql
