#GeoIP
GeoIP は PocketMine-MP 及び PocketMine-MP派生アプリケーションで動作するプラグインです。  
  
##コマンド
 - `/geoip <Player/Addr>`  
    - 指定したIPに関するデータを取得できます。  

##仕様
###取得可能な情報
 - IPアドレス取得  
 - ホスト名取得  
 - 国  
 - 県  
 - 市  
 - 緯度/経度  
 - タイムゾーン  
 - ISP  
(この中の幾つかの情報は信頼性がありません。)  
  
###データ取得元
データはIP-API.com([ip-api.com](http:\\ip-api.com\))のJSON APIの一部を使用しています。  
ホスト名についてはPHPの`gethostbyaddr`関数を使用しています。  
**外部サイトから取得するため若干のラグが発生する場合があります。**  

##ToDo
 - [ ] 英語版作成  
 - [ ] PHP APIの使用