### Masterpass | WIP - status

Masterpass by Mastercard is a digital wallet service that makes online shopping easy, secure, and convenient. Masterpass stores all your payment and shipping information in one central, secure location. With Masterpass, you can shop, click, and checkout faster online.


<br>  

| Masterpass EndPoints | Short Description | WIP Status |
|:-------:|:----------- |:------:|
| [getRequestToken](https://wallet.masterpass.ru/mpapiv2/GetRequestToken) | This request retrieves RequestToken of customer | ✔ |
| [login](https://wallet.masterpass.ru/masterpassapi/Login) | This is a request for Customer login | ✔ |
| [getCards](https://wallet.masterpass.ru/masterpassapi/GetCards) | This request retrieves information on all Customer cards. When there are no cards in Active, CVC2Always or Expired status
available for a Customer then success flag and empty card list array will be returned. | ✔ |
| [getCard](https://wallet.masterpass.com/) | This request retrieves information on Customer’s card | ✘ |
| [postback](https://wallet.masterpass.ru/mpapiv2/Postback) | This request must be used after SaveCard or GetCard requests for information of authorization results | ✘ |
